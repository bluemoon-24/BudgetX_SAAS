<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ExpenseFilter extends Component
{
    use WithPagination;

    public string $search = '';
    public string $selectedCategory = '';
    public string $dateFrom = '';
    public string $dateTo = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
    ];

    protected function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'selectedCategory' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('type', 'expense')
                        ->where(function ($query) {
                            $query->whereNull('user_id')
                                ->orWhere('user_id', auth()->id());
                        });
                }),
            ],
            'dateFrom' => ['nullable', 'date'],
            'dateTo' => ['nullable', 'date', 'after_or_equal:dateFrom'],
        ];
    }

    public function updatedSearch(): void
    {
        $this->validateOnly('search');
        $this->resetPage();
    }

    public function updatedSelectedCategory(): void
    {
        $this->validateOnly('selectedCategory');
        $this->resetPage();
    }

    public function updatedDateFrom(): void
    {
        $this->validateOnly('dateFrom');
        $this->resetPage();
    }

    public function updatedDateTo(): void
    {
        $this->validateOnly('dateTo');
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'selectedCategory', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    public function deleteExpense($expenseId)
    {
        $expense = Expense::findOrFail($expenseId);

        Gate::authorize('delete', $expense);

        $expense->delete();
        session()->flash('success', 'Expense deleted successfully.');
    }

    public function render()
    {
        $user = auth()->user();

        $categories = Category::where('type', 'expense')
            ->where(fn($q) => $q->whereNull('user_id')->orWhere('user_id', $user->id))
            ->get();

        $query = Expense::with('category')
            ->where('user_id', $user->id);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('category', function ($catQuery) {
                      $catQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if (!empty($this->selectedCategory)) {
            $query->where('category_id', $this->selectedCategory);
        }

        if (!empty($this->dateFrom)) {
            $query->whereDate('date', '>=', $this->dateFrom);
        }

        if (!empty($this->dateTo)) {
            $query->whereDate('date', '<=', $this->dateTo);
        }

        $totalFiltered = (clone $query)->sum('amount');
        $expenses = $query->latest('date')->paginate(10);

        return view('livewire.expense-filter', [
            'expenses' => $expenses,
            'categories' => $categories,
            'totalFiltered' => $totalFiltered,
        ]);
    }
}

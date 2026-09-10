<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBudgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('type', 'expense')
                        ->where(function ($query) {
                            $query->whereNull('user_id')
                                ->orWhere('user_id', $this->user()?->id);
                        });
                }),
            ],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'period' => ['required', 'in:daily,weekly,monthly,yearly'],
        ];
    }
}

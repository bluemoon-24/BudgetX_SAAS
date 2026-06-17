<?php

$controllersDir = __DIR__ . '/app/Http/Controllers/';
$apiControllersDir = __DIR__ . '/app/Http/Controllers/Api/';

if (!is_dir($apiControllersDir)) {
    mkdir($apiControllersDir, 0755, true);
}

// 1. Web Controllers
$webControllers = [
    'BudgetController' => <<<'EOT'
<?php
namespace App\Http\Controllers;
use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller {
    public function index() {
        $budgets = auth()->user()->budgets()->with('category')->paginate(10);
        return view('budgets.index', compact('budgets'));
    }
    // Basic CRUD methods to be expanded...
}
EOT,
    'ExpenseController' => <<<'EOT'
<?php
namespace App\Http\Controllers;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller {
    public function index() {
        $expenses = auth()->user()->expenses()->with('category')->orderBy('date', 'desc')->paginate(10);
        return view('expenses.index', compact('expenses'));
    }
}
EOT,
    'IncomeController' => <<<'EOT'
<?php
namespace App\Http\Controllers;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller {
    public function index() {
        $incomes = auth()->user()->incomes()->with('category')->orderBy('date', 'desc')->paginate(10);
        return view('incomes.index', compact('incomes'));
    }
}
EOT,
    'CategoryController' => <<<'EOT'
<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function index() {
        $categories = auth()->user()->categories()->paginate(10);
        return view('categories.index', compact('categories'));
    }
}
EOT,
];

foreach ($webControllers as $name => $content) {
    file_put_contents($controllersDir . $name . '.php', $content);
}

// 2. API Controllers
$apiControllers = [
    'BudgetApiController' => <<<'EOT'
<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetApiController extends Controller {
    public function index() {
        return response()->json(auth()->user()->budgets()->with('category')->get());
    }
    public function store(Request $request) {
        $validated = $request->validate(['category_id' => 'required', 'amount' => 'required|numeric', 'period' => 'required']);
        $budget = auth()->user()->budgets()->create($validated);
        return response()->json($budget, 201);
    }
}
EOT,
    'ExpenseApiController' => <<<'EOT'
<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseApiController extends Controller {
    public function index() {
        return response()->json(auth()->user()->expenses()->with('category')->get());
    }
    public function store(Request $request) {
        $validated = $request->validate(['category_id' => 'required', 'amount' => 'required|numeric', 'date' => 'required|date', 'description' => 'nullable|string']);
        $expense = auth()->user()->expenses()->create($validated);
        return response()->json($expense, 201);
    }
}
EOT,
];

foreach ($apiControllers as $name => $content) {
    file_put_contents($apiControllersDir . $name . '.php', $content);
}

// 3. Setup Routes
$webRoutesPath = __DIR__ . '/routes/web.php';
$apiRoutesPath = __DIR__ . '/routes/api.php';

$apiRoutes = <<<'EOT'
<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BudgetApiController;
use App\Http\Controllers\Api\ExpenseApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('budgets', BudgetApiController::class);
    Route::apiResource('expenses', ExpenseApiController::class);
});
EOT;
file_put_contents($apiRoutesPath, $apiRoutes);

$webRoutesAppend = <<<'EOT'

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CategoryController;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::resource('budgets', BudgetController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('incomes', IncomeController::class);
    Route::resource('categories', CategoryController::class);
});
EOT;
file_put_contents($webRoutesPath, $webRoutesAppend, FILE_APPEND);

echo "Controllers and Routes generated.\n";

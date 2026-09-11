<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display the Premium Analytics dashboard.
     * Accessible by Premium or Admin users.
     */
    public function index()
    {
        $user = auth()->user();

        $isSqlite = DB::connection()->getDriverName() === 'sqlite';
        $monthExpr = $isSqlite ? "strftime('%Y-%m', date)" : "DATE_FORMAT(date, '%Y-%m')";
        $labelExpr = $isSqlite ? "strftime('%b %Y', date)" : "DATE_FORMAT(date, '%b %Y')";

        $periodStart = now()->subMonths(5)->startOfMonth();

        $monthlyExpenses = $user->expenses()
            ->selectRaw("{$monthExpr} as month_key, {$labelExpr} as month_label, SUM(amount) as total")
            ->where('date', '>=', $periodStart)
            ->groupBy('month_key', 'month_label')
            ->orderBy('month_key')
            ->get();

        $monthlyIncomes = $user->incomes()
            ->selectRaw("{$monthExpr} as month_key, {$labelExpr} as month_label, SUM(amount) as total")
            ->where('date', '>=', $periodStart)
            ->groupBy('month_key', 'month_label')
            ->orderBy('month_key')
            ->get();

        $categoryBreakdown = $user->expenses()
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category_name, SUM(expenses.amount) as total')
            ->where('expenses.date', '>=', $periodStart)
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->get();

        $monthlyTrend = [];
        foreach (range(5, 0) as $monthOffset) {
            $date = now()->subMonths($monthOffset)->startOfMonth();
            $key = $date->format('Y-m');
            $label = $date->translatedFormat('M Y');

            $income = (float) ($monthlyIncomes->firstWhere('month_key', $key)->total ?? 0);
            $expense = (float) ($monthlyExpenses->firstWhere('month_key', $key)->total ?? 0);

            $monthlyTrend[] = [
                'month_key' => $key,
                'month_label' => $label,
                'income' => $income,
                'expense' => $expense,
                'net' => $income - $expense,
            ];
        }

        $totalIncome = (float) $user->incomes()->sum('amount');
        $totalExpenses = (float) $user->expenses()->sum('amount');
        $netCashFlow = $totalIncome - $totalExpenses;
        $avgMonthlyIncome = $monthlyIncomes->sum('total') > 0 ? $monthlyIncomes->sum('total') / max($monthlyIncomes->count(), 1) : 0;
        $avgMonthlyExpense = $monthlyExpenses->sum('total') > 0 ? $monthlyExpenses->sum('total') / max($monthlyExpenses->count(), 1) : 0;
        $savingsRate = $totalIncome > 0 ? ($netCashFlow / $totalIncome) * 100 : 0;
        $topCategory = $categoryBreakdown->first();

        $alerts = $this->calculateOverspendingAlerts($user->id);

        return view('analytics.index', [
            'monthlyExpenses' => json_encode($monthlyExpenses),
            'monthlyIncomes' => json_encode($monthlyIncomes),
            'categoryBreakdown' => json_encode($categoryBreakdown),
            'monthlyTrend' => json_encode($monthlyTrend),
            'alerts' => $alerts,
            'summary' => [
                'total_income' => $totalIncome,
                'total_expenses' => $totalExpenses,
                'net_cash_flow' => $netCashFlow,
                'savings_rate' => $savingsRate,
                'avg_monthly_income' => $avgMonthlyIncome,
                'avg_monthly_expense' => $avgMonthlyExpense,
                'top_category' => $topCategory ? $topCategory->category_name : null,
                'top_category_total' => $topCategory ? (float) $topCategory->total : 0,
            ],
        ]);
    }

    /**
     * Compute rule-based overspending alerts
     */
    private function calculateOverspendingAlerts(int $userId): array
    {
        $currentMonthKey = now()->format('Y-m');
        $isSqlite = DB::connection()->getDriverName() === 'sqlite';
        $monthExpr = $isSqlite ? "strftime('%Y-%m', expenses.date)" : "DATE_FORMAT(expenses.date, '%Y-%m')";

        $rows = DB::table('expenses')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->where('expenses.user_id', $userId)
            ->where('expenses.date', '>=', now()->subMonths(6)->startOfMonth())
            ->selectRaw("categories.name as category_name, {$monthExpr} as month_key, SUM(expenses.amount) as total")
            ->groupBy('categories.name', 'month_key')
            ->get();

        $data = [];
        foreach ($rows as $row) {
            $data[$row->category_name][$row->month_key] = (float) $row->total;
        }

        $alerts = [];
        foreach ($data as $category => $monthlyData) {
            $currentSpend = $monthlyData[$currentMonthKey] ?? 0;
            $history = array_filter($monthlyData, fn ($k) => $k !== $currentMonthKey, ARRAY_FILTER_USE_KEY);

            if (empty($history)) {
                continue;
            }

            $avgSpend = array_sum($history) / count($history);

            if ($avgSpend > 0 && $currentSpend > ($avgSpend * 1.5)) {
                $alerts[] = [
                    'category' => $category,
                    'current_spend' => $currentSpend,
                    'avg_spend' => $avgSpend,
                    'excess' => $currentSpend - $avgSpend,
                    'pct_over' => round((($currentSpend / $avgSpend) - 1) * 100),
                ];
            }
        }

        return $alerts;
    }
}

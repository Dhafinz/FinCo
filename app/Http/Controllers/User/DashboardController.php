<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use App\Services\GamificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        
        $gamification = $this->gamificationService->getUserProgress($user);
        
        $transactions = $user->transactions;
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
        
        $thisMonth = now()->format('Y-m');
        $monthlyTransactions = $user->transactions()
            ->whereYear('transaction_date', now()->year)
            ->whereMonth('transaction_date', now()->month)
            ->get();
        
        $monthlyIncome = $monthlyTransactions->where('type', 'income')->sum('amount');
        $monthlyExpense = $monthlyTransactions->where('type', 'expense')->sum('amount');
        
        $financialSummary = [
            'total_income' => (float) $totalIncome,
            'total_expense' => (float) $totalExpense,
            'balance' => (float) $balance,
            'monthly_income' => (float) $monthlyIncome,
            'monthly_expense' => (float) $monthlyExpense,
            'monthly_balance' => (float) ($monthlyIncome - $monthlyExpense),
        ];
        
        $recentTransactions = $user->transactions()
            ->with(['category'])
            ->latest('transaction_date')
            ->limit(10)
            ->get();
        
        $dashboardData = [
            'user' => $user,
            'gamification' => $gamification,
            'financial_summary' => $financialSummary,
            'recent_transactions' => $recentTransactions,
        ];
        
        return response()->json([
            'success' => true,
            'data' => new DashboardResource((object) array_merge([
                'id' => $user->id, 
                'name' => $user->name, 
                'username' => $user->username, 
                'email' => $user->email
            ], $dashboardData))
        ]);
    }
}
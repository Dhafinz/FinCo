<?php

namespace App\Http\Controllers;

use App\Services\GamificationService;
use Illuminate\Http\Request;

class GamificationController extends Controller
{
    protected $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        
        $gamification = $this->gamificationService->getUserProgress($user);
        
        $transactions = $user->transactions;
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        
        $financialSummary = [
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'balance' => $totalIncome - $totalExpense,
        ];
        
        $recentTransactions = $user->transactions()
            ->with('category')
            ->latest('transaction_date')
            ->limit(10)
            ->get();
        
        return view('gamification', [
            'user' => $user,
            'gamification' => $gamification,
            'financialSummary' => $financialSummary,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
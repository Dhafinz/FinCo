<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Dashboard Admin - Statistics
        $totalUsers = User::count();
        $totalTransactions = Transaction::count();
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        
        // Recent transactions
        $recentTransactions = Transaction::with(['user', 'category'])
            ->latest()
            ->limit(10)
            ->get();
        
        // Top users by XP
        $topUsers = User::with('gamificationProfile')
            ->whereHas('gamificationProfile')
            ->get()
            ->sortByDesc('gamificationProfile.total_xp')
            ->take(5);
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTransactions', 
            'totalIncome',
            'totalExpense',
            'recentTransactions',
            'topUsers'
        ));
    }
}
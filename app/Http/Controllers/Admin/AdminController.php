<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\GamificationProfile;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_transactions' => Transaction::count(),
            'total_income' => Transaction::where('type', 'income')->sum('amount'),
            'total_expense' => Transaction::where('type', 'expense')->sum('amount'),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}
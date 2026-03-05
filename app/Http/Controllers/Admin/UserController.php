<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('gamificationProfile')
            ->latest()
            ->paginate(20);
        
        return view('admin.users', compact('users'));
    }

    public function show($id)
    {
        $user = User::with(['gamificationProfile', 'transactions.category'])
            ->findOrFail($id);
        
        $totalIncome = $user->transactions->where('type', 'income')->sum('amount');
        $totalExpense = $user->transactions->where('type', 'expense')->sum('amount');
        
        return view('admin.user-detail', compact('user', 'totalIncome', 'totalExpense'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }
}
<?php

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users',
        'username' => 'required|string|unique:users',
        'password' => 'required|string|min:8',
    ]);

    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'username' => $validated['username'],
        'password' => bcrypt($validated['password']),
        'role' => 'user',
    ]);

    \App\Models\GamificationProfile::create(['user_id' => $user->id]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'token' => $token,
        'user' => $user
    ], 201);
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah'
        ], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'token' => $token,
        'user' => $user
    ]);
});

// Protected Routes (User)
Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::put('/transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
    
});

// Categories (public)
Route::get('/categories', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Category::all()
    ]);
});

// Admin Routes
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    
    $controller = \App\Http\Controllers\Admin\TransactionController::class;
    
    Route::get('/transactions', [$controller, 'index']);
    Route::post('/transactions', [$controller, 'store']);
    Route::get('/transactions/{id}', [$controller, 'show']);
    Route::put('/transactions/{id}', [$controller, 'update']);
    Route::delete('/transactions/{id}', [$controller, 'destroy']);
    Route::get('/transactions/user/{userId}', [$controller, 'byUser']);
    
});
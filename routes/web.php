<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


// Guest Routes (Only non-logged in users)
Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Auth Routes (Only logged in users)
Route::middleware(['auth', 'active'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/thresholds', 'pages.thresholds')->name('thresholds');
    
});


// Only Admin Access
Route::middleware(['auth', 'active', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('admin.dashboard');
    Route::view('/users','pages.users')->name('users');
});

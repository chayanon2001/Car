<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CarController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard แยกตาม role พร้อมตรวจสอบ user ว่า login แล้ว
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        abort(403, 'Please login first.');
    }

    return $user->role === 'admin'
        ? view('admin.admin_dashboard') 
        : view('user.user_dashboard');    
})->middleware(['auth', 'verified'])->name('dashboard');

// หน้า profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CRUD
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/cars', [CarController::class, 'index'])->name('cars.index');
    Route::post('/admin/cars', [CarController::class, 'store'])->name('cars.store');
    Route::put('/admin/cars/{car}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('/admin/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
});

require __DIR__.'/auth.php';

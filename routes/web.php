<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/index', [UserController::class, 'index'])->name('home');
    Route::get('/activity/{id}', [UserController::class, 'show'])->name('user.activity.show');
    Route::post('/activity/{id}/register', [UserController::class, 'register'])->name('user.activity.register');
});

Route::prefix('admin')
    ->middleware(['auth', 'isAdmin'])
    ->group(function () {

    });

Route::prefix('superadmin')
    ->middleware(['auth', 'isSuperAdmin'])
    ->group(function () {
        Route::get('/admin', [SuperAdminController::class, 'index'])->name('sa.admin.index');
        Route::get('/admin/create', [SuperAdminController::class, 'create'])->name('sa.admin.create');
        Route::post('/admin/store', [SuperAdminController::class, 'store'])->name('sa.admin.store');
        Route::get('/admin/{id}/edit', [SuperAdminController::class, 'edit'])->name('sa.admin.edit');
        Route::put('/admin/{id}/update', [SuperAdminController::class, 'update'])->name('sa.admin.update');
        Route::delete('/admin/{id}/delete', [SuperAdminController::class, 'destroy'])->name('sa.admin.destroy');
    });

Route::prefix('shared')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/activity', [ActivityController::class, 'index'])->name('s.activity.index');
        Route::get('/activity/create', [ActivityController::class, 'create'])->name('s.activity.create');
        Route::post('/activity/store', [ActivityController::class, 'store'])->name('s.activity.store');
        Route::get('/activity/{activity}/edit', [ActivityController::class, 'edit'])->name('s.activity.edit');
        Route::put('/activity/{activity}/update', [ActivityController::class, 'update'])->name('s.activity.update');
        Route::delete('/activity/{activity}/delete', [ActivityController::class, 'destroy'])->name('s.activity.destroy');
        Route::post('/activity/{activity}/restore', [ActivityController::class, 'restore'])->name('s.activity.restore');
        Route::get('/activity/{activity}/registered-users', [ActivityController::class, 'registeredUsers'])->name('s.activity.registeredUsers');
        Route::delete('/activity/{activity}/unregister/{user}', [ActivityController::class, 'unregisterUser'])->name('s.activity.unregister');
    });
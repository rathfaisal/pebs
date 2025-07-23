<?php

// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shared\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

// PWA Routes
Route::get('/manifest.json', function () {
    return response()->file(public_path('manifest.json'), [
        'Content-Type' => 'application/json',
    ]);
});

// User routes - Public access to view pages
Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/index', [UserController::class, 'index']);
Route::get('/activity/{id}', [UserController::class, 'show'])->name('user.activity.show');

// User routes - Authenticated actions only
Route::middleware('auth')->group(function () {
    Route::post('/activity/{id}/register', [UserController::class, 'register'])->name('user.activity.register');
    Route::post('/activity/{id}/feedback', [UserController::class, 'feedback'])->name('user.activity.feedback');
});

// Admin routes
Route::prefix('admin')
    ->middleware(['auth', 'isAdmin'])
    ->group(function () {

    });

// Super Admin routes
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

// Shared routes
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
        Route::get('/activity/{activity}/gallery', [ActivityController::class, 'gallery'])->name('s.activity.gallery');
        Route::get('/activity/{activity}/gallery/add', [ActivityController::class, 'addGalleryImage'])->name('s.activity.gallery.add');
        Route::post('/activity/{activity}/gallery/store', [ActivityController::class, 'storeGalleryImage'])->name('s.activity.gallery.store');
        Route::delete('/activity/{activity}/gallery/{gallery}/delete', [ActivityController::class, 'deleteGalleryImage'])->name('s.activity.gallery.delete');
        Route::get('/profile', [ProfileController::class, 'show'])->name('shared.profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('shared.profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('shared.profile.update');
        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });

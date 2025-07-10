<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// ⛔ Redirect ke halaman login jika akses root
Route::get('/', fn () => redirect()->route('login'));

// ✅ Auth Routes (Breeze): login, register, etc.
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| REDIRECT SETELAH LOGIN (BERDASARKAN ROLE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/redirect', function () {
    $user = Auth::user();

    return match ($user->role) {
        'superadmin' => redirect()->route('superadmin.dashboard'),
        'admin'      => redirect()->route('admin.dashboard'),
        'user'       => redirect()->route('user.dashboard'),
        default      => abort(403, 'Role tidak dikenali.'),
    };
})->name('redirect');

/*
|--------------------------------------------------------------------------
| SUPER ADMIN ROUTES
|--------------------------------------------------------------------------
| Role: superadmin (akses penuh, approval user)
*/
Route::middleware(['auth', 'role:superadmin'])->prefix('dashboard/superadmin')->name('superadmin.')->group(function () {
    Route::get('/', [SuperAdminController::class, 'index'])->name('dashboard');

    // Management User
    Route::post('/approve/{id}', [SuperAdminController::class, 'approve'])->name('approve');
    Route::delete('/reject/{id}', [SuperAdminController::class, 'reject'])->name('reject');
    Route::post('/disable/{id}', [SuperAdminController::class, 'disable'])->name('disable');
    Route::post('/enable/{id}', [SuperAdminController::class, 'enable'])->name('enable');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
| Role: admin (CRUD data softfile)
*/
Route::middleware(['auth', 'role:admin'])->prefix('dashboard/admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/store', [AdminController::class, 'store'])->name('store');
    Route::get('/edit/{softfile}', [AdminController::class, 'edit'])->name('edit');
    Route::put('/update/{softfile}', [AdminController::class, 'update'])->name('update');
    Route::delete('/delete/{softfile}', [AdminController::class, 'destroy'])->name('delete');
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
| Role: user (lihat & download softfile)
*/
Route::middleware(['auth', 'role:user'])->prefix('dashboard/user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('dashboard');
    Route::get('/preview/{softfile}', [UserController::class, 'show'])->name('preview');
    Route::get('/download/{softfile}', [UserController::class, 'download'])->name('download');
});

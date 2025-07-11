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
        'admin'      => redirect()->route('admin.index'),
        'user'       => redirect()->route('user.index'),
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
    // Dashboard
    Route::get('/', [SuperAdminController::class, 'index'])->name('dashboard');

    // Management Admin
    Route::get('/admins', [SuperAdminController::class, 'listAdmins'])->name('admins.list');
    Route::post('/create-admin', [SuperAdminController::class, 'createAdmin'])->name('create-admin');

    // Management User Approval
    Route::post('/approve/{id}', [SuperAdminController::class, 'approve'])->name('approve');
    Route::delete('/reject/{id}', [SuperAdminController::class, 'reject'])->name('reject');
    Route::post('/disable/{id}', [SuperAdminController::class, 'disable'])->name('disable');
    Route::post('/enable/{id}', [SuperAdminController::class, 'enable'])->name('enable');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Resource Controller)
|--------------------------------------------------------------------------
| Role: admin (CRUD data softfile)
*/
Route::middleware(['auth', 'role:admin'])->prefix('dashboard/admin')->name('admin.')->group(function () {
    // Route untuk index
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Resource Routes untuk Softfile (pastikan include create)
    Route::resource('softfiles', AdminController::class)->except(['show']);

    // Custom Routes
    Route::get('/preview/{id}', [AdminController::class, 'preview'])->name('preview');
    Route::get('/search', [AdminController::class, 'search'])->name('search');
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
| Role: user (lihat & download softfile)
*/
Route::middleware(['auth', 'role:user'])->prefix('dashboard/user')->name('user.')->group(function () {
    // Daftar Softfile
    Route::get('/', [UserController::class, 'index'])->name('index');

    // Preview File (GET request - tidak perlu CSRF)


    // Download File
    Route::get('/download/{id}', [UserController::class, 'download'])->name('download');

    // Live Search
    Route::get('/search', [UserController::class, 'search'])->name('search');
    Route::get('/preview/{id}/{token?}', [UserController::class, 'preview'])
        ->name('preview');
});

/*
|--------------------------------------------------------------------------
| API ROUTES untuk AJAX (Jika diperlukan)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('/check-file/{id}', [UserController::class, 'checkFile'])->name('api.check-file');
});

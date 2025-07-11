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

Route::post('/superadmin/create-admin', [SuperAdminController::class, 'createAdmin'])->name('superadmin.create-admin');
Route::middleware(['auth', 'role:superadmin'])->prefix('dashboard/superadmin')->name('superadmin.')->group(function () {
    Route::get('/', [SuperAdminController::class, 'index'])->name('dashboard');

    Route::get('/admins', [SuperAdminController::class, 'listAdmins'])->name('admins.list');
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
    Route::get('/', [AdminController::class, 'index'])->name('index'); // Ubah dari dashboard ke index
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/', [AdminController::class, 'store'])->name('store'); // Ubah dari /store ke /
    Route::get('/{softfile}/edit', [AdminController::class, 'edit'])->name('edit'); // Tambahkan /edit
    Route::get('/admin/preview/{id}', [AdminController::class, 'preview'])->name('admin.preview');
    Route::put('/{softfile}', [AdminController::class, 'update'])->name('update'); // Hapus /update
    Route::delete('/{softfile}', [AdminController::class, 'destroy'])->name('destroy'); // Ubah dari delete ke destroy
});
/*

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
| Role: user (lihat & download softfile)
*/
Route::middleware(['auth', 'role:user'])->prefix('dashboard/user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');

    // ✅ Preview file (gunakan method 'preview' yang memang ada)
    Route::get('/preview/{id}', [UserController::class, 'preview'])->name('preview');

    // ✅ Download file
    Route::get('/download/{softfile}', [UserController::class, 'download'])->name('download');

    // ✅ Live search
    Route::get('/search', [UserController::class, 'search'])->name('search');
});

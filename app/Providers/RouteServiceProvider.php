<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRoleAndStatus;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Daftar middleware alias
        Route::aliasMiddleware('role', \App\Http\Middleware\CheckRoleAndStatus::class);

        // Web route
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // API route
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    }

    public const HOME = '/redirect';
}

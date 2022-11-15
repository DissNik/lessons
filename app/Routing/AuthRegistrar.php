<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\AuthenticatedUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class AuthRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::controller(AuthenticatedUserController::class)->group(function () {
                Route::get('/login', 'create')->name('login');

                Route::post('/login', 'store')
                    ->middleware('throttle:auth');

                Route::delete('/logout', 'destroy')->name('logout');
            });

            Route::controller(RegisteredUserController::class)->group(function () {
                Route::get('/sign-up', 'create')->name('register');

                Route::post('/sign-up', 'store')
                    ->middleware('throttle:auth');
            });

            Route::controller(ForgotPasswordController::class)->group(function () {
                Route::get('/forgot-password', 'create')
                    ->middleware('guest')
                    ->name('password.request');

                Route::post('/forgot-password', 'store')
                    ->middleware('guest')
                    ->name('password.email');
            });

            Route::controller(ResetPasswordController::class)->group(function () {
                Route::get('/reset-password/{token}', 'create')
                    ->middleware('guest')
                    ->name('password.reset');

                Route::post('/reset-password', 'store')
                    ->middleware('guest')
                    ->name('password.update');
            });

            Route::controller(SocialAuthController::class)->group(function () {
                Route::get('/auth/socialite/{driver}', 'redirect')
                    ->name('socialite');

                Route::get('/auth/socialite/{driver}/callback', 'callback')
                    ->name('socialite.callback');
            });
        });
    }
}

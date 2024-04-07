<?php

use App\Http\Controllers\EmailVerificationNotificationController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {

    Route::prefix('auth')->group(function () {

        Route::withoutMiddleware('auth:sanctum')->group(function (){
            $limiter = config('fortify.limiters.login');

            Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware(array_filter([
                    'guest:'.config('fortify.guard'),
                    $limiter ? 'throttle:'.$limiter : null,
                ]));

            Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest:'.config('fortify.guard'));

            Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest:'.config('fortify.guard'))
                ->name('password.email');

            Route::post('/reset-password', [NewPasswordController::class, 'store']);
        });

        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware([
                'throttle:'.config('fortify.limiters.verification', '6,1')
            ]);

        Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class);

        Route::put('/update-password', [PasswordController::class, 'update']);

        Route::post('/logout', [LogoutController::class, 'destroy']);
    });

    Route::middleware('verified')->get('/user', function (Request $request) {
        return $request->user();
    });
});


<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/14/2024
 * @time: 11:47 AM
 */

use App\Http\Controllers\Api\V1\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\NewPasswordController;
use App\Http\Controllers\Api\V1\Auth\PasswordController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\V1\Auth\RegisterUserController;
use App\Http\Controllers\Api\V1\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    Route::withoutMiddleware('auth:sanctum')->group(function () {
        $limiter = config('fortify.limiters.login');

        Route::post('/login', [LoginController::class, 'store'])
            ->middleware(array_filter([
                'guest:' . config('fortify.guard'),
                $limiter ? 'throttle:' . $limiter : null,
            ]))
            ->name('login');

        Route::post('/register', [RegisterUserController::class, 'store'])
            ->middleware('guest:' . config('fortify.guard'))
            ->name('register');

        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->middleware('guest:' . config('fortify.guard'))
            ->name('forgot.password');

        Route::post('/reset-password', [NewPasswordController::class, 'store'])
            ->middleware('guest:' . config('fortify.guard'))
            ->name('reset.password');
    });

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware([
            'throttle:' . config('fortify.limiters.verification', '6,1')
        ])
        ->name('email.verify.notification');

    Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
        ->whereNumber('id')
        ->whereAlphaNumeric('hash')
        ->name('email.verify');

    Route::put('/update-password', [PasswordController::class, 'update'])
        ->name('update.password');

    Route::post('/logout', [LogoutController::class, 'destroy'])
        ->name('logout');
});

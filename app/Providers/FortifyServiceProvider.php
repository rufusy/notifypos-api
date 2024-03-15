<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\PasswordUpdateResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request): JsonResponse|RedirectResponse
            {
                if ($request->expectsJson()) {
                    $user = User::where('email', $request->email)->first();
                    return response()->json([
                        'message' => 'Logged in successfully',
                        'token' => $user->createToken($request->email)->plainTextToken
                    ], 200);
                }
                return redirect()->intended(Fortify::redirects('login'));
            }
        });

        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request): JsonResponse|RedirectResponse
            {
                $user = User::where('email', $request->email)->first();
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Registered successfully. Verify your email.',
                        'token' => $user->createToken($request->email)->plainTextToken
                    ], 201);
                }
                return redirect()->intended(Fortify::redirects('register'));
            }
        });

        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request): JsonResponse|RedirectResponse
            {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Logged out successfully',
                    ], 200);
                }
                return redirect(Fortify::redirects('logout', '/'));
            }
        });

        $this->app->instance(PasswordUpdateResponse::class, new class implements PasswordUpdateResponse {
            public function toResponse($request): JsonResponse|RedirectResponse
            {
                return $request->wantsJson()
                    ? response()->json(['message' => 'password updated successfully'], 200)
                    : back()->with('status', Fortify::PASSWORD_UPDATED);
            }
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}

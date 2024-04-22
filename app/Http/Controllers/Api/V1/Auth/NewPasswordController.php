<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/22/2024
 * @time: 6:16 PM
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Responses\Api\V1\Auth\FailedPasswordResetResponse;
use App\Http\Responses\Api\V1\Auth\PasswordResetResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Actions\CompletePasswordReset;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Laravel\Fortify\Fortify;

class NewPasswordController extends \Laravel\Fortify\Http\Controllers\NewPasswordController
{
    /**
     * Reset the user's password.
     *
     * @param Request $request
     * @return Responsable
     */
    public function store(Request $request): Responsable
    {
        $request->validate([
            'token' => 'required',
            Fortify::email() => 'required|email',
            'password' => 'required',
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = $this->broker()->reset(
            $request->only(Fortify::email(), 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                app(ResetsUserPasswords::class)->reset($user, $request->all());

                app(CompletePasswordReset::class)($this->guard, $user);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
            ? app(PasswordResetResponse::class)
            : app(FailedPasswordResetResponse::class);
    }
}

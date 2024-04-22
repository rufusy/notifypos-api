<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/22/2024
 * @time: 5:51 PM
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Responses\Api\V1\Auth\FailedPasswordResetLinkRequestResponse;
use App\Http\Responses\Api\V1\Auth\SuccessfulPasswordResetLinkRequestResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Fortify;

class PasswordResetLinkController extends \Laravel\Fortify\Http\Controllers\PasswordResetLinkController
{
    /**
     * Send a reset link to the given user.
     *
     * @param Request $request
     * @return Responsable
     */
    public function store(Request $request): Responsable
    {
        $request->validate([Fortify::email() => 'required|email']);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = $this->broker()->sendResetLink(
            $request->only(Fortify::email())
        );

        return $status == Password::RESET_LINK_SENT
            ? app(SuccessfulPasswordResetLinkRequestResponse::class)
            : app(FailedPasswordResetLinkRequestResponse::class);
    }
}

<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/7/2024
 * @time: 1:31 PM
 */

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Laravel\Fortify\Contracts\VerifyEmailResponse;
use Laravel\Fortify\Http\Requests\VerifyEmailRequest;

class VerifyEmailController extends \Laravel\Fortify\Http\Controllers\VerifyEmailController
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param VerifyEmailRequest $request
     * @return VerifyEmailResponse
     */
    public function __invoke(VerifyEmailRequest $request): VerifyEmailResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return app(VerifyEmailResponse::class);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return app(VerifyEmailResponse::class);
    }
}

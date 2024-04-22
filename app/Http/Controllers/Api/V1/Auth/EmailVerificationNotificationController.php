<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 3/15/2024
 * @time: 8:49 PM
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Responses\Api\V1\Auth\HasVerifiedEmailResponse;
use App\Http\Responses\Api\V1\Auth\SendVerifyEmailResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends \Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController
{
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return app(HasVerifiedEmailResponse::class);
        }

        $request->user()->sendEmailVerificationNotification();

        return app(SendVerifyEmailResponse::class);
    }
}

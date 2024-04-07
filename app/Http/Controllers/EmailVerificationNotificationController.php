<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 3/15/2024
 * @time: 8:49 PM
 */

namespace App\Http\Controllers;

use App\Http\Responses\HasVerifiedEmailResponse;
use App\Http\Responses\SendVerifyEmailResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController as BaseController;

class EmailVerificationNotificationController extends BaseController
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

<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 3/15/2024
 * @time: 10:54 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

class LogoutController extends AuthenticatedSessionController
{
    public function destroy(Request $request): LogoutResponse
    {
        auth('sanctum')->user()->currentAccessToken()->delete();

        $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return app(LogoutResponse::class);
    }
}

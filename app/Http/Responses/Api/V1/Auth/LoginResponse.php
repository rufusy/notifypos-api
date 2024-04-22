<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/16/2024
 * @time: 11:46 PM
 */

namespace App\Http\Responses\Api\V1\Auth;

use App\Models\User;
use App\Traits\ApiHttpResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Fortify;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements Responsable
{
    use ApiHttpResponse;

    public function toResponse($request): JsonResponse|RedirectResponse|Response
    {
        if ($request->expectsJson()) {
            $user = User::where('email', $request->email)->first();

            $result = [
                'token' => $user->createToken($request->email)->plainTextToken
            ];

            return $this->respondSuccess('Logged in successfully.', $result);
        }
        return redirect()->intended(Fortify::redirects('login'));
    }
}

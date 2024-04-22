<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 3/15/2024
 * @time: 9:07 PM
 */

namespace App\Http\Responses\Api\V1\Auth;

use App\Traits\ApiHttpResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Fortify;
use Symfony\Component\HttpFoundation\Response;

class SendVerifyEmailResponse implements Responsable
{
    use ApiHttpResponse;

    public function toResponse($request): JsonResponse|Response|RedirectResponse
    {
        return $request->wantsJson()
            ? $this->respondSuccess('A link to verify your email address has been sent.')
            : back()->with('status', Fortify::VERIFICATION_LINK_SENT);
    }
}

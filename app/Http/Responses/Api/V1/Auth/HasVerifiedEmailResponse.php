<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 3/15/2024
 * @time: 9:03 PM
 */

namespace App\Http\Responses\Api\V1\Auth;

use App\Traits\ApiHttpResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Fortify;
use Symfony\Component\HttpFoundation\Response;

class HasVerifiedEmailResponse implements Responsable
{
    use ApiHttpResponse;

    public function toResponse($request): JsonResponse|RedirectResponse|Response
    {
        return $request->wantsJson()
            ? $this->respondSuccess('Your email address is already verified.')
            : redirect()->intended(Fortify::redirects('email-verification'));
    }
}

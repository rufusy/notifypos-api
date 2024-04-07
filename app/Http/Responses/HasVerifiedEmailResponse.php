<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 3/15/2024
 * @time: 9:03 PM
 */

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Fortify;
use Symfony\Component\HttpFoundation\Response;

class HasVerifiedEmailResponse implements Responsable
{
    public function toResponse($request): JsonResponse|RedirectResponse|Response
    {
        return $request->wantsJson()
            ? response()->json([
                'message' => 'Your email is already verified.',
            ], 200)
            : redirect()->intended(Fortify::redirects('email-verification'));
    }
}

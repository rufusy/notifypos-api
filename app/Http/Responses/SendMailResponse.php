<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 3/15/2024
 * @time: 9:07 PM
 */

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Fortify;
use Symfony\Component\HttpFoundation\Response;

class SendMailResponse implements BaseResponse
{

    public function toResponse($request): JsonResponse|Response|RedirectResponse
    {
        return $request->wantsJson()
            ? response()->json([
                'message' => 'email verification sent',
            ], 200)
            : back()->with('status', Fortify::VERIFICATION_LINK_SENT);
    }
}

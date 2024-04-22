<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/22/2024
 * @time: 5:57 PM
 */

namespace App\Http\Responses\Api\V1\Auth;

use App\Traits\ApiHttpResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class SuccessfulPasswordResetLinkRequestResponse implements Responsable
{
    use ApiHttpResponse;

    public function toResponse($request): JsonResponse
    {
        return $this->respondSuccess('A password reset link has been sent to your registered email address.');
    }
}

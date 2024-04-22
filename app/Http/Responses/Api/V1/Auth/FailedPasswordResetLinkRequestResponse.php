<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/22/2024
 * @time: 5:58 PM
 */

namespace App\Http\Responses\Api\V1\Auth;

use App\Traits\ApiHttpResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class FailedPasswordResetLinkRequestResponse implements Responsable
{
    use ApiHttpResponse;

    public function toResponse($request): JsonResponse
    {
        return $this->respondError('A password reset link was not sent.');
    }
}

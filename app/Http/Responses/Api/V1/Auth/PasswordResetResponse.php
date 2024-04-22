<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/22/2024
 * @time: 6:43 PM
 */

namespace App\Http\Responses\Api\V1\Auth;

use App\Traits\ApiHttpResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class PasswordResetResponse implements Responsable
{
    use ApiHttpResponse;

    public function toResponse($request): JsonResponse
    {
        return $this->respondSuccess('Your password has been reset successfully.');
    }
}

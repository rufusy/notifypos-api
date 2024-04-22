<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/22/2024
 * @time: 9:22 PM
 */

namespace App\Http\Responses\Api\V1\Auth;

use App\Traits\ApiHttpResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class PasswordUpdateResponse implements Responsable
{
    use ApiHttpResponse;

    /**
     * @inheritDoc
     */
    public function toResponse($request): JsonResponse
    {
        return $this->respondSuccess('Password updated successfully.');
    }
}

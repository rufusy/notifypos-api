<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/14/2024
 * @time: 12:42 PM
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Responses\Api\V1\Auth\LoginResponse;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Requests\LoginRequest;

class LoginController extends AuthenticatedSessionController
{
    /**
     * Attempt to authenticate a new session.
     *
     * @param LoginRequest $request
     * @return mixed
     */
    public function store(LoginRequest $request): mixed
    {
        return $this->loginPipeline($request)->then(function () {
            return app(LoginResponse::class);
        });
    }
}

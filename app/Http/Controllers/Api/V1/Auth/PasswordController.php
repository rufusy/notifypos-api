<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/22/2024
 * @time: 9:18 PM
 */

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\PasswordUpdateResponse;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Laravel\Fortify\Events\PasswordUpdatedViaController;

class PasswordController extends \Laravel\Fortify\Http\Controllers\PasswordController
{
    /**
     * Update the user's password.
     *
     * @param Request $request
     * @param UpdatesUserPasswords $updater
     * @return PasswordUpdateResponse
     */
    public function update(Request $request, UpdatesUserPasswords $updater): PasswordUpdateResponse
    {
        $updater->update($request->user(), $request->all());

        event(new PasswordUpdatedViaController($request->user()));

        return app(PasswordUpdateResponse::class);
    }
}

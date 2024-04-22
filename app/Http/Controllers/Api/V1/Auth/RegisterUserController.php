<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/14/2024
 * @time: 12:48 PM
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\Person;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{
    /**
     * @param StoreUserRequest $request
     */
    public function store(StoreUserRequest $request)
    {
//        $users = User::query()->paginate($request->page_size ?? 10);
//        return $this->respondWithResourceCollection(UserResource::collection($users));

        $person = Person::select(['id', 'first_name', 'last_name', 'email'])
            ->whereEmail($request->email)->first();


        $user = User::create([
            'name' => $person->first_name . ' ' . $person->last_name,
            'email' => $person->email,
            'password' => Hash::make('password'),
            'person_id' => $person->id
        ]);

        event(new Registered($user));

//        return new UserResource($user);

        return $this->respondCreated(new UserResource($user));
    }
}

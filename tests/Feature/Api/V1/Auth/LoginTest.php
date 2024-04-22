<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/14/2024
 * @time: 12:53 PM
 */

namespace Tests\Feature\Api\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_a_user_with_valid_credentials_can_log_in()
    {
        $user = User::factory()->create();

        $payload = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->json('post', '/login', $payload);
        $response->assertStatus(200);
    }

    public function test_that_a_user_with_invalid_credentials_can_not_log_in()
    {
        $user = User::factory()->create();

        $payload = [
            'email' => $user->email,
            'password' => $user->password
        ];

        $response = $this->json('post', '/login', $payload);
        $response->assertStatus(422);
    }

    public function test_that_only_existing_users_can_log_in()
    {
        $payload = [
            'email' => 'user@app.com',
            'password' => 'password123458'
        ];

        $response = $this->json('post', '/login', $payload);
        $response->assertStatus(422);
    }
}

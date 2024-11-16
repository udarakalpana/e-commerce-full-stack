<?php

namespace Tests\Feature\UserAuthentication;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

final class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;
    public function test_admin_user_can_sign_in()
    {
        // A - Arrange test data for test case
        $user = User::factory()->create();


        $userLoginDetails = [
            'email' => $user->email,
            'password' => '12345678'
        ];

        // A - Action the test case
        $response = $this->post('api/user-sign-in', $userLoginDetails);


        // A - Assertion the test outcome
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user_first_name',
            'user_last_name',
        ]);
        $response->assertExactJson([
            'user_first_name' => $user->first_name,
            'user_last_name' => $user->last_name,
        ]);

    }

    public function test_if_user_not_existing_should_return_bad_response()
    {
        // A - Arrange
        $userLoginDetails = [
            'email' => 'kalpana@gmail.com',
            'password' => '12345678'
        ];

        // A - Action the test case
        $response = $this->post('api/user-sign-in', $userLoginDetails);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message'
        ]);
        $response->assertExactJson([
            'status' => Response::HTTP_NOT_FOUND,
            'message' => Response::$statusTexts[Response::HTTP_NOT_FOUND],
        ]);
    }
}

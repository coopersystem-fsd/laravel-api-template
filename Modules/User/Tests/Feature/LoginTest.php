<?php

namespace Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Modules\User\Entities\User;
use Modules\User\Tests\AssertsAuth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase, AssertsAuth, WithFaker;

    const LOGIN_ROUTE = 'v1/auth/login';
    const USER_ROUTE = 'v1/auth/me';
    const LOGOUT_ROUTE = 'v1/auth/logout';
    const REFRESH_ROUTE = 'v1/auth/refresh';

    public function testLoginWithNotExistentEmail()
    {
        $params = [
            'email' => $this->faker->email,
            'password' => 'secret',
        ];

        $response = $this->postJson(self::LOGIN_ROUTE, $params);

        $this->assertUnauthenticatedResponse($response);
    }

    public function testLoginWithWrongPassword()
    {
        $params = [
            'email' => $this->faker->email,
            'password' => 'secret',
        ];

        factory(User::class)->create(array_merge($params));

        $params['password'] = 'wrong_password';

        $response = $this->postJson(self::LOGIN_ROUTE, $params);

        $this->assertUnauthenticatedResponse($response);
    }

    public function testLogin()
    {
        $params = [
            'email' => $this->faker->email,
            'password' => 'secret',
        ];

        factory(User::class)->create($params);

        $response = $this->postJson(self::LOGIN_ROUTE, $params);

        $this->assertAuthenticatedResponse($response);
    }

    public function testRequestLoggedUserWithoutToken()
    {
        $response = $this->getJson(self::USER_ROUTE, []);

        $this->assertUnauthenticatedResponse($response);
    }

    public function testRequestLoggedUserWithInvalidToken()
    {
        $headers = ['Authorization' => 'Bearer invalid_token'];

        $response = $this->getJson(self::USER_ROUTE, $headers);

        $this->assertUnauthenticatedResponse($response);
    }

    public function testGetLoggedUser()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret',
        ];

        factory(User::class)->create($userData);

        $accessToken = $this->retrieveToken($userData['email'], $userData['password']);

        $headers = ['Authorization' => 'Bearer '.$accessToken];

        unset($userData['password']);

        $this->getJson(self::USER_ROUTE, $headers)
            ->assertSuccessful()
            ->assertJson($userData);
    }

    public function testLogoutWithoutToken()
    {
        $response = $this->postJson(self::LOGOUT_ROUTE, [], []);

        $this->assertUnauthenticatedResponse($response);
    }

    public function testLogoutWithInvalidToken()
    {
        $headers = ['Authorization' => 'Bearer invalid_token'];

        $response = $this->postJson(self::LOGOUT_ROUTE, [], $headers);

        $this->assertUnauthenticatedResponse($response);
    }

    public function testLogout()
    {
        $user = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret',
        ];

        factory(User::class)->create($user);

        $accessToken = $this->retrieveToken($user['email'], $user['password']);

        $headers = ['Authorization' => 'Bearer '.$accessToken];

        // Check if token is OK
        $this->getJson(self::USER_ROUTE, $headers)->assertStatus(200);

        // Logout
        $this->postJson(self::LOGOUT_ROUTE, [], $headers)->assertStatus(204);

        // Try use invalidated token
        $response = $this->getJson(self::USER_ROUTE, $headers);

        $this->assertUnauthenticatedResponse($response);
    }

    public function testRefreshTokenWithoutToken()
    {
        $response = $this->postJson(self::REFRESH_ROUTE, [], []);

        $this->assertUnauthenticatedResponse($response);
    }

    public function testRefreshTokenWithInvalidToken()
    {
        $headers = ['Authorization' => 'Bearer invalid_token'];

        $response = $this->postJson(self::REFRESH_ROUTE, [], $headers);

        $this->assertUnauthenticatedResponse($response);
    }

    public function testRefreshToken()
    {
        $user = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret',
        ];

        factory(User::class)->create($user);

        $accessToken = $this->retrieveToken($user['email'], $user['password']);

        $headers = ['Authorization' => 'Bearer '.$accessToken];

        $response = $this->postJson(self::REFRESH_ROUTE, [], $headers);

        $this->assertAuthenticatedResponse($response);
    }

    /**
     * Retrieve access token by email and password.
     *
     * @param string $email
     * @param string $password
     * @return string
     */
    private function retrieveToken(string $email, string $password)
    {
        $params = [
            'email' => $email,
            'password' => $password,
        ];

        $response = $this->postJson(self::LOGIN_ROUTE, $params);

        return json_decode($response->getContent(), true)['access_token'];
    }
}

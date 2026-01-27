<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    private AuthService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AuthService();
    }

    public function test_attempt_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $token = $this->service->attempt([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertNotNull($token);
        $this->assertIsString($token);
    }

    public function test_attempt_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $token = $this->service->attempt([
            'email' => 'test@example.com',
            'password' => 'wrong',
        ]);

        $this->assertNull($token);
    }

    public function test_get_authenticated_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $authenticatedUser = $this->service->user();

        $this->assertInstanceOf(User::class, $authenticatedUser);
        $this->assertEquals($user->id, $authenticatedUser->id);
    }

    public function test_get_token_ttl(): void
    {
        $ttl = $this->service->getTokenTTL();

        $this->assertIsInt($ttl);
        $this->assertGreaterThan(0, $ttl);
    }
}

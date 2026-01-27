<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    public function attempt(array $credenciais): ?string
    {
        $token = auth('api')->attempt($credenciais);

        return $token ?: null;
    }

    public function logout(): void
    {
        auth('api')->logout();
    }

    public function refresh(): string
    {
        return auth('api')->refresh();
    }

    public function user(): ?User
    {
        return auth('api')->user();
    }

    public function getTokenTTL(): int
    {
        return auth('api')->factory()->getTTL() * 60;
    }
}

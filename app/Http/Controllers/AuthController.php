<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    /**
     * Authenticate user and return JWT token
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credenciais = $request->only(['email', 'password']);
        $token = $this->authService->attempt($credenciais);

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'E-mail ou senha inválidos',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso',
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $this->authService->getTokenTTL(),
                'user' => new UserResource($this->authService->user()),
            ],
        ]);
    }

    /**
     * Logout user (invalidate token)
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json([
            'success' => true,
            'message' => 'Logout realizado com sucesso',
        ]);
    }

    /**
     * Refresh JWT token
     */
    public function refresh(): JsonResponse
    {
        try {
            $token = $this->authService->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Token atualizado com sucesso',
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => $this->authService->getTokenTTL(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido ou expirado',
            ], 401);
        }
    }

    /**
     * Get authenticated user data
     */
    public function me(): JsonResponse
    {
        $user = $this->authService->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuário autenticado',
            'data' => new UserResource($user),
        ]);
    }
}

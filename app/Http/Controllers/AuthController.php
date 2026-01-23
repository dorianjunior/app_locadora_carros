<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Authenticate user and return JWT token
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ], [
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'O e-mail deve ser válido',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter no mínimo :min caracteres'
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        $credenciais = $request->only(['email', 'password']);
        $token = auth('api')->attempt($credenciais);

        if ($token) {
            $user = auth('api')->user();

            return $this->successResponse([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ], 'Login realizado com sucesso');
        }

        return $this->forbiddenResponse('E-mail ou senha inválidos');
    }

    /**
     * Logout user (invalidate token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return $this->successResponse(null, 'Logout realizado com sucesso');
    }

    /**
     * Refresh JWT token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): JsonResponse
    {
        try {
            $token = auth('api')->refresh();

            return $this->successResponse([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ], 'Token atualizado com sucesso');
        } catch (\Exception $e) {
            return $this->unauthorizedResponse('Token inválido ou expirado');
        }
    }

    /**
     * Get authenticated user data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(): JsonResponse
    {
        $user = auth('api')->user();

        if (!$user) {
            return $this->unauthorizedResponse('Usuário não autenticado');
        }

        return $this->successResponse($user, 'Dados do usuário recuperados com sucesso');
    }
}

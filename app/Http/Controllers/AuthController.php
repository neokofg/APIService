<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }
    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request);
        if($token){
            return response()->json([
                'message' => 'Успешно!',
                'token' => $token,
                'status' => true
            ], ResponseAlias::HTTP_OK);
        } else {
            return response()->json([
                'message' => 'Неверный логин или пароль!',
                'status' => false
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }
    }

    public function user(): JsonResponse
    {
        $user = Auth::user()->load(['products', 'rentedProducts']);
        if($user) {
            return response()->json([
                'message' => 'Успешно!',
                'user' => $user,
                'status' => true
            ], ResponseAlias::HTTP_OK);
        } else {
            return response()->json([
                'message' => 'Произошла непредвиденная ошибка!',
                'status' => false
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $token = $this->authService->register($request);
        if($token){
            return response()->json([
                'message' => 'Успешно!',
                'token' => $token,
                'status' => true
            ], ResponseAlias::HTTP_OK);
        } else {
            return response()->json([
                'message' => 'Не удалось зарегестрировать пользователя!',
                'status' => false
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }
    }

    public function unauthorized(Request $request): JsonResponse
    {
        if(!Auth::check()) {
            return response()->json([
                'message' => 'Вы не авторизированы!',
                'status' => false
            ], ResponseAlias::HTTP_FORBIDDEN);
        } else {
            return response()->json([
                'message' => 'Произошла непредвиденная ошибка!',
                'status' => false
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }
}

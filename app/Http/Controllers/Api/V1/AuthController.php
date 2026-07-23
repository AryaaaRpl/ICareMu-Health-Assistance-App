<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterSiswaRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AuthController
 *
 * Handles API endpoints for student registration, login, and logout.
 *
 * @package App\Http\Controllers\Api\V1
 */
class AuthController extends Controller
{
    /**
     * AuthController constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(
        protected AuthService $authService
    ) {
    }

    /**
     * Register a new student.
     *
     * @param RegisterSiswaRequest $request
     * @return JsonResponse
     */
    public function register(RegisterSiswaRequest $request): JsonResponse
    {
        $user = $this->authService->registerSiswa($request->validated());

        return response()->json([
            'message' => 'Student registration successful.',
            'user' => $user,
        ], 201);
    }

    /**
     * Authenticate user and issue a token.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->ensureIsNotRateLimited();

        try {
            $credentials = $request->only('credential', 'password');
            $result = $this->authService->login($credentials);

            $request->clearRateLimiter();

            return response()->json([
                'message' => 'Login successful.',
                'user' => $result['user'],
                'token' => $result['token'],
            ], 200);
        } catch (\Throwable $e) {
            $request->hitRateLimiter();
            throw $e;
        }
    }

    /**
     * Log the user out (revoke current token).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user !== null) {
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'message' => 'Logged out successfully.',
        ], 200);
    }
}

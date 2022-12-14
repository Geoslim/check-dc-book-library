<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{LoginRequest, RegisterRequest};
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Services\Auth\AuthService;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\{Auth, DB};
use Throwable;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $roleId = Role::query()->whereSlug('reader')->pluck('id')->toArray();
            DB::beginTransaction();
                $user = $this->authService->createUser($request->validated());
                $this->authService->createProfile($user);
                $this->authService->attachRolesToUser($user, $roleId);
                $response['token'] = $this->authService->createToken($user);
            DB::commit();
            $response['user'] = UserResource::make($user->load('profile', 'roles'));

            return $this->successResponse($response, 'User created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->fatalErrorResponse($e);
        }
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            if (!Auth::attempt($request->validated())) {
                return $this->error('Invalid credentials provided');
            }

            $user = $request->user();
            $response['token'] = $this->authService->createToken($user);
            $response['user'] = UserResource::make($user->load('profile', 'roles'));
            return $this->successResponse($response, 'User logged in successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->fatalErrorResponse($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->tokens()->delete();
            return $this->success('User logged out successfully.');
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }
}

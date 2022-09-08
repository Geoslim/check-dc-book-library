<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Http\Requests\Admin\User\UpdateUserStatusRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use App\Services\AuthService;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(protected AuthService $userService)
    {
    }

    public function getUsers(): JsonResponse
    {
        return $this->successResponse(
            UserResource::collection(
                User::with('profile', 'roles')->get()
            )
        );
    }

    public function getUser(User $user): JsonResponse
    {
        return $this->successResponse(UserResource::make($user->load('profile', 'roles')));
    }

    public function createUser(CreateUserRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $user = $this->userService->createUser($data);
            $this->userService->createProfile($user);
            RoleService::attachRolesToUser($user, $data['role_id']);
            return $this->successResponse(UserResource::make($user->load('profile', 'roles')));
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    public function updateStatus(UpdateUserStatusRequest $request, User $user): JsonResponse
    {
        try {
            $user->update([
                'status' => $request->validated()['status']
            ]);
            return $this->successResponse(UserResource::make($user->load('profile', 'roles')));
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    public function updateUser(UpdateUserRequest $request, User $user): JsonResponse
    {
        try {
            $user = $this->userService->updateProfile($user, $request->except('role_id'));
            RoleService::attachRolesToUser($user, $request->input('role_id'));
            return $this->successResponse(
                UserResource::make($user->load('profile', 'roles'))
            );
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    public function deleteUser(User $user): JsonResponse
    {
        try {
            $user->delete();
            return $this->success('User deleted successfully');
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }
}

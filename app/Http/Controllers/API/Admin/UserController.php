<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{User\CreateUserRequest,
    User\UpdateUserRequest,
    User\UpdateUserStatusRequest
};
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\Auth\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserController extends Controller
{
    public function __construct(protected AuthService $userService)
    {
    }

    public function getUsers(): JsonResponse
    {
        return $this->successResponse(
            UserResource::collection(User::paginate())
        );
    }

    public function getUser(User $user): JsonResponse
    {
        return $this->successResponse(UserResource::make($user));
    }

    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function createUser(CreateUserRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            DB::beginTransaction();
                $user = $this->userService->createUser($data);
                $this->userService->createProfile($user);
                RoleService::attachRolesToUser($user, $data['role_id']);
            DB::commit();
            return $this->successResponse(UserResource::make($user));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->fatalErrorResponse($e);
        }
    }

    public function updateStatus(UpdateUserStatusRequest $request, User $user): JsonResponse
    {
        try {
            $user->update([
                'status' => $request->validated()['status']
            ]);
            return $this->successResponse(UserResource::make($user));
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    /**
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws Throwable
     */
    public function updateUser(UpdateUserRequest $request, User $user): JsonResponse
    {
        try {
            DB::beginTransaction();
                $user = $this->userService->updateProfile($user, $request->except('role_id'));
                RoleService::attachRolesToUser($user, $request->input('role_id'));
            DB::commit();
            return $this->successResponse(UserResource::make($user));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->fatalErrorResponse($e);
        }
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
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

<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function __invoke(ProfileUpdateRequest $request, AuthService $authService): JsonResponse
    {
        try {
            $user = $authService->updateProfile($request->user(), $request->validated());
            return $this->successResponse(
                UserResource::make($user->load('profile', 'roles')),
                'Profile updated successfully'
            );
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }
}

<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AccessLevel\CreateAccessLevelRequest;
use App\Http\Requests\Admin\AccessLevel\UpdateAccessLevelRequest;
use App\Http\Resources\AccessLevelResource;
use App\Models\AccessLevel;
use App\Services\Admin\AccessLevelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AccessLevelController extends Controller
{
    public function __construct(protected AccessLevelService $accessLevelService)
    {
    }

    public function getAccessLevels(): AnonymousResourceCollection
    {
        return AccessLevelResource::collection(
            AccessLevel::paginate()
        );
    }

    public function getAccessLevel(AccessLevel $accessLevel): JsonResponse
    {
        return $this->successResponse(AccessLevelResource::make($accessLevel));
    }

    public function createAccessLevel(CreateAccessLevelRequest $request): JsonResponse
    {
        try {
            return $this->successResponse(
                AccessLevelResource::make(
                    $this->accessLevelService->createAccessLevel($request->validated())
                )
            );
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    public function updateAccessLevel(UpdateAccessLevelRequest $request, AccessLevel $accessLevel): JsonResponse
    {
        try {
            $accessLevel = $this->accessLevelService->updateAccessLevel($accessLevel, $request->validated());
            return $this->successResponse(AccessLevelResource::make($accessLevel));
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    public function deleteAccessLevel(AccessLevel $accessLevel): JsonResponse
    {
        try {
            $accessLevel->delete();
            return $this->success('Access Level deleted successfully');
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }
}

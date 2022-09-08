<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Plan\CreatePlanRequest;
use App\Http\Requests\Admin\Plan\UpdatePlanRequest;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use App\Services\Admin\PlanService;
use Illuminate\Http\JsonResponse;

class PlanController extends Controller
{
    public function __construct(protected PlanService $planService)
    {
    }

    public function getPlans(): JsonResponse
    {
        return $this->successResponse(PlanResource::collection(Plan::paginate()));
    }

    public function getPlan(Plan $plan): JsonResponse
    {
        return $this->successResponse(PlanResource::make($plan));
    }

    public function createPlan(CreatePlanRequest $request): JsonResponse
    {
        try {
            $plan = $this->planService->createPlan($request->validated());
            return $this->successResponse(PlanResource::make($plan));
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    public function updatePlan(UpdatePlanRequest $request, Plan $plan): JsonResponse
    {
        try {
            $plan = $this->planService->updatePlan($plan, $request->validated());
            return $this->successResponse(PlanResource::make($plan));
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    public function deletePlan(Plan $plan): JsonResponse
    {
        try {
            $plan->delete();
            return $this->success('Plan deleted successfully');
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }
}

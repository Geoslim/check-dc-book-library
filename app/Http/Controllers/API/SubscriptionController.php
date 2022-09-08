<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Models\Plan;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SubscriptionController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $subscriptions = Subscription::whereBelongsTo($request->user())
            ->with('plan')->paginate();
        return SubscriptionResource::collection($subscriptions);
    }

    /**
     * @param SubscriptionRequest $request
     * @param SubscriptionService $subscriptionService
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(SubscriptionRequest $request, SubscriptionService $subscriptionService): JsonResponse
    {
        try {
            if ($request->user()->activeSubscription()) {
                $this->error(
                    'You already have an active subscription.',
                    Response::HTTP_EXPECTATION_FAILED
                );
            }
            $plan = Plan::whereId($request->validated()['plan_id'])->first();
            DB::beginTransaction();
                $subscription = $subscriptionService->subscribeToPlan($request->user()->id, $plan);
            DB::commit();
            return $this->successResponse(SubscriptionResource::make($subscription->load('plan')));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->fatalErrorResponse($e);
        }
    }
}

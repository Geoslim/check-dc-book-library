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
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SubscriptionController extends Controller
{
    public function __construct(protected SubscriptionService $subscriptionService)
    {
    }

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

    public function activeSubscription(Request $request): JsonResponse
    {
        return $this->successResponse(
            SubscriptionResource::make($request->user()->activeSubscription())
        );
    }

    /**
     * @param SubscriptionRequest $request
     * @return JsonResponse
     */
    public function subscribe(SubscriptionRequest $request): JsonResponse
    {
        try {
            $user = $request->user();
            $user->abortIfUserAlreadyHasASubscription();
            $plan = Plan::whereId($request->validated()['plan_id'])->first();
            $subscription = $this->subscriptionService->subscribeToAPlan($user->id, $plan);
            return $this->successResponse(
                SubscriptionResource::make($subscription->load('plan'))
            );
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    public function unsubscribe(Request $request): JsonResponse
    {
        try {
            $this->subscriptionService->unsubscribe($request->user());
            return $this->success('Subscription successfully cancelled');
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }
}

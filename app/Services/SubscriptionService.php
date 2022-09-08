<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;

class SubscriptionService
{
    /**
     * @param int $userId
     * @param Plan $plan
     * @return Subscription|Model
     */
    public function subscribeToPlan(int $userId, Plan $plan): Model|Subscription
    {
        return Subscription::create([
            'user_id' => $userId,
            'plan_id' => $plan->id,
            'price' => $plan->price,
            'duration' => $plan->duration,
            'start_date' => now(),
            'end_date' => $plan->duration != Plan::FREEMIUM ? now()->addDays((int)$plan->duration) : null,
        ]);
    }
}

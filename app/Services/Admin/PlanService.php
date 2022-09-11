<?php

namespace App\Services\Admin;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Model;

class PlanService
{
    public function createPlan(array $data): Model|Plan
    {
        return Plan::create($data)->refresh();
    }

    public function updatePlan(Plan $plan, array $data): ?Plan
    {
        $plan->update($data);
        return $plan->refresh();
    }
}

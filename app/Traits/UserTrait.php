<?php

namespace App\Traits;

use App\Models\{AccessLevel, Lending};
use Exception;
use Illuminate\Database\Eloquent\{Builder, Model};

trait UserTrait
{
    /**
     * @throws Exception
     */
    public function abortIfUserAlreadyHasASubscription(): void
    {
        if ($this->activeSubscription()) {
            throw new Exception(
                'User already has an active subscription.',
            );
        }
    }

    /**
     * @throws Exception
     */
    public function abortIfUserHasNoSubscription(): void
    {
        if (!$this->activeSubscription()) {
            throw new Exception(
                'User has no active subscription.',
            );
        }
    }

    /**
     * @throws Exception
     */
    public function abortIfUsersProfileIsNotUpdated(): void
    {
        if (is_null($this->profile->age)) {
            throw new Exception(
                'This user\'s profile needs to be updated.',
            );
        }
    }

    /**
     * @throws Exception
     */
    public function abortIfUserHasInvalidAccessLevelAndPlan($book): void
    {
        if (
            !$book->accessLevels->pluck('id')->contains($this->accessLevel()->id)
            || !$book->plans->pluck('id')->contains($this->activeSubscription()['plan_id'])
        ) {
            throw new Exception(
                'You do not have the required access level or plan to borrow this book.'
            );
        }
    }

    public function accessLevel(): Model|AccessLevel|Builder|null
    {
        if (is_null($this->profile->age)) {
            return null;
        }
        return AccessLevel::where(function ($access) {
            $access->where('min_age', '<=', $this->profile->age)
                ->where('max_age', '>=', $this->profile->age)
                ->orWhere(function ($query) {
                    return $query->where('min_age', '<=', $this->profile->age)
                        ->where('max_age', '=', null);
                });
        })->where('lending_point', '<=', $this->lendingPoints())->first();
    }

    /**
     * @throws Exception
     */
    public function activeSubscription(): Model|null|string
    {
        $subscription = $this->subscriptions()
            ->where('status', 'active')
            ->first();
        return is_null($subscription) ? null : $subscription->load('plan');
    }

    public function lendingPoints()
    {
        return Lending::whereUserId($this->id)->sum('points');
    }
}

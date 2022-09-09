<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\{Builder,
    Factories\HasFactory,
    Model,
    Relations\BelongsTo
};
use Illuminate\Support\Carbon;

/**
 * App\Models\Subscription
 *
 * @property-read User|null $user
 * @method static Builder|Subscription newModelQuery()
 * @method static Builder|Subscription newQuery()
 * @method static Builder|Subscription query()
 * @mixin Eloquent
 * @property int $id
 * @property int $user_id
 * @property int $plan_id
 * @property string $duration
 * @property string $status
 * @property string $start_date
 * @property string $end_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Subscription whereCreatedAt($value)
 * @method static Builder|Subscription whereDuration($value)
 * @method static Builder|Subscription whereEndDate($value)
 * @method static Builder|Subscription whereId($value)
 * @method static Builder|Subscription wherePlanId($value)
 * @method static Builder|Subscription whereStartDate($value)
 * @method static Builder|Subscription whereStatus($value)
 * @method static Builder|Subscription whereUpdatedAt($value)
 * @method static Builder|Subscription whereUserId($value)
 * @property string $price
 * @property-read Plan|null $plan
 * @method static Builder|Subscription wherePrice($value)
 */
class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'price',
        'start_date',
        'end_date',
        'status'
    ];

    public const STATUS = [
        'active' => 'active',
        'expired' => 'expired',
        'cancelled' => 'cancelled',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}

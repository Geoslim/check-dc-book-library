<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\{Builder,
    Collection,
    Factories\HasFactory,
    Model,
    Relations\BelongsToMany,
    Relations\HasMany};
use Illuminate\Support\Carbon;

/**
 * App\Models\Plan
 *
 * @property-read Collection|Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static Builder|Plan newModelQuery()
 * @method static Builder|Plan newQuery()
 * @method static Builder|Plan query()
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @property string $price
 * @property string $duration
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Plan whereCreatedAt($value)
 * @method static Builder|Plan whereDuration($value)
 * @method static Builder|Plan whereId($value)
 * @method static Builder|Plan whereName($value)
 * @method static Builder|Plan wherePrice($value)
 * @method static Builder|Plan whereStatus($value)
 * @method static Builder|Plan whereUpdatedAt($value)
 * @property-read Collection|Book[] $books
 * @property-read int|null $books_count
 */
class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'duration',
        'status'
    ];

    protected $casts = [
        'duration' => 'int',
    ];

    public const FREEMIUM = 0;

    public const STATUS = [
        'active' => 'active',
        'inactive' => 'inactive',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(
            Book::class,
            'book_plan',
            'plan_id',
            'book_id'
        );
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}

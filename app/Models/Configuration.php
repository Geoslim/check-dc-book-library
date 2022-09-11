<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\{Builder,
    Factories\HasFactory,
    Model
};
use Illuminate\Support\Carbon;

/**
 * App\Models\Configuration
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Configuration newModelQuery()
 * @method static Builder|Configuration newQuery()
 * @method static Builder|Configuration query()
 * @method static Builder|Configuration whereCreatedAt($value)
 * @method static Builder|Configuration whereId($value)
 * @method static Builder|Configuration whereName($value)
 * @method static Builder|Configuration whereSlug($value)
 * @method static Builder|Configuration whereUpdatedAt($value)
 * @method static Builder|Configuration whereValue($value)
 * @mixin Eloquent
 */
class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'value',
    ];

    public const ADDABLE_POINT = 'addable_lending_points';
    public const DEDUCTIBLE_POINT = 'deductible_lending_points';

    /**
     * @param string $key
     * @param mixed|null $value
     * @return mixed
     */
    public static function value(string $key, mixed $value = null): mixed
    {
        $configuration = self::whereSlug($key)->first();

        return $configuration->value ?? $value;
    }
}

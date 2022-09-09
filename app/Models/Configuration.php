<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Configuration
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereValue($value)
 * @mixin \Eloquent
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

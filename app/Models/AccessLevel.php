<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\{Builder,
    Collection,
    Factories\HasFactory,
    Model,
    Relations\BelongsToMany
};
use Illuminate\Support\Carbon;

/**
 * App\Models\AccessLevel
 *
 * @property int $id
 * @property string $name
 * @property int $min_age
 * @property int|null $max_age
 * @property int $lending_point
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Book[] $books
 * @property-read int|null $books_count
 * @method static Builder|AccessLevel newModelQuery()
 * @method static Builder|AccessLevel newQuery()
 * @method static Builder|AccessLevel query()
 * @method static Builder|AccessLevel whereCreatedAt($value)
 * @method static Builder|AccessLevel whereId($value)
 * @method static Builder|AccessLevel whereLendingPoint($value)
 * @method static Builder|AccessLevel whereMaxAge($value)
 * @method static Builder|AccessLevel whereMinAge($value)
 * @method static Builder|AccessLevel whereName($value)
 * @method static Builder|AccessLevel whereUpdatedAt($value)
 * @mixin Eloquent
 */
class AccessLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'min_age',
        'max_age',
        'lending_point'
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(
            Book::class,
            'access_level_book',
            'access_level_id',
            'book_id'
        );
    }
}

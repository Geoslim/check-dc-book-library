<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\AccessLevel
 *
 * @property int $id
 * @property string $name
 * @property int $min_age
 * @property int|null $max_age
 * @property int $lending_point
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLevel whereLendingPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLevel whereMaxAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLevel whereMinAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLevel whereUpdatedAt($value)
 * @mixin \Eloquent
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

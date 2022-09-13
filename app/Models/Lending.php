<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Factories\HasFactory, Model, Relations\BelongsTo, SoftDeletes};
use Eloquent;
use Illuminate\Support\Carbon;

/**
 * App\Models\Lending
 *
 * @property int $id
 * @property int $user_id
 * @property int $book_id
 * @property string $date_time_borrowed
 * @property string $date_time_due
 * @property string $date_time_returned
 * @property int $points
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Book|null $books
 * @property-read User|null $users
 * @method static Builder|Lending newModelQuery()
 * @method static Builder|Lending newQuery()
 * @method static Builder|Lending query()
 * @method static Builder|Lending whereBookId($value)
 * @method static Builder|Lending whereCreatedAt($value)
 * @method static Builder|Lending whereDateTimeBorrowed($value)
 * @method static Builder|Lending whereDateTimeDue($value)
 * @method static Builder|Lending whereDateTimeReturned($value)
 * @method static Builder|Lending whereId($value)
 * @method static Builder|Lending wherePoints($value)
 * @method static Builder|Lending whereUpdatedAt($value)
 * @method static Builder|Lending whereUserId($value)
 * @mixin Eloquent
 * @property string|null $status
 * @property-read Book|null $book
 * @property-read User|null $user
 * @method static Builder|Lending whereStatus($value)
 */
class Lending extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'date_time_borrowed',
        'date_time_due',
        'date_time_returned',
        'points',
        'status'
    ];

    protected $with = ['book'];

    public const STATUS = [
        'not_due' => 'not due',
        'due' => 'due',
        'returned' => 'returned',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

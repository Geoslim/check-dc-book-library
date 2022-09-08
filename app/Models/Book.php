<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $title
 * @property string $edition
 * @property string $description
 * @property string $prologue
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Collection|Tag[] $tags
 * @property-read int|null $tags_count
 * @method static BookFactory factory(...$parameters)
 * @method static Builder|Book newModelQuery()
 * @method static Builder|Book newQuery()
 * @method static Builder|Book query()
 * @method static Builder|Book whereCreatedAt($value)
 * @method static Builder|Book whereDescription($value)
 * @method static Builder|Book whereEdition($value)
 * @method static Builder|Book whereId($value)
 * @method static Builder|Book wherePrologue($value)
 * @method static Builder|Book whereStatus($value)
 * @method static Builder|Book whereTitle($value)
 * @method static Builder|Book whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|User[] $authors
 * @property-read int|null $authors_count
 * @property-read Collection|AccessLevel[] $accessLevels
 * @property-read int|null $access_levels_count
 * @property-read Collection|Plan[] $plans
 * @property-read int|null $plans_count
 */
class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'edition',
        'description',
        'prologue',
        'status'
    ];

    public const STATUS = [
        'available' => 'available',
        'borrowed' => 'borrowed',
    ];

    public function accessLevels(): BelongsToMany
    {
        return $this->belongsToMany(
            AccessLevel::class,
            'access_level_book',
            'book_id',
            'access_level_id'
        );
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'author_book',
            'book_id',
            'user_id'
        );
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'book_category',
            'book_id',
            'category_id'
        );
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(
            Plan::class,
            'book_plan',
            'book_id',
            'plan_id'
        );
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'book_tag',
            'book_id',
            'tag_id'
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'cover',
        'category_id',
    ];

    /**
     * Get all reviews associated with this book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Scope a query to filter books by title using a partial match.
     *
     * @param  string  $query  The search term to match against book titles.
     * @return void
     */
    public function scopeTitle(Builder $builder, $query)
    {
        $builder->where('title', 'LIKE', "%{$query}%");
    }

    /**
     * Scope a query to filter books by author name using a partial match.
     *
     * @param  string  $query  The search term to match against author names.
     * @return void
     */
    public function scopeAuthor(Builder $builder, $query)
    {
        $builder->where('author', 'LIKE', "%{$query}%");
    }

    /**
     * Accessor for the cover attribute.
     *
     * Converts storage-relative paths to full asset URLs,
     * while leaving external URLs unchanged.
     */
    protected function cover(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value && ! Str::startsWith($value, ['http', 'storage'])
                ? asset('storage/'.$value)
                : ($value ? asset($value) : null),
        );
    }

    /**
     * Scope a query to order books by their review count (most reviewed first).
     *
     * Optionally filters reviews within a date range before counting.
     *
     * @param  string|null  $from  Start date for the review date range filter.
     * @param  string|null  $to  End date for the review date range filter.
     */
    public function scopePopular(Builder $builder, $from = null, $to = null): Builder
    {

        return $builder->withCount([
            'reviews' => fn ($builder) => $this->range($builder, $from, $to),

        ])->orderBy('reviews_count', 'desc');
    }

    /**
     * Scope a query to only include books with at least a given number of reviews.
     *
     * @param  int  $minReview  The minimum number of reviews a book must have.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMinReview(Builder $builder, $minReview)
    {
        return $builder->having('reviews_count', '>=', $minReview);
    }

    /**
     * Scope a query to order books by their average review rating (highest first).
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToprated(Builder $builder)
    {
        return $builder->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
    }

    /**
     * Apply a date range filter to the given query builder.
     *
     * Handles three cases: only $from provided, only $to provided,
     * or both $from and $to provided (uses whereBetween).
     *
     * @param  string|null  $from  Start date for filtering.
     * @param  string|null  $to  End date for filtering.
     * @return void
     */
    private function range(Builder $builder, $from, $to)
    {
        if ($from && ! $to) {
            $builder->where('created_at', '>=', $from);
        } elseif (! $from && $to) {
            $builder->where('created_at', '<=', $to);
        } else {
            $builder->whereBetween('created_at', [$from, $to]);
        }
    }
}

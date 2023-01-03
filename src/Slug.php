<?php

namespace Hexatex\Slug;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Hexatex\Slug\Slug
 *
 * @property int $id
 * @property string $hash_id
 * @property string $slug
 * @property string $sluggable_type
 * @property int $sluggable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Hexatex\Slug\Sluggable|null $sluggable
 * @method static \Illuminate\Database\Eloquent\Builder|\Hexatex\Slug\Slug byHashId($hashId)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hexatex\Slug\Slug bySlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\Hexatex\Slug\Slug byType($sluggableType)
 * @mixin Model
 */
class Slug extends Model
{
    protected $fillable = ['slug'];

    /*
     * Accessors & Mutators
     */
    /**
     * Hash Id
     * @return Attribute
     */
    public function hashId(): Attribute
    {
        return Attribute::get(fn () => Hashids::encode($this->attributes['id']));
    }

    /*
     * Scopes
     */
    /**
     * Scope by hash_id
     * @param Builder $query
     * @param string $hashId
     * @return void
     */
    public function scopeByHashId(Builder $query, string $hashId): void
    {
        $query->where('id', Hashids::decode($hashId));
    }

    /**
     * Scope by slug
     *
     * @param Builder $query
     * @param string $slug
     * @return void
     */
    public function scopeBySlug(Builder $query, string $slug): void
    {
        $query->where('slug', $slug);
    }

    /**
     * Scope by sluggable_type
     * @param Builder $query
     * @param string $sluggableType
     * @return void
     */
    public function scopeByType(Builder $query, string $sluggableType): void
    {
        $query->where('sluggable_type', $sluggableType);
    }

    /*
     * Relationships
     */
    /**
     * Sluggable
     *
     * @return MorphTo
     */
    public function sluggable()
    {
        return $this->morphTo();
    }
}

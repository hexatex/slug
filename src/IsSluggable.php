<?php

namespace Hexatex\Slug;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Nette\NotImplementedException;

trait IsSluggable
{
    /**
     * Define a polymorphic one-to-one relationship.
     *
     * @param  string  $related
     * @param  string  $name
     * @param  string|null  $type
     * @param  string|null  $id
     * @param  string|null  $localKey
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    abstract public function morphOne($related, $name, $type = null, $id = null, $localKey = null);

    /* Accessors & Mutators */
    /**
     * Return the class definition of the Laravel JsonResource class for this model
     * @return Attribute
     */
    public function resourceClass(): ?Attribute
    {
        throw new \Hexatex\Slug\NotImplementedException('The Sluggable resourceClass method has not been implemented');
    }

    /* Public Methods */
    /**
     * Load any relationships that you want loaded by the \Hexatex\Slug\SlugController get route
     * @return void
     */
    public function loadForSlugGet(): void
    {}

    /* Relationships */
    /**
     * Slug
     * @return MorphOne
     */
    public function slug(): MorphOne
    {
        return $this->morphOne(Slug::class, 'sluggable');
    }
}

<?php

namespace Hexatex\Slug;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Hexatex\Slug\Sluggable
 *
 * @property-read string $resource_class
 * @property-read Slug $slug
 * @mixin Model
 */
interface Sluggable
{
    /* Accessors & Mutators */
    /**
     * Return the class definition of the Laravel JsonResource class for this model
     * @return Attribute
     */
    public function resourceClass(): ?Attribute;

    /* Public Methods */
    /**
     * Load any relationships that you want loaded by the \Hexatex\Slug\SlugController get route
     * @return void
     */
    public function loadForSlugGet(): void;

    /* Relationships */
    /**
     * Slug
     * @return MorphOne
     */
    public function slug(): MorphOne;
}

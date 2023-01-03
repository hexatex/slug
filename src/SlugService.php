<?php

namespace Hexatex\Slug;

class SlugService
{
    /**
     * Store a new Slug
     * @param array{slug: string} $fill
     * @param Sluggable $sluggable
     * @return Slug
     */
    public function store(array $fill, Sluggable $sluggable): Slug
    {
        $slug = new Slug($fill);
        $slug->sluggable()->associate($sluggable);
        $slug->save();

        return $slug;
    }

    /**
     * Update a Slug
     * @param array{slug: string} $fill
     * @param Slug $slug
     * @return void
     */
    public function update(array $fill, Slug $slug): void
    {
        $slug->fill($fill);
        $slug->save();
    }

    /**
     * Destroy a Slug
     * @param Slug $slug
     * @return void
     */
    public function destroy(Slug $slug): void
    {
        $slug->delete();
    }
}

<?php

namespace Hexatex\Slug;

class SlugFacade
{
    public function __construct(private SlugService $slugService)
    {}

    /**
     * Store a new Slug
     * @param array{slug: string} $fill
     * @param Sluggable $sluggable
     * @return Slug
     */
    public function store(array $fill, Sluggable $sluggable)
    {
        return $this->slugService->store($fill, $sluggable);
    }
}

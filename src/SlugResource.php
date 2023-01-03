<?php

namespace Hexatex\Slug;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Hexatex\Slug\Slug
 */
class SlugResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'hash_id' => $this->hash_id,
            'slug' => $this->slug,
            'sluggable_type' => $this->sluggable_type,

            /* Relationships */
            'sluggable' => new $this->sluggable->resource_class($this->sluggable),
        ];
    }
}

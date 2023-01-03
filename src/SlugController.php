<?php

namespace Hexatex\Slug;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class SlugController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get(Slug $slug)
    {
        $slug->sluggable->loadForSlugGet();

        return new SlugResource($slug);
    }

    public function show(Slug $slug)
    {
        $slug->sluggable->loadForSlugGet();

        return view('slug.show', ['slug' => $slug]);
    }
}

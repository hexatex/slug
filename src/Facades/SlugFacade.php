<?php

namespace Hexatex\Slug\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hexatex\Slug\SlugFacade
 */
class Slug extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Hexatex\Slug\SlugFacade::class;
    }
}

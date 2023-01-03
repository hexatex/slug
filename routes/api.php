<?php

use Illuminate\Support\Facades\Route;
use Hexatex\Slug\SlugController;

Route::get('slug/{slug}', [SlugController::class, 'get']);

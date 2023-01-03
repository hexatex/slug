# Slug

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hexatex/slug.svg?style=flat-square)](https://packagist.org/packages/hexatex/slug)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/hexatex/slug/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/hexatex/slug/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/hexatex/slug/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/hexatex/slug/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/hexatex/slug.svg?style=flat-square)](https://packagist.org/packages/hexatex/slug)

This package provides an easy way to assign slugs to multiple models and retrieve those models by their slug strings.

## Installation

You can install the package via composer:

```bash
composer require hexatex/slug
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="slug-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="slug-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="slug-views"
```

## Usage
I have included basic usage instructions as well as a full implementation. Please review the full implementation.

### Basic Instructions
The model that you would like to assign slugs to must implement the Sluggable interface.
```php
class Post extends Model implements Sluggable
{
    /**
     * Return the class definition of the Laravel JsonResource class for this model
     * @return Attribute
     */
    public function resourceClass()
    {
        return Attribute::get(fn () => PostResource::class);
    }

    /**
     * Load any relationships that you want loaded by the \Hexatex\Slug\SlugController get route
     * @return void
     */
    public function loadForSlugGet()
    {
        $this->load(['images']);
    }

    /**
     * Slug
     * @return MorphOne
     */
    public function slug(): MorphOne
    {
        return $this->morphOne(Slug::class, 'sluggable')
    }
}
```

It is recommended that you use the service class.
```php
$this->slugService->store(['slug' => $slug], $post);
```
However there is also a facade available.
```php
SlugFacade::store(['slug' => $slug], $post);
```

### Full implementation
```php
class Post extends Model implements Sluggable
{
    /*
     * Sluggable
     */
    public function resourceClass()
    {
        return Attribute::get(fn () => PostResource::class);
    }

    public function loadForSlugGet()
    {
        $this->load(['images']);
    }

    public function slug(): MorphOne
    {
        return $this->morphOne(Slug::class, 'sluggable')
    }
    
    /*
     * Relationships
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:191'],
            'body' => ['required', 'string', 'max:191'],
            'slug.slug' => ['optional', 'string', 'max:191'],
        ];
    }
}

class PostController
{
    public function __construct(private PostService $postService)
    {}

    public function store(PostRequest $request)
    {
        DB::Transaction(function () use ($request, &$post) {
            $post = $this->postService->store($request->validated());
        });
        
        $this->load($post);
        
        return new PostResource($post);
    }

    public function update(PostRequest $request, Post $post)
    {
        DB::Transaction(function () use ($request, &$post) {
            $post = $this->postService->update($request->validated(), $post);
        });
        
        $this->load($post);
        
        return new PostResource($post);
    }
    
    public function destroy(Post $post)
    {
        DB::Transaction(function () use (&$post) {
            $post = $this->postService->destroy($post);
        });
    }
    
    private function load($post)
    {
        $post->loadMissing(['slug']);
    }
}

class PostService
{
    public function __construct(private SlugService $slugService)
    {}
    
    public function store(array $fill): Post
    {
        $post = new Post($fill);
        $post->save();
        
        $this->slugService->store($fill['slug'], $post);
    }

    public function update(array $fill, Post $post): Post
    {
        $post->fill($fill);
        $post->save();
        
        $this->slugService->store($fill['slug'], $post);
    }
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Cory Baumer](https://github.com/Hexatex)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

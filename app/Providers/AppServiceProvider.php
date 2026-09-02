<?php

namespace App\Providers;

use App\Support\LaravelUuidServices;
use Illuminate\Support\ServiceProvider;
use Src\Shared\Application\Service\UuidServiceInterface;
use Src\Tag\Application\UseCase\CreateTag\CreateTag;
use Src\Tag\Application\UseCase\CreateTag\CreateTagInterface;
use Src\Tag\Domain\Factory\TagFactoryInterface;
use Src\Tag\Domain\Repository\TagRepositoryInterface;
use Src\Tag\Infrastructure\Factory\TagFactory;
use Src\Tag\Infrastructure\Repository\TagRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UuidServiceInterface::class, LaravelUuidServices::class);
        $this->app->bind(TagFactoryInterface::class, TagFactory::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(CreateTagInterface::class, CreateTag::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

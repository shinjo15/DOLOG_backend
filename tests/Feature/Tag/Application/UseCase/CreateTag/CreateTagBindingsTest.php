<?php

declare(strict_types=1);

namespace Tests\Feature\Tag\Application\UseCase\CreateTag;

use Src\Tag\Application\UseCase\CreateTag\CreateTag;
use Src\Tag\Application\UseCase\CreateTag\CreateTagInterface;
use Src\Tag\Domain\Factory\TagFactoryInterface;
use Src\Tag\Domain\Repository\TagRepositoryInterface;
use Src\Tag\Infrastructure\Factory\TagFactory;
use Src\Tag\Infrastructure\Repository\TagRepository;
use Tests\TestCase;

final class CreateTagBindingsTest extends TestCase
{
    public function test_resolves_tag_creation_interfaces(): void
    {
        $this->assertInstanceOf(TagFactory::class, $this->app->make(TagFactoryInterface::class));
        $this->assertInstanceOf(TagRepository::class, $this->app->make(TagRepositoryInterface::class));
        $this->assertInstanceOf(CreateTag::class, $this->app->make(CreateTagInterface::class));
    }
}

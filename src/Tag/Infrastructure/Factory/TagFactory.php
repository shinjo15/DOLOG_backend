<?php

declare(strict_types=1);

namespace Src\Tag\Infrastructure\Factory;

use Src\Shared\Application\Service\UuidServiceInterface;
use Src\Shared\Domain\ValueObject\Identifier\TagIdentifier;
use Src\Tag\Domain\Entity\Tag;
use Src\Tag\Domain\Factory\TagFactoryInterface;
use Src\Tag\Domain\ValueObject\TagName;

final readonly class TagFactory implements TagFactoryInterface
{
    public function __construct(
        private UuidServiceInterface $uuidService,
    ) {}

    public function create(TagName $tagName): Tag
    {
        return Tag::create(
            tagIdentifier: new TagIdentifier($this->uuidService->generate()),
            tagName: $tagName,
        );
    }
}

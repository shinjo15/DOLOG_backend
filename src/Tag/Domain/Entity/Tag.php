<?php

declare(strict_types=1);

namespace Src\Tag\Domain\Entity;

use Src\Shared\Domain\ValueObject\Identifier\TagIdentifier;
use Src\Tag\Domain\ValueObject\TagName;

final class Tag
{
    private function __construct(
        private readonly TagIdentifier $tagIdentifier,
        private readonly TagName $tagName,
    ) {}

    public static function create(
        TagIdentifier $tagIdentifier,
        TagName $tagName,
    ): self {
        return new self(
            tagIdentifier: $tagIdentifier,
            tagName: $tagName,
        );
    }

    public function tagIdentifier(): TagIdentifier
    {
        return $this->tagIdentifier;
    }

    public function tagName(): TagName
    {
        return $this->tagName;
    }
}

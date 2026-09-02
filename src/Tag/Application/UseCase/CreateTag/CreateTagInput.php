<?php

declare(strict_types=1);

namespace Src\Tag\Application\UseCase\CreateTag;

use Src\Tag\Domain\ValueObject\TagName;

final readonly class CreateTagInput implements CreateTagInputPort
{
    public function __construct(
        private TagName $tagName,
    ) {}

    public function tagName(): TagName
    {
        return $this->tagName;
    }
}

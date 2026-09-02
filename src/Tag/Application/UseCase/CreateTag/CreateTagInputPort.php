<?php

declare(strict_types=1);

namespace Src\Tag\Application\UseCase\CreateTag;

use Src\Tag\Domain\ValueObject\TagName;

interface CreateTagInputPort
{
    public function tagName(): TagName;
}

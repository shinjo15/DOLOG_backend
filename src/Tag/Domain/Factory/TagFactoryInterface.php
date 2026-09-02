<?php

declare(strict_types=1);

namespace Src\Tag\Domain\Factory;

use Src\Tag\Domain\Entity\Tag;
use Src\Tag\Domain\ValueObject\TagName;

interface TagFactoryInterface
{
    public function create(TagName $tagName): Tag;
}

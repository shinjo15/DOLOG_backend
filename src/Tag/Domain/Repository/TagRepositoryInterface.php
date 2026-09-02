<?php

declare(strict_types=1);

namespace Src\Tag\Domain\Repository;

use Src\Tag\Domain\Entity\Tag;

interface TagRepositoryInterface
{
    public function save(Tag $tag): void;
}

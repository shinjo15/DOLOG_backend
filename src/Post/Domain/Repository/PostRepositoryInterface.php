<?php

declare(strict_types=1);

namespace Src\Post\Domain\Repository;

use Src\Post\Domain\Entity\Post;

interface PostRepositoryInterface
{
    public function save(Post $post): void;
}

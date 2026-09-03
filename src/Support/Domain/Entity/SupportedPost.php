<?php

declare(strict_types=1);

namespace Src\Support\Domain\Entity;

use DateTimeImmutable;
use Src\Post\Domain\Entity\Post;

final readonly class SupportedPost
{
    public function __construct(
        private Support $support,
        private Post $post,
        private DateTimeImmutable $supportedAt,
    ) {}

    public function support(): Support
    {
        return $this->support;
    }

    public function post(): Post
    {
        return $this->post;
    }

    public function supportedAt(): DateTimeImmutable
    {
        return $this->supportedAt;
    }
}

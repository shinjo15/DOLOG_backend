<?php

declare(strict_types=1);

namespace Src\Post\Domain\Entity;

use Src\Post\Domain\ValueObject\PostCategory;
use Src\Post\Domain\ValueObject\PostLikeCount;
use Src\Post\Domain\ValueObject\PostSupportCount;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

final class Post
{
    private function __construct(
        private readonly PostIdentifier $postIdentifier,
        private readonly PostCategory $postCategory,
        private readonly PostLikeCount $postLikeCount,
        private readonly PostSupportCount $postSupportCount,
    ) {}

    public static function create(
        PostIdentifier $postIdentifier,
        PostCategory $postCategory,
        PostLikeCount $postLikeCount,
        PostSupportCount $postSupportCount,
    ): self {
        return new self(
            postIdentifier: $postIdentifier,
            postCategory: $postCategory,
            postLikeCount: $postLikeCount,
            postSupportCount: $postSupportCount,
        );
    }

    public function postIdentifier(): PostIdentifier
    {
        return $this->postIdentifier;
    }

    public function postCategory(): PostCategory
    {
        return $this->postCategory;
    }

    public function postLikeCount(): PostLikeCount
    {
        return $this->postLikeCount;
    }

    public function postSupportCount(): PostSupportCount
    {
        return $this->postSupportCount;
    }
}

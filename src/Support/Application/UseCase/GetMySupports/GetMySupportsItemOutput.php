<?php

declare(strict_types=1);

namespace Src\Support\Application\UseCase\GetMySupports;

use DateTimeImmutable;
use Src\Post\Domain\ValueObject\PostCategory;
use Src\Post\Domain\ValueObject\PostLikeCount;
use Src\Post\Domain\ValueObject\PostSupportCount;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineIdentifier;

final readonly class GetMySupportsItemOutput implements GetMySupportsItemOutputPort
{
    public function __construct(
        private PostIdentifier $postIdentifier,
        private RoutineIdentifier $routineIdentifier,
        private PostCategory $postCategory,
        private PostLikeCount $postLikeCount,
        private PostSupportCount $postSupportCount,
        private DateTimeImmutable $supportedAt,
    ) {}

    public function postIdentifier(): PostIdentifier
    {
        return $this->postIdentifier;
    }

    public function routineIdentifier(): RoutineIdentifier
    {
        return $this->routineIdentifier;
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

    public function supportedAt(): DateTimeImmutable
    {
        return $this->supportedAt;
    }
}

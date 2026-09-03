<?php

declare(strict_types=1);

namespace Src\Support\Application\Usecase\Query\GetMySupports;

final readonly class GetMySupportsItemOutput implements GetMySupportsItemOutputPort
{
    public function __construct(
        private string $postIdentifier,
        private string $routineIdentifier,
        private string $postCategory,
        private int $postLikeCount,
        private int $postSupportCount,
        private string $supportedAt,
    ) {}

    public function postIdentifier(): string
    {
        return $this->postIdentifier;
    }

    public function routineIdentifier(): string
    {
        return $this->routineIdentifier;
    }

    public function postCategory(): string
    {
        return $this->postCategory;
    }

    public function postLikeCount(): int
    {
        return $this->postLikeCount;
    }

    public function postSupportCount(): int
    {
        return $this->postSupportCount;
    }

    public function supportedAt(): string
    {
        return $this->supportedAt;
    }
}

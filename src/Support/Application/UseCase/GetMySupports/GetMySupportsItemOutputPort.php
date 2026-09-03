<?php

declare(strict_types=1);

namespace Src\Support\Application\UseCase\GetMySupports;

use DateTimeImmutable;
use Src\Post\Domain\ValueObject\PostCategory;
use Src\Post\Domain\ValueObject\PostLikeCount;
use Src\Post\Domain\ValueObject\PostSupportCount;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineIdentifier;

interface GetMySupportsItemOutputPort
{
    public function postIdentifier(): PostIdentifier;

    public function routineIdentifier(): RoutineIdentifier;

    public function postCategory(): PostCategory;

    public function postLikeCount(): PostLikeCount;

    public function postSupportCount(): PostSupportCount;

    public function supportedAt(): DateTimeImmutable;
}

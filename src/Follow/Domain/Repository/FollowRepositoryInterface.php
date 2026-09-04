<?php

declare(strict_types=1);

namespace Src\Follow\Domain\Repository;

use Src\Follow\Domain\Entity\Follow;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

interface FollowRepositoryInterface
{
    public function find(
        AccountIdentifier $followingAccountIdentifier,
        AccountIdentifier $followedAccountIdentifier,
    ): ?Follow;

    public function save(Follow $follow): void;
}

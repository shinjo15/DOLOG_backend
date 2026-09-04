<?php

declare(strict_types=1);

namespace Src\Follow\Domain\Factory;

use Src\Follow\Domain\Entity\Follow;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

interface FollowFactoryInterface
{
    public function create(
        AccountIdentifier $followingAccountIdentifier,
        AccountIdentifier $followedAccountIdentifier,
    ): Follow;
}

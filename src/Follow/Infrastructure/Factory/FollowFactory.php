<?php

declare(strict_types=1);

namespace Src\Follow\Infrastructure\Factory;

use Src\Follow\Domain\Entity\Follow;
use Src\Follow\Domain\Factory\FollowFactoryInterface;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class FollowFactory implements FollowFactoryInterface
{
    public function create(
        AccountIdentifier $followingAccountIdentifier,
        AccountIdentifier $followedAccountIdentifier,
    ): Follow {
        return new Follow(
            followingAccountIdentifier: $followingAccountIdentifier,
            followedAccountIdentifier: $followedAccountIdentifier,
        );
    }
}

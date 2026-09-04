<?php

declare(strict_types=1);

namespace Src\Account\Infrastructure\Factory;

use Src\Account\Domain\Entity\Follow;
use Src\Account\Domain\Factory\FollowFactoryInterface;
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

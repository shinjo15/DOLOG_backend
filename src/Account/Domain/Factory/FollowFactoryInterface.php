<?php

declare(strict_types=1);

namespace Src\Account\Domain\Factory;

use Src\Account\Domain\Entity\Follow;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

interface FollowFactoryInterface
{
    public function create(
        AccountIdentifier $followingAccountIdentifier,
        AccountIdentifier $followedAccountIdentifier,
    ): Follow;
}

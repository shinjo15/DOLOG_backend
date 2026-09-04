<?php

declare(strict_types=1);

namespace Src\Follow\Domain\Repository;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

interface FollowedAccountRepositoryInterface
{
    public function exists(AccountIdentifier $followedAccountIdentifier): bool;
}

<?php

declare(strict_types=1);

namespace Src\Follow\Domain\Entity;

use Src\Follow\Domain\Exception\SelfFollowException;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final readonly class Follow
{
    public function __construct(
        private AccountIdentifier $followingAccountIdentifier,
        private AccountIdentifier $followedAccountIdentifier,
    ) {
        if ($followingAccountIdentifier->value() === $followedAccountIdentifier->value()) {
            throw new SelfFollowException;
        }
    }

    public function followingAccountIdentifier(): AccountIdentifier
    {
        return $this->followingAccountIdentifier;
    }

    public function followedAccountIdentifier(): AccountIdentifier
    {
        return $this->followedAccountIdentifier;
    }
}

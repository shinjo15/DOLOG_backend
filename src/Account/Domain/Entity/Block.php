<?php

declare(strict_types=1);

namespace Src\Account\Domain\Entity;

use Src\Account\Domain\Exception\SelfBlockException;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final readonly class Block
{
    public function __construct(
        private AccountIdentifier $blockingAccountIdentifier,
        private AccountIdentifier $blockedAccountIdentifier,
    ) {
        if ($blockingAccountIdentifier->value() === $blockedAccountIdentifier->value()) {
            throw new SelfBlockException;
        }
    }

    public function blockingAccountIdentifier(): AccountIdentifier
    {
        return $this->blockingAccountIdentifier;
    }

    public function blockedAccountIdentifier(): AccountIdentifier
    {
        return $this->blockedAccountIdentifier;
    }
}

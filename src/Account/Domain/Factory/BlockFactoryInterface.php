<?php

declare(strict_types=1);

namespace Src\Account\Domain\Factory;

use Src\Account\Domain\Entity\Block;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

interface BlockFactoryInterface
{
    public function create(
        AccountIdentifier $blockingAccountIdentifier,
        AccountIdentifier $blockedAccountIdentifier,
    ): Block;
}

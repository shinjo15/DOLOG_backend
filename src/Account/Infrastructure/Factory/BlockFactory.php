<?php

declare(strict_types=1);

namespace Src\Account\Infrastructure\Factory;

use Src\Account\Domain\Entity\Block;
use Src\Account\Domain\Factory\BlockFactoryInterface;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class BlockFactory implements BlockFactoryInterface
{
    public function create(
        AccountIdentifier $blockingAccountIdentifier,
        AccountIdentifier $blockedAccountIdentifier,
    ): Block {
        return new Block(
            blockingAccountIdentifier: $blockingAccountIdentifier,
            blockedAccountIdentifier: $blockedAccountIdentifier,
        );
    }
}

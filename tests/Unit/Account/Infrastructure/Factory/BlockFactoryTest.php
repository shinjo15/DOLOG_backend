<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Infrastructure\Factory;

use PHPUnit\Framework\TestCase;
use Src\Account\Infrastructure\Factory\BlockFactory;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class BlockFactoryTest extends TestCase
{
    public function test_creates_a_block(): void
    {
        $blockingAccountIdentifier = new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87');
        $blockedAccountIdentifier = new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028');

        $block = (new BlockFactory)->create(
            blockingAccountIdentifier: $blockingAccountIdentifier,
            blockedAccountIdentifier: $blockedAccountIdentifier,
        );

        self::assertSame($blockingAccountIdentifier, $block->blockingAccountIdentifier());
        self::assertSame($blockedAccountIdentifier, $block->blockedAccountIdentifier());
    }
}

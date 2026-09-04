<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Src\Account\Domain\Entity\Block;
use Src\Account\Domain\Exception\SelfBlockException;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class BlockTest extends TestCase
{
    public function test_retains_the_blocking_and_blocked_account_identifiers(): void
    {
        $blockingAccountIdentifier = new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87');
        $blockedAccountIdentifier = new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028');

        $block = new Block(
            blockingAccountIdentifier: $blockingAccountIdentifier,
            blockedAccountIdentifier: $blockedAccountIdentifier,
        );

        self::assertSame($blockingAccountIdentifier, $block->blockingAccountIdentifier());
        self::assertSame($blockedAccountIdentifier, $block->blockedAccountIdentifier());
    }

    public function test_rejects_blocking_oneself(): void
    {
        $accountIdentifier = new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87');

        $this->expectException(SelfBlockException::class);
        $this->expectExceptionMessage('自分自身をブロックすることはできません。');

        new Block(
            blockingAccountIdentifier: $accountIdentifier,
            blockedAccountIdentifier: $accountIdentifier,
        );
    }
}

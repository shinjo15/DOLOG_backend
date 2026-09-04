<?php

declare(strict_types=1);

namespace Tests\Unit\Follow\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Src\Follow\Domain\Entity\Follow;
use Src\Follow\Domain\Exception\SelfFollowException;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class FollowTest extends TestCase
{
    public function test_retains_the_following_and_followed_account_identifiers(): void
    {
        $followingAccountIdentifier = new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87');
        $followedAccountIdentifier = new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028');

        $follow = new Follow(
            followingAccountIdentifier: $followingAccountIdentifier,
            followedAccountIdentifier: $followedAccountIdentifier,
        );

        self::assertSame($followingAccountIdentifier, $follow->followingAccountIdentifier());
        self::assertSame($followedAccountIdentifier, $follow->followedAccountIdentifier());
    }

    public function test_rejects_following_oneself(): void
    {
        $accountIdentifier = new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87');

        $this->expectException(SelfFollowException::class);
        $this->expectExceptionMessage('自分自身をフォローすることはできません。');

        new Follow(
            followingAccountIdentifier: $accountIdentifier,
            followedAccountIdentifier: $accountIdentifier,
        );
    }
}

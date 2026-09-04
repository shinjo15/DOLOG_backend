<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Follow\Infrastructure\Factory;

use PHPUnit\Framework\TestCase;
use Src\Account\Follow\Infrastructure\Factory\FollowFactory;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class FollowFactoryTest extends TestCase
{
    public function test_creates_a_follow(): void
    {
        $followingAccountIdentifier = new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87');
        $followedAccountIdentifier = new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028');

        $follow = (new FollowFactory)->create(
            followingAccountIdentifier: $followingAccountIdentifier,
            followedAccountIdentifier: $followedAccountIdentifier,
        );

        self::assertSame($followingAccountIdentifier, $follow->followingAccountIdentifier());
        self::assertSame($followedAccountIdentifier, $follow->followedAccountIdentifier());
    }
}

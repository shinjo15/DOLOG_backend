<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Src\Account\Domain\ValueObject\AccountName;
use Src\Shared\Domain\ValueObject\Base\StringValueObject;

final class AccountNameTest extends TestCase
{
    public function test_retains_a_valid_account_name(): void
    {
        $accountName = new AccountName('朝活ユーザー');

        $this->assertSame('朝活ユーザー', $accountName->value());
    }

    public function test_accepts_an_account_name_of_50_characters(): void
    {
        $accountName = new AccountName(str_repeat('あ', 50));

        $this->assertSame(str_repeat('あ', 50), $accountName->value());
    }

    public function test_rejects_an_empty_account_name(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new AccountName('');
    }

    public function test_rejects_a_blank_account_name(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new AccountName('   ');
    }

    public function test_rejects_an_account_name_longer_than_50_characters(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new AccountName(str_repeat('あ', 51));
    }

    public function test_uses_the_shared_string_value_object_base(): void
    {
        $this->assertInstanceOf(StringValueObject::class, new AccountName('朝活ユーザー'));
    }
}

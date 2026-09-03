<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Src\Account\Domain\ValueObject\AccountBio;
use Src\Shared\Domain\ValueObject\Base\StringValueObject;

final class AccountBioTest extends TestCase
{
    public function test_retains_a_valid_account_bio(): void
    {
        $accountBio = new AccountBio('朝の時間を大切にしています。');

        $this->assertSame('朝の時間を大切にしています。', $accountBio->value());
    }

    public function test_rejects_an_empty_account_bio(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new AccountBio('');
    }

    public function test_rejects_an_account_bio_containing_only_whitespace(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new AccountBio(" \t\n");
    }

    public function test_accepts_an_account_bio_of_300_characters(): void
    {
        $accountBio = new AccountBio(str_repeat('あ', 300));

        $this->assertSame(str_repeat('あ', 300), $accountBio->value());
    }

    public function test_rejects_an_account_bio_longer_than_300_characters(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new AccountBio(str_repeat('あ', 301));
    }

    public function test_uses_the_shared_string_value_object_base(): void
    {
        $this->assertInstanceOf(StringValueObject::class, new AccountBio('紹介文'));
    }
}

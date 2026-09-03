<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Domain\Entity;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Src\Account\Domain\Entity\AccountCredential;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class AccountCredentialTest extends TestCase
{
    public function test_creates_a_credential_with_an_account_identifier_and_an_opaque_hash(): void
    {
        $credential = AccountCredential::create(
            new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'),
            '$2y$12$opaque-passcode-hash',
        );

        self::assertSame('3b5581e9-16df-4879-b7d2-5d88dca6ab87', $credential->accountIdentifier()->value());
        self::assertSame('$2y$12$opaque-passcode-hash', $credential->passcodeHash());
    }

    public function test_rejects_an_empty_hash(): void
    {
        $this->expectException(InvalidArgumentException::class);

        AccountCredential::create(
            new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'),
            '',
        );
    }
}

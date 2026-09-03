<?php

declare(strict_types=1);

namespace Src\Account\Domain\Entity;

use InvalidArgumentException;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class AccountCredential
{
    private function __construct(
        private readonly AccountIdentifier $accountIdentifier,
        private readonly string $passcodeHash,
    ) {}

    public static function create(AccountIdentifier $accountIdentifier, string $passcodeHash): self
    {
        if ($passcodeHash === '') {
            throw new InvalidArgumentException('パスコードハッシュは空にできません。');
        }

        return new self($accountIdentifier, $passcodeHash);
    }

    public function accountIdentifier(): AccountIdentifier
    {
        return $this->accountIdentifier;
    }

    public function passcodeHash(): string
    {
        return $this->passcodeHash;
    }
}

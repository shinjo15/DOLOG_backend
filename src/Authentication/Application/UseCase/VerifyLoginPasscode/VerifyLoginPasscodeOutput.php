<?php

declare(strict_types=1);

namespace Src\Authentication\Application\UseCase\VerifyLoginPasscode;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final readonly class VerifyLoginPasscodeOutput
{
    private function __construct(private ?AccountIdentifier $accountIdentifier) {}

    public static function authenticated(AccountIdentifier $accountIdentifier): self
    {
        return new self($accountIdentifier);
    }

    public static function rejected(): self
    {
        return new self(null);
    }

    public function accountIdentifier(): ?AccountIdentifier
    {
        return $this->accountIdentifier;
    }
}

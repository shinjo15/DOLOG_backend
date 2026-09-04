<?php

declare(strict_types=1);

namespace Src\Account\Application\UseCase\ChangeAccountStatus;

use DateTimeImmutable;
use Src\Account\Domain\ValueObject\AccountStatus;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final readonly class ChangeAccountStatusInput implements ChangeAccountStatusInputPort
{
    public function __construct(private AccountIdentifier $accountIdentifier, private AccountStatus $status, private ?DateTimeImmutable $banUntil) {}
    public function accountIdentifier(): AccountIdentifier { return $this->accountIdentifier; }
    public function status(): AccountStatus { return $this->status; }
    public function banUntil(): ?DateTimeImmutable { return $this->banUntil; }
}

<?php

declare(strict_types=1);

namespace Src\Support\Application\UseCase\GetMySupports;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final readonly class GetMySupportsInput implements GetMySupportsInputPort
{
    public function __construct(private AccountIdentifier $accountIdentifier, private int $page, private int $perPage) {}

    public function accountIdentifier(): AccountIdentifier
    {
        return $this->accountIdentifier;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }
}

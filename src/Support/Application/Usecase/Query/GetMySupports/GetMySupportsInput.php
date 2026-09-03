<?php

declare(strict_types=1);

namespace Src\Support\Application\Usecase\Query\GetMySupports;

final readonly class GetMySupportsInput implements GetMySupportsInputPort
{
    public function __construct(
        private string $accountIdentifier,
        private int $page,
        private int $perPage,
    ) {}

    public function accountIdentifier(): string
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

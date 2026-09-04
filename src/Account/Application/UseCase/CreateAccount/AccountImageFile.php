<?php

declare(strict_types=1);

namespace Src\Account\Application\UseCase\CreateAccount;

final readonly class AccountImageFile
{
    public function __construct(
        private string $contents,
    ) {}

    public function contents(): string
    {
        return $this->contents;
    }
}

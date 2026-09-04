<?php

declare(strict_types=1);

namespace Src\Account\Application\Service;

final readonly class AccountImage
{
    public function __construct(
        private string $contents,
    ) {}

    public function contents(): string
    {
        return $this->contents;
    }
}

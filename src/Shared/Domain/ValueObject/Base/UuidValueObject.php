<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject\Base;

abstract readonly class UuidValueObject
{
    public function __construct(
        private string $value,
    ) {
        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $value) !== 1) {
            throw new \InvalidArgumentException('識別子は有効なUUID形式である必要があります。');
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}

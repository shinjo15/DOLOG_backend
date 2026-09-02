<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject\Base;

abstract readonly class IntegerValueObject
{
    public function __construct(
        private int $value,
    ) {
        $this->validate($value);
    }

    final public function value(): int
    {
        return $this->value;
    }

    final public function equals(self $other): bool
    {
        return $this::class === $other::class && $this->value === $other->value();
    }

    final public function greaterThan(self $other): bool
    {
        return $this->value > $other->value();
    }

    final public function lessThan(self $other): bool
    {
        return $this->value < $other->value();
    }

    protected function validate(int $value): void {}
}

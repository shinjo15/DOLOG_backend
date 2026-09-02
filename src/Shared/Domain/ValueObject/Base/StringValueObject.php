<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObject\Base;

abstract readonly class StringValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $this->normalize($value);
    }

    final public function value(): string
    {
        return $this->value;
    }

    final public function equals(self $other): bool
    {
        return $this::class === $other::class && $this->value() === $other->value();
    }

    protected function validate(string $value): void
    {
        if (trim($value) === '') {
            throw new \InvalidArgumentException($this->invalidMessage());
        }
    }

    protected function normalize(string $value): string
    {
        return $value;
    }

    protected function invalidMessage(): string
    {
        return '文字列の値は空白にできません。';
    }
}

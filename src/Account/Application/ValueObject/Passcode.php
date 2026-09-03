<?php

declare(strict_types=1);

namespace Src\Account\Application\ValueObject;

use InvalidArgumentException;

final readonly class Passcode
{
    public function __construct(
        private string $value,
    ) {
        $length = mb_strlen($value);

        if ($length < 8 || $length > 72) {
            throw new InvalidArgumentException('パスコードは8文字以上72文字以下で指定してください。');
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}

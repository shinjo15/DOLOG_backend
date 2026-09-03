<?php

declare(strict_types=1);

namespace Src\Authentication\Domain\ValueObject;

use InvalidArgumentException;
use Src\Shared\Domain\ValueObject\Base\StringValueObject;

final readonly class LoginPasscode extends StringValueObject
{
    protected function validate(string $value): void
    {
        parent::validate($value);

        if (preg_match('/^\d{6}$/D', $value) !== 1) {
            throw new InvalidArgumentException('ログインパスコードは6桁の数字である必要があります。');
        }
    }
}

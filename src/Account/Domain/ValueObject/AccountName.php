<?php

declare(strict_types=1);

namespace Src\Account\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\Base\StringValueObject;

final readonly class AccountName extends StringValueObject
{
    protected function validate(string $value): void
    {
        parent::validate($value);

        if (mb_strlen($value) > 50) {
            throw new \InvalidArgumentException('アカウント名は50文字以下である必要があります。');
        }
    }
}

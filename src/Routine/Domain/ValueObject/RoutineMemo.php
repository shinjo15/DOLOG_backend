<?php

declare(strict_types=1);

namespace Src\Routine\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\Base\StringValueObject;

final readonly class RoutineMemo extends StringValueObject
{
    protected function validate(string $value): void
    {
        parent::validate($value);

        if (mb_strlen($value) > 300) {
            throw new \InvalidArgumentException('ルーティンメモは300文字以下である必要があります。');
        }
    }
}

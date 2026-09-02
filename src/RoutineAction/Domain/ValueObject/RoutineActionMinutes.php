<?php

declare(strict_types=1);

namespace Src\RoutineAction\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\Base\IntegerValueObject;

final readonly class RoutineActionMinutes extends IntegerValueObject
{
    protected function validate(int $value): void
    {
        if ($value < 1) {
            throw new \InvalidArgumentException('ルーティン行動時間は1分以上である必要があります。');
        }
    }
}

<?php

declare(strict_types=1);

namespace Src\Routine\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\Base\IntegerValueObject;

final readonly class RoutineExecutionMinutes extends IntegerValueObject
{
    protected function validate(int $value): void
    {
        if ($value < 1) {
            throw new \InvalidArgumentException('ルーティンの想定所要時間は1分以上である必要があります。');
        }
    }
}

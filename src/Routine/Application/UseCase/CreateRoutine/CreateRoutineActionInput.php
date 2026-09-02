<?php

declare(strict_types=1);

namespace Src\Routine\Application\UseCase\CreateRoutine;

use Src\RoutineAction\Domain\ValueObject\RoutineActionMemo;
use Src\RoutineAction\Domain\ValueObject\RoutineActionMinutes;
use Src\RoutineAction\Domain\ValueObject\RoutineActionName;

final readonly class CreateRoutineActionInput
{
    public function __construct(
        private RoutineActionName $routineActionName,
        private ?RoutineActionMemo $routineActionMemo,
        private ?RoutineActionMinutes $routineActionMinutes,
        private ?int $parentRoutineActionIndex,
    ) {
        if ($parentRoutineActionIndex !== null && $parentRoutineActionIndex < 0) {
            throw new \InvalidArgumentException('親行動のインデックスは0以上である必要があります。');
        }
    }

    public function routineActionName(): RoutineActionName
    {
        return $this->routineActionName;
    }

    public function routineActionMemo(): ?RoutineActionMemo
    {
        return $this->routineActionMemo;
    }

    public function routineActionMinutes(): ?RoutineActionMinutes
    {
        return $this->routineActionMinutes;
    }

    public function parentRoutineActionIndex(): ?int
    {
        return $this->parentRoutineActionIndex;
    }
}

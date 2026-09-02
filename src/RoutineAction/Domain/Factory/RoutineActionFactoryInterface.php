<?php

declare(strict_types=1);

namespace Src\RoutineAction\Domain\Factory;

use Src\RoutineAction\Domain\Entity\RoutineAction;
use Src\RoutineAction\Domain\ValueObject\RoutineActionMemo;
use Src\RoutineAction\Domain\ValueObject\RoutineActionMinutes;
use Src\RoutineAction\Domain\ValueObject\RoutineActionName;
use Src\Shared\Domain\ValueObject\Identifier\RoutineActionIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineIdentifier;

interface RoutineActionFactoryInterface
{
    public function create(
        RoutineActionIdentifier $routineActionIdentifier,
        ?RoutineActionIdentifier $parentRoutineActionIdentifier,
        RoutineIdentifier $routineIdentifier,
        RoutineActionName $routineActionName,
        ?RoutineActionMemo $routineActionMemo,
        ?RoutineActionMinutes $routineActionMinutes,
    ): RoutineAction;
}

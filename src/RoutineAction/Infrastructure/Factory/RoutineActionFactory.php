<?php

declare(strict_types=1);

namespace Src\RoutineAction\Infrastructure\Factory;

use Src\RoutineAction\Domain\Entity\RoutineAction;
use Src\RoutineAction\Domain\Factory\RoutineActionFactoryInterface;
use Src\RoutineAction\Domain\ValueObject\RoutineActionMemo;
use Src\RoutineAction\Domain\ValueObject\RoutineActionMinutes;
use Src\RoutineAction\Domain\ValueObject\RoutineActionName;
use Src\Shared\Domain\ValueObject\Identifier\RoutineActionIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineIdentifier;

final class RoutineActionFactory implements RoutineActionFactoryInterface
{
    public function create(
        RoutineActionIdentifier $routineActionIdentifier,
        ?RoutineActionIdentifier $parentRoutineActionIdentifier,
        RoutineIdentifier $routineIdentifier,
        RoutineActionName $routineActionName,
        ?RoutineActionMemo $routineActionMemo,
        ?RoutineActionMinutes $routineActionMinutes,
    ): RoutineAction {
        return RoutineAction::create(
            $routineActionIdentifier,
            $parentRoutineActionIdentifier,
            $routineIdentifier,
            $routineActionName,
            $routineActionMemo,
            $routineActionMinutes,
        );
    }
}

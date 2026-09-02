<?php

declare(strict_types=1);

namespace Src\RoutineAction\Infrastructure\Repository;

use App\Models\RoutineActionModel;
use Src\RoutineAction\Domain\Entity\RoutineAction;
use Src\RoutineAction\Domain\Repository\RoutineActionRepositoryInterface;

final class RoutineActionRepository implements RoutineActionRepositoryInterface
{
    public function save(RoutineAction $routineAction): void
    {
        RoutineActionModel::query()->create([
            'routine_action_identifier' => $routineAction->routineActionIdentifier()->value(),
            'parent_routine_action_identifier' => $routineAction->parentRoutineActionIdentifier()?->value(),
            'routine_identifier' => $routineAction->routineIdentifier()->value(),
            'action_name' => $routineAction->routineActionName()->value(),
            'action_memo' => $routineAction->routineActionMemo()?->value(),
            'action_minutes' => $routineAction->routineActionMinutes()?->value(),
            'available' => true,
        ]);
    }
}

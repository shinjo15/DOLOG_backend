<?php

declare(strict_types=1);

namespace Src\RoutineAction\Domain\Repository;

use Src\RoutineAction\Domain\Entity\RoutineAction;

interface RoutineActionRepositoryInterface
{
    public function save(RoutineAction $routineAction): void;
}

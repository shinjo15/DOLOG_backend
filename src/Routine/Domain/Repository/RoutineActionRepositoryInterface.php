<?php

declare(strict_types=1);

namespace Src\Routine\Domain\Repository;

use Src\Routine\Domain\Entity\RoutineAction;

interface RoutineActionRepositoryInterface
{
    public function save(RoutineAction $routineAction): void;
}

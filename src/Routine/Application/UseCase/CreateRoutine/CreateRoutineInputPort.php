<?php

declare(strict_types=1);

namespace Src\Routine\Application\UseCase\CreateRoutine;

use Src\Routine\Domain\ValueObject\RoutineExecutionMinutes;
use Src\Routine\Domain\ValueObject\RoutineMemo;
use Src\Routine\Domain\ValueObject\RoutineName;
use Src\Routine\Domain\ValueObject\RoutineTagIdentifiers;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

interface CreateRoutineInputPort
{
    public function accountIdentifier(): AccountIdentifier;

    public function routineName(): RoutineName;

    /**
     * @return list<CreateRoutineActionInput>
     */
    public function routineActions(): array;

    public function routineMemo(): ?RoutineMemo;

    public function routineExecutionMinutes(): ?RoutineExecutionMinutes;

    public function routineTagIdentifiers(): ?RoutineTagIdentifiers;
}

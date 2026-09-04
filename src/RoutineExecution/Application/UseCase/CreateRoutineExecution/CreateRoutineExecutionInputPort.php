<?php

declare(strict_types=1);

namespace Src\RoutineExecution\Application\UseCase\CreateRoutineExecution;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineIdentifier;

interface CreateRoutineExecutionInputPort
{
    public function executorAccountIdentifier(): AccountIdentifier;

    public function routineIdentifier(): RoutineIdentifier;
}

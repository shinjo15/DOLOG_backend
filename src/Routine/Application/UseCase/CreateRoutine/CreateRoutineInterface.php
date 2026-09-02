<?php

declare(strict_types=1);

namespace Src\Routine\Application\UseCase\CreateRoutine;

interface CreateRoutineInterface
{
    public function execute(CreateRoutineInputPort $input): void;
}

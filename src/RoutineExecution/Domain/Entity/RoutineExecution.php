<?php

declare(strict_types=1);

namespace Src\RoutineExecution\Domain\Entity;

use DateTimeImmutable;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineExecutionIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineIdentifier;

final readonly class RoutineExecution
{
    public function __construct(
        private RoutineExecutionIdentifier $routineExecutionIdentifier,
        private AccountIdentifier $executorAccountIdentifier,
        private RoutineIdentifier $routineIdentifier,
        private DateTimeImmutable $executedAt,
    ) {}

    public function routineExecutionIdentifier(): RoutineExecutionIdentifier
    {
        return $this->routineExecutionIdentifier;
    }

    public function executorAccountIdentifier(): AccountIdentifier
    {
        return $this->executorAccountIdentifier;
    }

    public function routineIdentifier(): RoutineIdentifier
    {
        return $this->routineIdentifier;
    }

    public function executedAt(): DateTimeImmutable
    {
        return $this->executedAt;
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\RoutineExecution\Domain\Entity;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Src\RoutineExecution\Domain\Entity\RoutineExecution;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineExecutionIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineIdentifier;

final class RoutineExecutionTest extends TestCase
{
    public function test_retains_the_executor_routine_and_execution_time(): void
    {
        $routineExecutionIdentifier = new RoutineExecutionIdentifier('50000000-0000-4000-8000-000000000001');
        $executorAccountIdentifier = new AccountIdentifier('10000000-0000-4000-8000-000000000001');
        $routineIdentifier = new RoutineIdentifier('30000000-0000-4000-8000-000000000001');
        $executedAt = new DateTimeImmutable('2026-09-04T12:00:00+00:00');

        $routineExecution = new RoutineExecution(
            $routineExecutionIdentifier,
            $executorAccountIdentifier,
            $routineIdentifier,
            $executedAt,
        );

        $this->assertSame($routineExecutionIdentifier, $routineExecution->routineExecutionIdentifier());
        $this->assertSame($executorAccountIdentifier, $routineExecution->executorAccountIdentifier());
        $this->assertSame($routineIdentifier, $routineExecution->routineIdentifier());
        $this->assertSame($executedAt, $routineExecution->executedAt());
    }
}

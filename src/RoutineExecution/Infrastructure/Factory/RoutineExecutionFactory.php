<?php

declare(strict_types=1);

namespace Src\RoutineExecution\Infrastructure\Factory;

use DateTimeImmutable;
use Src\RoutineExecution\Domain\Entity\RoutineExecution;
use Src\RoutineExecution\Domain\Factory\RoutineExecutionFactoryInterface;
use Src\Shared\Application\Service\UuidServiceInterface;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineExecutionIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineIdentifier;

final readonly class RoutineExecutionFactory implements RoutineExecutionFactoryInterface
{
    public function __construct(
        private UuidServiceInterface $uuidService,
    ) {}

    public function create(
        AccountIdentifier $executorAccountIdentifier,
        RoutineIdentifier $routineIdentifier,
    ): RoutineExecution {
        return new RoutineExecution(
            routineExecutionIdentifier: new RoutineExecutionIdentifier($this->uuidService->generate()),
            executorAccountIdentifier: $executorAccountIdentifier,
            routineIdentifier: $routineIdentifier,
            executedAt: new DateTimeImmutable,
        );
    }
}

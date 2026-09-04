<?php

declare(strict_types=1);

namespace Src\RoutineExecution\Application\UseCase\CreateRoutineExecution;

use Src\Post\Domain\Factory\PostFactoryInterface;
use Src\Post\Domain\Repository\PostRepositoryInterface;
use Src\RoutineExecution\Domain\Factory\RoutineExecutionFactoryInterface;
use Src\RoutineExecution\Domain\Repository\RoutineExecutionRepositoryInterface;
use Src\Shared\Application\Transaction\TransactionManagerInterface;

final readonly class CreateRoutineExecution implements CreateRoutineExecutionInterface
{
    public function __construct(
        private TransactionManagerInterface $transactionManager,
        private RoutineExecutionFactoryInterface $routineExecutionFactory,
        private RoutineExecutionRepositoryInterface $routineExecutionRepository,
        private PostFactoryInterface $postFactory,
        private PostRepositoryInterface $postRepository,
    ) {}

    public function execute(CreateRoutineExecutionInputPort $input): void
    {
        $this->transactionManager->transaction(function () use ($input): void {
            $routineExecution = $this->routineExecutionFactory->create(
                $input->executorAccountIdentifier(),
                $input->routineIdentifier(),
            );

            $this->routineExecutionRepository->save($routineExecution);
            $this->postRepository->save($this->postFactory->createActionPost(
                $routineExecution->routineIdentifier(),
                $routineExecution->routineExecutionIdentifier(),
            ));
        });
    }
}

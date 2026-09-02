<?php

declare(strict_types=1);

namespace Src\Routine\Application\UseCase\CreateRoutine;

use Src\Post\Domain\Factory\PostFactoryInterface;
use Src\Post\Domain\Repository\PostRepositoryInterface;
use Src\Routine\Domain\Factory\RoutineFactoryInterface;
use Src\Routine\Domain\Repository\RoutineRepositoryInterface;
use Src\Routine\Domain\ValueObject\RoutineActionIdentifiers;
use Src\RoutineAction\Domain\Entity\RoutineAction;
use Src\RoutineAction\Domain\Factory\RoutineActionFactoryInterface;
use Src\RoutineAction\Domain\Repository\RoutineActionRepositoryInterface;
use Src\Shared\Application\Service\UuidServiceInterface;
use Src\Shared\Application\Transaction\TransactionManagerInterface;
use Src\Shared\Domain\ValueObject\Identifier\RoutineActionIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineIdentifier;

final readonly class CreateRoutine implements CreateRoutineInterface
{
    public function __construct(
        private UuidServiceInterface $uuidService,
        private RoutineFactoryInterface $routineFactory,
        private RoutineActionFactoryInterface $routineActionFactory,
        private PostFactoryInterface $postFactory,
        private RoutineRepositoryInterface $routineRepository,
        private RoutineActionRepositoryInterface $routineActionRepository,
        private PostRepositoryInterface $postRepository,
        private TransactionManagerInterface $transactionManager,
    ) {}

    public function execute(CreateRoutineInputPort $input): void
    {
        $routineIdentifier = new RoutineIdentifier($this->uuidService->generate());
        $routineActionIdentifiers = $this->createRoutineActionIdentifiers($input);
        $routine = $this->routineFactory->create(
            $routineIdentifier,
            $input->routineName(),
            new RoutineActionIdentifiers($routineActionIdentifiers),
            $input->routineMemo(),
            $input->accountIdentifier(),
            $input->routineExecutionMinutes(),
            $input->routineTagIdentifiers(),
        );
        $routineActions = $this->createRoutineActions($input, $routineIdentifier, $routineActionIdentifiers);
        $post = $this->postFactory->createRoutinePost($routineIdentifier);

        $this->transactionManager->transaction(function () use ($routine, $routineActions, $post): void {
            $this->routineRepository->save($routine);

            foreach ($routineActions as $routineAction) {
                $this->routineActionRepository->save($routineAction);
            }

            $this->postRepository->save($post);
        });
    }

    /**
     * @return list<RoutineActionIdentifier>
     */
    private function createRoutineActionIdentifiers(CreateRoutineInputPort $input): array
    {
        $routineActionIdentifiers = [];

        foreach ($input->routineActions() as $_) {
            $routineActionIdentifiers[] = new RoutineActionIdentifier($this->uuidService->generate());
        }

        return $routineActionIdentifiers;
    }

    /**
     * @param  list<RoutineActionIdentifier>  $routineActionIdentifiers
     * @return list<RoutineAction>
     */
    private function createRoutineActions(
        CreateRoutineInputPort $input,
        RoutineIdentifier $routineIdentifier,
        array $routineActionIdentifiers,
    ): array {
        $routineActions = [];

        foreach ($input->routineActions() as $index => $routineActionInput) {
            $parentRoutineActionIdentifier = $this->parentRoutineActionIdentifier(
                $routineActionInput->parentRoutineActionIndex(),
                $index,
                $routineActionIdentifiers,
            );
            $routineActions[] = $this->routineActionFactory->create(
                $routineActionIdentifiers[$index],
                $parentRoutineActionIdentifier,
                $routineIdentifier,
                $routineActionInput->routineActionName(),
                $routineActionInput->routineActionMemo(),
                $routineActionInput->routineActionMinutes(),
            );
        }

        return $routineActions;
    }

    /**
     * @param  list<RoutineActionIdentifier>  $routineActionIdentifiers
     */
    private function parentRoutineActionIdentifier(
        ?int $parentRoutineActionIndex,
        int $routineActionIndex,
        array $routineActionIdentifiers,
    ): ?RoutineActionIdentifier {
        if ($parentRoutineActionIndex === null) {
            return null;
        }

        if ($parentRoutineActionIndex >= $routineActionIndex) {
            throw new \InvalidArgumentException('親行動は先に定義された行動を指定する必要があります。');
        }

        return $routineActionIdentifiers[$parentRoutineActionIndex] ?? throw new \InvalidArgumentException(
            '親行動のインデックスが行動一覧に存在しません。',
        );
    }
}

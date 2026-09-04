<?php

declare(strict_types=1);

namespace Src\Follow\Application\UseCase\CreateFollow;

use Src\Follow\Domain\Exception\DuplicateFollowException;
use Src\Follow\Domain\Exception\FollowedAccountNotFoundException;
use Src\Follow\Domain\Factory\FollowFactoryInterface;
use Src\Follow\Domain\Repository\AccountRepositoryInterface;
use Src\Follow\Domain\Repository\FollowRepositoryInterface;
use Src\Shared\Application\Transaction\TransactionManagerInterface;

final readonly class CreateFollow implements CreateFollowInterface
{
    public function __construct(
        private TransactionManagerInterface $transactionManager,
        private AccountRepositoryInterface $accountRepository,
        private FollowRepositoryInterface $followRepository,
        private FollowFactoryInterface $followFactory,
    ) {}

    public function execute(CreateFollowInputPort $input): void
    {
        $this->transactionManager->transaction(function () use ($input): void {
            if (! $this->accountRepository->exists($input->followedAccountIdentifier())) {
                throw new FollowedAccountNotFoundException;
            }

            if ($this->followRepository->find(
                $input->followingAccountIdentifier(),
                $input->followedAccountIdentifier(),
            ) !== null) {
                throw new DuplicateFollowException;
            }

            $this->followRepository->save($this->followFactory->create(
                followingAccountIdentifier: $input->followingAccountIdentifier(),
                followedAccountIdentifier: $input->followedAccountIdentifier(),
            ));
        });
    }
}

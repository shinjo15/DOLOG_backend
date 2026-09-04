<?php

declare(strict_types=1);

namespace Src\Account\Application\UseCase\ChangeAccountStatus;

use Src\Account\Domain\Exception\AccountNotFoundException;
use Src\Account\Domain\Repository\AccountRepositoryInterface;
use Src\Shared\Application\Transaction\TransactionManagerInterface;

final readonly class ChangeAccountStatus implements ChangeAccountStatusInterface
{
    public function __construct(private AccountRepositoryInterface $accountRepository, private TransactionManagerInterface $transactionManager) {}

    public function execute(ChangeAccountStatusInputPort $input): void
    {
        $account = $this->accountRepository->find($input->accountIdentifier());
        if ($account === null) throw new AccountNotFoundException;
        $account->changeStatus($input->status(), $input->banUntil());
        $this->transactionManager->transaction(fn (): mixed => $this->accountRepository->save($account));
    }
}

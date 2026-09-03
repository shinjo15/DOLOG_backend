<?php

declare(strict_types=1);

namespace Src\Account\Application\UseCase\CreateAccount;

use Src\Account\Application\Service\AccountRegistrationMailServiceInterface;
use Src\Account\Application\Service\PasscodeHashingServiceInterface;
use Src\Account\Domain\Entity\AccountCredential;
use Src\Account\Domain\Exception\DuplicateEmailAddressException;
use Src\Account\Domain\Factory\AccountFactoryInterface;
use Src\Account\Domain\Repository\AccountCredentialRepositoryInterface;
use Src\Account\Domain\Repository\AccountRepositoryInterface;
use Src\Shared\Application\Transaction\TransactionManagerInterface;

final readonly class CreateAccount implements CreateAccountInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private AccountCredentialRepositoryInterface $accountCredentialRepository,
        private AccountFactoryInterface $accountFactory,
        private PasscodeHashingServiceInterface $passcodeHashingService,
        private AccountRegistrationMailServiceInterface $accountRegistrationMailService,
        private TransactionManagerInterface $transactionManager,
    ) {}

    public function execute(CreateAccountInputPort $input): void
    {
        if ($this->accountRepository->findByEmailAddress($input->emailAddress()) !== null) {
            throw new DuplicateEmailAddressException;
        }

        $account = $this->accountFactory->create(
            $input->accountName(), $input->accountBio(), $input->emailAddress(), $input->socialLinks(), $input->favoriteTagIdentifiers(),
        );
        $hashedPasscode = $this->passcodeHashingService->hash($input->passcode());

        $this->transactionManager->transaction(function () use ($account, $hashedPasscode): void {
            $this->accountRepository->save($account);
            $this->accountCredentialRepository->save(AccountCredential::create($account->accountIdentifier(), $hashedPasscode));
        });

        $this->accountRegistrationMailService->send($account->emailAddress(), $account->accountName());
    }
}

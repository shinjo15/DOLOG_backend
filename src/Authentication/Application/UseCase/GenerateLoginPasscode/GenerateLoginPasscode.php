<?php

declare(strict_types=1);

namespace Src\Authentication\Application\UseCase\GenerateLoginPasscode;

use Src\Account\Domain\Repository\AccountRepositoryInterface;
use Src\Authentication\Application\Service\LoginPasscodeGeneratorServiceInterface;
use Src\Authentication\Application\Service\LoginPasscodeHashServiceInterface;
use Src\Authentication\Application\Service\LoginPasscodeMailServiceInterface;
use Src\Authentication\Application\Service\LoginPasscodeStateServiceInterface;
use Src\Authentication\Domain\Factory\LoginPasscodeChallengeFactoryInterface;
use Src\Authentication\Domain\ValueObject\LoginPasscode;

final readonly class GenerateLoginPasscode implements GenerateLoginPasscodeInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private LoginPasscodeChallengeFactoryInterface $challengeFactory,
        private LoginPasscodeGeneratorServiceInterface $generator,
        private LoginPasscodeHashServiceInterface $hashService,
        private LoginPasscodeStateServiceInterface $stateService,
        private LoginPasscodeMailServiceInterface $mailService,
    ) {}

    public function execute(GenerateLoginPasscodeInput $input): GenerateLoginPasscodeOutput
    {
        $account = $this->accountRepository->findByEmailAddress($input->emailAddress());
        if ($account === null) {
            return new GenerateLoginPasscodeOutput(null);
        }

        $passcode = new LoginPasscode($this->generator->generate());
        $challenge = $this->challengeFactory->create(
            $account->accountIdentifier(),
            $input->emailAddress(),
            $this->hashService->hash($passcode),
        );
        $this->stateService->register($challenge);
        $this->mailService->send($challenge->emailAddress(), $passcode);

        return new GenerateLoginPasscodeOutput($challenge->identifier()->value());
    }
}

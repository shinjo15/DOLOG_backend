<?php

declare(strict_types=1);

namespace Src\Authentication\Application\UseCase\VerifyLoginPasscode;

use Src\Authentication\Application\Service\LoginPasscodeHashServiceInterface;
use Src\Authentication\Application\Service\LoginPasscodeStateServiceInterface;

final readonly class VerifyLoginPasscode implements VerifyLoginPasscodeInterface
{
    public function __construct(
        private LoginPasscodeStateServiceInterface $stateService,
        private LoginPasscodeHashServiceInterface $hashService,
    ) {}

    public function execute(VerifyLoginPasscodeInput $input): VerifyLoginPasscodeOutput
    {
        $challenge = $this->stateService->find($input->challengeIdentifier());
        if ($challenge === null) {
            return VerifyLoginPasscodeOutput::rejected();
        }

        if (! $this->hashService->matches($input->passcode(), $challenge->passcodeHash())) {
            $this->stateService->recordFailedAttempt($input->challengeIdentifier());

            return VerifyLoginPasscodeOutput::rejected();
        }

        if (! $this->stateService->delete($input->challengeIdentifier())) {
            return VerifyLoginPasscodeOutput::rejected();
        }

        return VerifyLoginPasscodeOutput::authenticated($challenge->accountIdentifier());
    }
}

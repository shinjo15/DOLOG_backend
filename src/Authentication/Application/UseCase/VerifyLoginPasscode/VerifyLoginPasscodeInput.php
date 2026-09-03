<?php

declare(strict_types=1);

namespace Src\Authentication\Application\UseCase\VerifyLoginPasscode;

use Src\Authentication\Domain\ValueObject\LoginPasscode;
use Src\Authentication\Domain\ValueObject\LoginPasscodeChallengeIdentifier;

final readonly class VerifyLoginPasscodeInput
{
    public function __construct(
        private LoginPasscodeChallengeIdentifier $challengeIdentifier,
        private LoginPasscode $passcode,
    ) {}

    public function challengeIdentifier(): LoginPasscodeChallengeIdentifier
    {
        return $this->challengeIdentifier;
    }

    public function passcode(): LoginPasscode
    {
        return $this->passcode;
    }
}

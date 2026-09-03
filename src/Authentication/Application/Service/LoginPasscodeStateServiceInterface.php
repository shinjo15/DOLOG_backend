<?php

declare(strict_types=1);

namespace Src\Authentication\Application\Service;

use Src\Authentication\Domain\Entity\LoginPasscodeChallenge;
use Src\Authentication\Domain\ValueObject\LoginPasscodeChallengeIdentifier;

interface LoginPasscodeStateServiceInterface
{
    public function register(LoginPasscodeChallenge $challenge): void;

    public function find(LoginPasscodeChallengeIdentifier $challengeIdentifier): ?LoginPasscodeChallenge;

    public function recordFailedAttempt(LoginPasscodeChallengeIdentifier $challengeIdentifier): ?int;

    public function delete(LoginPasscodeChallengeIdentifier $challengeIdentifier): bool;
}

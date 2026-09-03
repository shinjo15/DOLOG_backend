<?php

declare(strict_types=1);

namespace Src\Authentication\Application\Service;

interface PasscodeSessionServiceInterface
{
    public function challengeIdentifier(): string;

    public function setChallengeIdentifier(string $challengeIdentifier): void;

    public function clearChallengeIdentifier(): void;
}

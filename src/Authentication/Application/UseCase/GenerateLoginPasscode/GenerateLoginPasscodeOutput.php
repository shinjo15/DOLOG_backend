<?php

declare(strict_types=1);

namespace Src\Authentication\Application\UseCase\GenerateLoginPasscode;

final readonly class GenerateLoginPasscodeOutput
{
    public function __construct(private ?string $challengeIdentifier) {}

    public function challengeIdentifier(): ?string
    {
        return $this->challengeIdentifier;
    }
}

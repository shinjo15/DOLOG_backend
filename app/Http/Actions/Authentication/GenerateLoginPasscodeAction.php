<?php

declare(strict_types=1);

namespace App\Http\Actions\Authentication;

use App\Http\Requests\Authentication\GenerateLoginPasscodeRequest;
use Illuminate\Http\Response;
use Src\Authentication\Application\Service\PasscodeSessionServiceInterface;
use Src\Authentication\Application\UseCase\GenerateLoginPasscode\GenerateLoginPasscodeInterface;

final readonly class GenerateLoginPasscodeAction
{
    public function __construct(
        private GenerateLoginPasscodeInterface $generateLoginPasscode,
        private PasscodeSessionServiceInterface $passcodeSessionService,
    ) {}

    public function __invoke(GenerateLoginPasscodeRequest $request): Response
    {
        $this->passcodeSessionService->clearChallengeIdentifier();
        $output = $this->generateLoginPasscode->execute($request->toInput());

        if ($output->challengeIdentifier() !== null) {
            $this->passcodeSessionService->setChallengeIdentifier($output->challengeIdentifier());
        }

        return new Response('', 204);
    }
}

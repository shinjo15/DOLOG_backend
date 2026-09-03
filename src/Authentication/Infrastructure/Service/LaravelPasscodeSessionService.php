<?php

declare(strict_types=1);

namespace Src\Authentication\Infrastructure\Service;

use Illuminate\Http\Request;
use RuntimeException;
use Src\Authentication\Application\Service\PasscodeSessionServiceInterface;

final readonly class LaravelPasscodeSessionService implements PasscodeSessionServiceInterface
{
    public const SESSION_KEY = 'login_passcode_challenge_identifier';

    public function __construct(private Request $request) {}

    public function challengeIdentifier(): string
    {
        $challengeIdentifier = $this->request->session()->get(self::SESSION_KEY);

        if (! is_string($challengeIdentifier) || $challengeIdentifier === '') {
            throw new RuntimeException('セッションにログインパスコードチャレンジ識別子がありません。');
        }

        return $challengeIdentifier;
    }

    public function setChallengeIdentifier(string $challengeIdentifier): void
    {
        $this->request->session()->put(self::SESSION_KEY, $challengeIdentifier);
    }

    public function clearChallengeIdentifier(): void
    {
        $this->request->session()->forget(self::SESSION_KEY);
    }
}

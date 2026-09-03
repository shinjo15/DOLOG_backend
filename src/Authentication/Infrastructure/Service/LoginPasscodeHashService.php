<?php

declare(strict_types=1);

namespace Src\Authentication\Infrastructure\Service;

use Illuminate\Support\Facades\Hash;
use Src\Authentication\Application\Service\LoginPasscodeHashServiceInterface;
use Src\Authentication\Domain\ValueObject\LoginPasscode;
use Src\Authentication\Domain\ValueObject\LoginPasscodeHash;

final class LoginPasscodeHashService implements LoginPasscodeHashServiceInterface
{
    public function hash(LoginPasscode $passcode): LoginPasscodeHash
    {
        return new LoginPasscodeHash(Hash::make($passcode->value()));
    }

    public function matches(LoginPasscode $passcode, LoginPasscodeHash $passcodeHash): bool
    {
        return Hash::check($passcode->value(), $passcodeHash->value());
    }
}

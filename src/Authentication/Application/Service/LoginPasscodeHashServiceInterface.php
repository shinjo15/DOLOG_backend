<?php

declare(strict_types=1);

namespace Src\Authentication\Application\Service;

use Src\Authentication\Domain\ValueObject\LoginPasscode;
use Src\Authentication\Domain\ValueObject\LoginPasscodeHash;

interface LoginPasscodeHashServiceInterface
{
    public function hash(LoginPasscode $passcode): LoginPasscodeHash;

    public function matches(LoginPasscode $passcode, LoginPasscodeHash $passcodeHash): bool;
}

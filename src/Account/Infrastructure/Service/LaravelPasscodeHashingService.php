<?php

declare(strict_types=1);

namespace Src\Account\Infrastructure\Service;

use Illuminate\Support\Facades\Hash;
use Src\Account\Application\Service\PasscodeHashingServiceInterface;
use Src\Account\Application\ValueObject\Passcode;

final class LaravelPasscodeHashingService implements PasscodeHashingServiceInterface
{
    public function hash(Passcode $passcode): string
    {
        return Hash::make($passcode->value());
    }
}

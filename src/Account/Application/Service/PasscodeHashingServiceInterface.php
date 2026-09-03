<?php

declare(strict_types=1);

namespace Src\Account\Application\Service;

use Src\Account\Application\ValueObject\Passcode;

interface PasscodeHashingServiceInterface
{
    public function hash(Passcode $passcode): string;
}

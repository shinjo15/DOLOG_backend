<?php

declare(strict_types=1);

namespace Src\Authentication\Infrastructure\Service;

use Src\Authentication\Application\Service\LoginPasscodeGeneratorServiceInterface;

final class LoginPasscodeGeneratorService implements LoginPasscodeGeneratorServiceInterface
{
    public function generate(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}

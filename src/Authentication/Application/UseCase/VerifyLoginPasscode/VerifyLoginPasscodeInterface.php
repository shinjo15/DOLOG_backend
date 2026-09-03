<?php

declare(strict_types=1);

namespace Src\Authentication\Application\UseCase\VerifyLoginPasscode;

interface VerifyLoginPasscodeInterface
{
    public function execute(VerifyLoginPasscodeInput $input): VerifyLoginPasscodeOutput;
}

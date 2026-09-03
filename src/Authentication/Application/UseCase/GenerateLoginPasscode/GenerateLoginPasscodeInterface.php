<?php

declare(strict_types=1);

namespace Src\Authentication\Application\UseCase\GenerateLoginPasscode;

interface GenerateLoginPasscodeInterface
{
    public function execute(GenerateLoginPasscodeInput $input): GenerateLoginPasscodeOutput;
}

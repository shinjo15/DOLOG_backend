<?php

declare(strict_types=1);

namespace Src\Account\Application\UseCase\CreateAccount;

interface CreateAccountInterface
{
    public function execute(CreateAccountInputPort $input): void;
}

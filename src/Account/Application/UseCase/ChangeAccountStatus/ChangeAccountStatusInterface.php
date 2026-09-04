<?php

declare(strict_types=1);

namespace Src\Account\Application\UseCase\ChangeAccountStatus;

interface ChangeAccountStatusInterface
{
    public function execute(ChangeAccountStatusInputPort $input): void;
}

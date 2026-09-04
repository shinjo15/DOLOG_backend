<?php

declare(strict_types=1);

namespace Src\Account\Application\UseCase\CreateBlock;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

interface CreateBlockInputPort
{
    public function blockingAccountIdentifier(): AccountIdentifier;

    public function blockedAccountIdentifier(): AccountIdentifier;
}

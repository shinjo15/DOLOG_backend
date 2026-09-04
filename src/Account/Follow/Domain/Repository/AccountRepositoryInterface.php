<?php

declare(strict_types=1);

namespace Src\Account\Follow\Domain\Repository;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

interface AccountRepositoryInterface
{
    public function exists(AccountIdentifier $accountIdentifier): bool;
}

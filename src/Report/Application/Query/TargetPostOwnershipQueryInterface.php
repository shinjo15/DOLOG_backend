<?php

declare(strict_types=1);

namespace Src\Report\Application\Query;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

interface TargetPostOwnershipQueryInterface
{
    public function belongsToAccount(PostIdentifier $postIdentifier, AccountIdentifier $accountIdentifier): bool;
}

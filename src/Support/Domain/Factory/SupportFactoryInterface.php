<?php

declare(strict_types=1);

namespace Src\Support\Domain\Factory;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;
use Src\Support\Domain\Entity\Support;

interface SupportFactoryInterface
{
    public function create(AccountIdentifier $accountIdentifier, PostIdentifier $postIdentifier): Support;
}

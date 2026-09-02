<?php

declare(strict_types=1);

namespace Src\Support\Infrastructure\Factory;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;
use Src\Support\Domain\Entity\Support;
use Src\Support\Domain\Factory\SupportFactoryInterface;

final class SupportFactory implements SupportFactoryInterface
{
    public function create(AccountIdentifier $accountIdentifier, PostIdentifier $postIdentifier): Support
    {
        return new Support($accountIdentifier, $postIdentifier);
    }
}

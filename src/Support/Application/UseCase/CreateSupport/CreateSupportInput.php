<?php

declare(strict_types=1);

namespace Src\Support\Application\UseCase\CreateSupport;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

final readonly class CreateSupportInput
{
    public function __construct(public AccountIdentifier $accountIdentifier, public PostIdentifier $postIdentifier) {}
}

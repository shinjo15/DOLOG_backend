<?php

declare(strict_types=1);

namespace Src\Support\Application\UseCase\CreateSupport;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

final readonly class CreateSupportInput implements CreateSupportInputPort
{
    public function __construct(private AccountIdentifier $accountIdentifier, private PostIdentifier $postIdentifier) {}

    public function accountIdentifier(): AccountIdentifier
    {
        return $this->accountIdentifier;
    }

    public function postIdentifier(): PostIdentifier
    {
        return $this->postIdentifier;
    }
}

<?php

declare(strict_types=1);

namespace Src\Like\Application\UseCase\CreateLike;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

final readonly class CreateLikeInput
{
    public function __construct(public AccountIdentifier $accountIdentifier, public PostIdentifier $postIdentifier) {}
}

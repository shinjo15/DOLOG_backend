<?php

declare(strict_types=1);

namespace Src\Like\Application\UseCase\CreateLike;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

interface CreateLikeInputPort
{
    public function accountIdentifier(): AccountIdentifier;

    public function postIdentifier(): PostIdentifier;
}

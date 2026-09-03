<?php

declare(strict_types=1);

namespace Src\Like\Domain\Factory;

use Src\Like\Domain\Entity\Like;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

interface LikeFactoryInterface
{
    public function create(AccountIdentifier $accountIdentifier, PostIdentifier $postIdentifier): Like;
}

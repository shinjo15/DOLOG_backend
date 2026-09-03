<?php

declare(strict_types=1);

namespace Src\Like\Infrastructure\Factory;

use Src\Like\Domain\Entity\Like;
use Src\Like\Domain\Factory\LikeFactoryInterface;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

final class LikeFactory implements LikeFactoryInterface
{
    public function create(AccountIdentifier $accountIdentifier, PostIdentifier $postIdentifier): Like
    {
        return new Like($accountIdentifier, $postIdentifier);
    }
}

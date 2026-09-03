<?php

declare(strict_types=1);

namespace Src\Report\Infrastructure\Query;

use Illuminate\Support\Facades\DB;
use Src\Report\Application\Query\TargetPostOwnershipQueryInterface;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

final class TargetPostOwnershipQuery implements TargetPostOwnershipQueryInterface
{
    public function belongsToAccount(PostIdentifier $postIdentifier, AccountIdentifier $accountIdentifier): bool
    {
        return DB::table('posts')
            ->join('routines', 'routines.routine_identifier', '=', 'posts.routine_identifier')
            ->where('posts.post_identifier', $postIdentifier->value())
            ->where('routines.account_identifier', $accountIdentifier->value())
            ->exists();
    }
}

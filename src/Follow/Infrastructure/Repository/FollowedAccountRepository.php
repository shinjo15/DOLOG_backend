<?php

declare(strict_types=1);

namespace Src\Follow\Infrastructure\Repository;

use App\Models\AccountModel;
use Src\Follow\Domain\Repository\FollowedAccountRepositoryInterface;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class FollowedAccountRepository implements FollowedAccountRepositoryInterface
{
    public function exists(AccountIdentifier $followedAccountIdentifier): bool
    {
        return AccountModel::query()
            ->where('account_identifier', $followedAccountIdentifier->value())
            ->exists();
    }
}

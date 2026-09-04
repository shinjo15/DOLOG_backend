<?php

declare(strict_types=1);

namespace Src\Follow\Infrastructure\Repository;

use App\Models\AccountModel;
use Src\Follow\Domain\Repository\AccountRepositoryInterface;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class AccountRepository implements AccountRepositoryInterface
{
    public function exists(AccountIdentifier $accountIdentifier): bool
    {
        return AccountModel::query()
            ->where('account_identifier', $accountIdentifier->value())
            ->exists();
    }
}

<?php

declare(strict_types=1);

namespace Src\Account\Infrastructure\Repository;

use App\Models\AccountCredentialModel;
use Src\Account\Domain\Entity\AccountCredential;
use Src\Account\Domain\Repository\AccountCredentialRepositoryInterface;

final class AccountCredentialRepository implements AccountCredentialRepositoryInterface
{
    public function save(AccountCredential $credential): void
    {
        AccountCredentialModel::query()->create([
            'account_identifier' => $credential->accountIdentifier()->value(),
            'passcode_hash' => $credential->passcodeHash(),
        ]);
    }
}

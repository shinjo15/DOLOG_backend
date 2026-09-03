<?php

declare(strict_types=1);

namespace Src\Account\Domain\Repository;

use Src\Account\Domain\Entity\AccountCredential;

interface AccountCredentialRepositoryInterface
{
    public function save(AccountCredential $credential): void;
}

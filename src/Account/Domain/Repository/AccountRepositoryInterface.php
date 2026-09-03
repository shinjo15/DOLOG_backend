<?php

declare(strict_types=1);

namespace Src\Account\Domain\Repository;

use Src\Account\Domain\Entity\Account;
use Src\Account\Domain\ValueObject\EmailAddress;

interface AccountRepositoryInterface
{
    public function findByEmailAddress(EmailAddress $emailAddress): ?Account;

    public function save(Account $account): void;
}

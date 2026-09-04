<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Domain\ValueObject;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Src\Account\Domain\Entity\Account;
use Src\Account\Domain\Exception\InvalidAccountStatusException;
use Src\Account\Domain\ValueObject\AccountName;
use Src\Account\Domain\ValueObject\AccountStatus;
use Src\Account\Domain\ValueObject\EmailAddress;
use Src\Account\Domain\ValueObject\FavoriteTagIdentifiers;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class AccountStatusTest extends TestCase
{
    public function test_new_account_is_active_without_a_ban_until(): void { $account = $this->account(); self::assertSame(AccountStatus::ACTIVE, $account->status()); self::assertNull($account->banUntil()); }
    public function test_temporarily_banned_account_requires_a_future_ban_until(): void { $this->expectException(InvalidAccountStatusException::class); $this->account()->changeStatus(AccountStatus::TEMPORARILY_BANNED, new DateTimeImmutable('-1 second')); }
    public function test_active_and_permanently_banned_accounts_cannot_have_a_ban_until(): void { $this->expectException(InvalidAccountStatusException::class); $this->account()->changeStatus(AccountStatus::PERMANENTLY_BANNED, new DateTimeImmutable('+1 day')); }
    private function account(): Account { return Account::create(new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'), new AccountName('ユーザー'), null, new EmailAddress('user@example.com'), [], new FavoriteTagIdentifiers([])); }
}

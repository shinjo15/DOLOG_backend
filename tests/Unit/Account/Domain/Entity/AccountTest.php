<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Src\Account\Domain\Entity\Account;
use Src\Account\Domain\ValueObject\AccountBio;
use Src\Account\Domain\ValueObject\AccountName;
use Src\Account\Domain\ValueObject\EmailAddress;
use Src\Account\Domain\ValueObject\FavoriteTagIdentifiers;
use Src\Account\Domain\ValueObject\SocialLinks;
use Src\Account\Domain\ValueObject\SocialNetworkType;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\TagIdentifier;

final class AccountTest extends TestCase
{
    public function test_creates_an_account_directly_from_valid_value_objects(): void
    {
        $accountIdentifier = new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87');
        $accountName = new AccountName('朝活ユーザー');
        $accountBio = new AccountBio('朝の時間を大切にしています。');
        $emailAddress = new EmailAddress('user@example.com');
        $socialLinks = new SocialLinks([
            [
                'socialNetworkType' => new SocialNetworkType('x'),
                'url' => 'https://x.com/example',
            ],
        ]);
        $favoriteTagIdentifiers = new FavoriteTagIdentifiers([
            new TagIdentifier('b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5'),
        ]);

        $account = Account::create(
            accountIdentifier: $accountIdentifier,
            accountName: $accountName,
            accountBio: $accountBio,
            emailAddress: $emailAddress,
            socialLinks: $socialLinks,
            favoriteTagIdentifiers: $favoriteTagIdentifiers,
        );

        $this->assertSame($accountIdentifier, $account->accountIdentifier());
        $this->assertSame($accountName, $account->accountName());
        $this->assertSame($accountBio, $account->accountBio());
        $this->assertSame($emailAddress, $account->emailAddress());
        $this->assertSame($socialLinks, $account->socialLinks());
        $this->assertSame($favoriteTagIdentifiers, $account->favoriteTagIdentifiers());
    }

    public function test_creates_an_account_without_a_bio(): void
    {
        $account = Account::create(
            accountIdentifier: new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'),
            accountName: new AccountName('朝活ユーザー'),
            accountBio: null,
            emailAddress: new EmailAddress('user@example.com'),
            socialLinks: new SocialLinks([]),
            favoriteTagIdentifiers: new FavoriteTagIdentifiers([]),
        );

        $this->assertNull($account->accountBio());
    }
}

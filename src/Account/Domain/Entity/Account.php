<?php

declare(strict_types=1);

namespace Src\Account\Domain\Entity;

use Src\Account\Domain\ValueObject\AccountBio;
use Src\Account\Domain\ValueObject\AccountName;
use Src\Account\Domain\ValueObject\EmailAddress;
use Src\Account\Domain\ValueObject\FavoriteTagIdentifiers;
use Src\Account\Domain\ValueObject\SocialLinks;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class Account
{
    private function __construct(
        private readonly AccountIdentifier $accountIdentifier,
        private readonly AccountName $accountName,
        private readonly ?AccountBio $accountBio,
        private readonly EmailAddress $emailAddress,
        private readonly SocialLinks $socialLinks,
        private readonly FavoriteTagIdentifiers $favoriteTagIdentifiers,
    ) {}

    public static function create(
        AccountIdentifier $accountIdentifier,
        AccountName $accountName,
        ?AccountBio $accountBio,
        EmailAddress $emailAddress,
        SocialLinks $socialLinks,
        FavoriteTagIdentifiers $favoriteTagIdentifiers,
    ): self {
        return new self(
            accountIdentifier: $accountIdentifier,
            accountName: $accountName,
            accountBio: $accountBio,
            emailAddress: $emailAddress,
            socialLinks: $socialLinks,
            favoriteTagIdentifiers: $favoriteTagIdentifiers,
        );
    }

    public function accountIdentifier(): AccountIdentifier
    {
        return $this->accountIdentifier;
    }

    public function accountName(): AccountName
    {
        return $this->accountName;
    }

    public function accountBio(): ?AccountBio
    {
        return $this->accountBio;
    }

    public function emailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }

    public function socialLinks(): SocialLinks
    {
        return $this->socialLinks;
    }

    public function favoriteTagIdentifiers(): FavoriteTagIdentifiers
    {
        return $this->favoriteTagIdentifiers;
    }
}

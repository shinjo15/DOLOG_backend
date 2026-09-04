<?php

declare(strict_types=1);

namespace Src\Account\Domain\Entity;

use DateTimeImmutable;

use Src\Account\Domain\ValueObject\AccountBio;
use Src\Account\Domain\ValueObject\AccountName;
use Src\Account\Domain\ValueObject\AccountStatus;
use Src\Account\Domain\ValueObject\EmailAddress;
use Src\Account\Domain\ValueObject\FavoriteTagIdentifiers;
use Src\Account\Domain\ValueObject\SocialLink;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class Account
{
    private function __construct(
        private readonly AccountIdentifier $accountIdentifier,
        private readonly AccountName $accountName,
        private readonly ?AccountBio $accountBio,
        private readonly EmailAddress $emailAddress,
        /** @var list<SocialLink> */
        private readonly array $socialLinks,
        private readonly FavoriteTagIdentifiers $favoriteTagIdentifiers,
        private AccountStatus $status,
        private ?DateTimeImmutable $banUntil,
    ) {}

    /** @param list<SocialLink> $socialLinks */
    public static function create(
        AccountIdentifier $accountIdentifier,
        AccountName $accountName,
        ?AccountBio $accountBio,
        EmailAddress $emailAddress,
        array $socialLinks,
        FavoriteTagIdentifiers $favoriteTagIdentifiers,
    ): self {
        if (! array_is_list($socialLinks)) {
            throw new \InvalidArgumentException('SNSリンクは一覧で指定する必要があります。');
        }

        foreach ($socialLinks as $socialLink) {
            if (! $socialLink instanceof SocialLink) {
                throw new \InvalidArgumentException('SNSリンクにはSocialLinkのみ指定できます。');
            }
        }

        return new self(
            $accountIdentifier,
            $accountName,
            $accountBio,
            $emailAddress,
            $socialLinks,
            $favoriteTagIdentifiers,
            AccountStatus::ACTIVE,
            null,
        );
    }

    /** @param list<SocialLink> $socialLinks */
    public static function restore(
        AccountIdentifier $accountIdentifier,
        AccountName $accountName,
        ?AccountBio $accountBio,
        EmailAddress $emailAddress,
        array $socialLinks,
        FavoriteTagIdentifiers $favoriteTagIdentifiers,
        AccountStatus $status,
        ?DateTimeImmutable $banUntil,
    ): self {
        return new self($accountIdentifier, $accountName, $accountBio, $emailAddress, $socialLinks, $favoriteTagIdentifiers, $status, $banUntil);
    }

    public function active(): void
    {
        $this->status = AccountStatus::ACTIVE;
        $this->banUntil = null;
    }

    public function temporarilyBan(): void
    {
        $this->status = AccountStatus::TEMPORARILY_BANNED;
        $this->banUntil = new DateTimeImmutable('+2 weeks');
    }

    public function permanentlyBan(): void
    {
        $this->status = AccountStatus::PERMANENTLY_BANNED;
        $this->banUntil = null;
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
    /** @return list<SocialLink> */
    public function socialLinks(): array
    {
        return $this->socialLinks;
    }

    public function favoriteTagIdentifiers(): FavoriteTagIdentifiers
    {
        return $this->favoriteTagIdentifiers;
    }

    public function status(): AccountStatus
    {
        return $this->status;
    }

    public function banUntil(): ?DateTimeImmutable
    {
        return $this->banUntil;
    }
}

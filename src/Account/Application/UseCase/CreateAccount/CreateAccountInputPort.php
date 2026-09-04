<?php

declare(strict_types=1);

namespace Src\Account\Application\UseCase\CreateAccount;

use Src\Account\Application\Service\AccountImage;
use Src\Account\Domain\ValueObject\AccountBio;
use Src\Account\Domain\ValueObject\AccountName;
use Src\Account\Domain\ValueObject\EmailAddress;
use Src\Account\Domain\ValueObject\FavoriteTagIdentifiers;
use Src\Account\Domain\ValueObject\SocialLink;

interface CreateAccountInputPort
{
    public function accountName(): AccountName;

    public function accountBio(): ?AccountBio;

    public function emailAddress(): EmailAddress;

    /** @return list<SocialLink> */
    public function socialLinks(): array;

    public function favoriteTagIdentifiers(): FavoriteTagIdentifiers;

    public function iconImage(): ?AccountImage;

    public function headerImage(): ?AccountImage;
}

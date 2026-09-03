<?php

declare(strict_types=1);

namespace Src\Account\Infrastructure\Repository;

use App\Models\AccountModel;
use Src\Account\Domain\Entity\Account;
use Src\Account\Domain\Repository\AccountRepositoryInterface;
use Src\Account\Domain\ValueObject\AccountBio;
use Src\Account\Domain\ValueObject\AccountName;
use Src\Account\Domain\ValueObject\EmailAddress;
use Src\Account\Domain\ValueObject\FavoriteTagIdentifiers;
use Src\Account\Domain\ValueObject\SocialLink;
use Src\Account\Domain\ValueObject\SocialType;
use Src\Account\Domain\ValueObject\SocialUrl;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\TagIdentifier;

final class AccountRepository implements AccountRepositoryInterface
{
    public function findByEmailAddress(EmailAddress $emailAddress): ?Account
    {
        $model = AccountModel::query()->where('email_address', $emailAddress->value())->first();

        return $model === null ? null : Account::create(
            new AccountIdentifier($model->account_identifier), new AccountName($model->account_name),
            $model->account_bio === null ? null : new AccountBio($model->account_bio), new EmailAddress($model->email_address),
            array_map(static fn (array $socialLink): SocialLink => new SocialLink(SocialType::from($socialLink['social_type']), new SocialUrl($socialLink['social_url'])), $model->social_links),
            new FavoriteTagIdentifiers(array_map(static fn (string $tagIdentifier): TagIdentifier => new TagIdentifier($tagIdentifier), $model->favorite_tag_identifiers)),
        );
    }

    public function save(Account $account): void
    {
        AccountModel::query()->create([
            'account_identifier' => $account->accountIdentifier()->value(), 'account_name' => $account->accountName()->value(),
            'account_bio' => $account->accountBio()?->value(), 'email_address' => $account->emailAddress()->value(),
            'social_links' => array_map(static fn (SocialLink $socialLink): array => ['social_type' => $socialLink->socialType()->value, 'social_url' => $socialLink->socialUrl()->value()], $account->socialLinks()),
            'favorite_tag_identifiers' => array_map(static fn (TagIdentifier $identifier): string => $identifier->value(), $account->favoriteTagIdentifiers()->values()), 'available' => true,
        ]);
    }
}

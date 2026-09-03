<?php

declare(strict_types=1);

namespace Src\Account\Infrastructure\Repository;

use App\Models\AccountModel;
use App\Models\AccountSocialLinkModel;
use Illuminate\Support\Facades\DB;
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
        $model = AccountModel::query()->with('socialLinks')->where('email_address', $emailAddress->value())->first();

        return $model === null ? null : Account::create(
            new AccountIdentifier($model->account_identifier), new AccountName($model->account_name),
            $model->account_bio === null ? null : new AccountBio($model->account_bio), new EmailAddress($model->email_address),
            $model->socialLinks->map(static fn (AccountSocialLinkModel $socialLink): SocialLink => new SocialLink(SocialType::from($socialLink->type), new SocialUrl($socialLink->url)))->all(),
            new FavoriteTagIdentifiers(array_map(static fn (string $tagIdentifier): TagIdentifier => new TagIdentifier($tagIdentifier), $model->favorite_tag_identifiers)),
        );
    }

    public function save(Account $account): void
    {
        DB::transaction(function () use ($account): void {
            $model = AccountModel::query()->create([
                'account_identifier' => $account->accountIdentifier()->value(), 'account_name' => $account->accountName()->value(),
                'account_bio' => $account->accountBio()?->value(), 'email_address' => $account->emailAddress()->value(),
                'favorite_tag_identifiers' => array_map(static fn (TagIdentifier $identifier): string => $identifier->value(), $account->favoriteTagIdentifiers()->values()), 'available' => true,
            ]);

            $model->socialLinks()->createMany(array_map(
                static fn (SocialLink $socialLink, int $position): array => [
                    'type' => $socialLink->socialType()->value,
                    'url' => $socialLink->socialUrl()->value(),
                    'position' => $position,
                ],
                $account->socialLinks(),
                array_keys($account->socialLinks()),
            ));
        });
    }
}

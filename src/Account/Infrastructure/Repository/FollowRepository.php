<?php

declare(strict_types=1);

namespace Src\Account\Infrastructure\Repository;

use App\Models\FollowModel;
use Illuminate\Database\UniqueConstraintViolationException;
use Src\Account\Domain\Entity\Follow;
use Src\Account\Domain\Exception\DuplicateFollowException;
use Src\Account\Domain\Repository\FollowRepositoryInterface;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class FollowRepository implements FollowRepositoryInterface
{
    public function find(
        AccountIdentifier $followingAccountIdentifier,
        AccountIdentifier $followedAccountIdentifier,
    ): ?Follow {
        $model = FollowModel::query()
            ->where('following_account_identifier', $followingAccountIdentifier->value())
            ->where('followed_account_identifier', $followedAccountIdentifier->value())
            ->first();

        return $model === null ? null : $this->restore($model);
    }

    public function save(Follow $follow): void
    {
        try {
            FollowModel::query()->create([
                'following_account_identifier' => $follow->followingAccountIdentifier()->value(),
                'followed_account_identifier' => $follow->followedAccountIdentifier()->value(),
            ]);
        } catch (UniqueConstraintViolationException) {
            throw new DuplicateFollowException;
        }
    }

    private function restore(FollowModel $model): Follow
    {
        return new Follow(
            followingAccountIdentifier: new AccountIdentifier($model->following_account_identifier),
            followedAccountIdentifier: new AccountIdentifier($model->followed_account_identifier),
        );
    }
}

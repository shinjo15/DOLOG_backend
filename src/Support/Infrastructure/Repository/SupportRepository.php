<?php

declare(strict_types=1);

namespace Src\Support\Infrastructure\Repository;

use App\Models\SupportModel;
use DateTimeImmutable;
use Src\Post\Domain\Entity\Post;
use Src\Post\Domain\ValueObject\PostCategory;
use Src\Post\Domain\ValueObject\PostLikeCount;
use Src\Post\Domain\ValueObject\PostSupportCount;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineIdentifier;
use Src\Support\Domain\Entity\Support;
use Src\Support\Domain\Entity\SupportedPost;
use Src\Support\Domain\Repository\SupportRepositoryInterface;
use Src\Support\Domain\ValueObject\SupportedPostPage;

final class SupportRepository implements SupportRepositoryInterface
{
    public function exists(AccountIdentifier $accountIdentifier, PostIdentifier $postIdentifier): bool
    {
        return SupportModel::query()->where('account_identifier', $accountIdentifier->value())->where('post_identifier', $postIdentifier->value())->exists();
    }

    public function paginateActionPostsByAccountIdentifier(AccountIdentifier $accountIdentifier, int $page, int $perPage): SupportedPostPage
    {
        $paginator = SupportModel::query()
            ->join('posts', 'supports.post_identifier', '=', 'posts.post_identifier')
            ->where('supports.account_identifier', $accountIdentifier->value())
            ->where('posts.post_category', PostCategory::ACTION->value)
            ->where('posts.available', true)
            ->orderByDesc('supports.created_at')
            ->select([
                'supports.account_identifier as support_account_identifier',
                'supports.post_identifier as support_post_identifier',
                'supports.created_at as support_created_at',
                'posts.post_identifier',
                'posts.routine_identifier',
                'posts.post_category',
                'posts.post_like_count',
                'posts.post_support_count',
            ])
            ->paginate($perPage, ['*'], 'page', $page);

        $items = $paginator->getCollection()->map(static fn (SupportModel $model): SupportedPost => new SupportedPost(
            new Support(new AccountIdentifier($model->support_account_identifier), new PostIdentifier($model->support_post_identifier)),
            Post::create(
                new PostIdentifier($model->post_identifier),
                new RoutineIdentifier($model->routine_identifier),
                PostCategory::from($model->post_category),
                new PostLikeCount($model->post_like_count),
                new PostSupportCount($model->post_support_count),
            ),
            new DateTimeImmutable($model->support_created_at),
        ))->all();

        return new SupportedPostPage($items, $paginator->currentPage(), $paginator->lastPage(), $paginator->perPage(), $paginator->total());
    }

    public function save(Support $support): void
    {
        SupportModel::query()->create(['account_identifier' => $support->accountIdentifier()->value(), 'post_identifier' => $support->postIdentifier()->value()]);
    }
}

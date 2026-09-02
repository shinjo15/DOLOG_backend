<?php

declare(strict_types=1);

namespace Src\Post\Infrastructure\Repository;

use App\Models\PostModel;
use Src\Post\Domain\Entity\Post;
use Src\Post\Domain\Repository\PostRepositoryInterface;

final class PostRepository implements PostRepositoryInterface
{
    public function save(Post $post): void
    {
        PostModel::query()->create([
            'post_identifier' => $post->postIdentifier()->value(),
            'routine_identifier' => $post->routineIdentifier()->value(),
            'post_category' => $post->postCategory()->value,
            'post_like_count' => $post->postLikeCount()->value(),
            'post_support_count' => $post->postSupportCount()->value(),
            'available' => true,
        ]);
    }
}

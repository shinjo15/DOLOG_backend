<?php

declare(strict_types=1);

namespace Tests\Unit\Post\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Src\Post\Domain\Entity\Post;
use Src\Post\Domain\Exception\UnsupportedPostLikeException;
use Src\Post\Domain\Exception\UnsupportedPostSupportException;
use Src\Post\Domain\ValueObject\PostCategory;
use Src\Post\Domain\ValueObject\PostLikeCount;
use Src\Post\Domain\ValueObject\PostSupportCount;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineIdentifier;

final class PostTest extends TestCase
{
    public function test_retains_the_values_of_a_created_post(): void
    {
        $postIdentifier = new PostIdentifier('f6ca9f4c-169b-4b2d-a717-4a4f40d1490f');
        $routineIdentifier = new RoutineIdentifier('34b8d590-07cb-49ca-bfd9-cb9f40e26bd3');
        $postCategory = PostCategory::ROUTINE;
        $postLikeCount = new PostLikeCount(3);
        $postSupportCount = new PostSupportCount(0);

        $post = Post::create(
            postIdentifier: $postIdentifier,
            routineIdentifier: $routineIdentifier,
            postCategory: $postCategory,
            postLikeCount: $postLikeCount,
            postSupportCount: $postSupportCount,
        );

        $this->assertSame($postIdentifier, $post->postIdentifier());
        $this->assertSame($routineIdentifier, $post->routineIdentifier());
        $this->assertSame($postCategory, $post->postCategory());
        $this->assertSame($postLikeCount, $post->postLikeCount());
        $this->assertSame($postSupportCount, $post->postSupportCount());
    }

    public function test_rejects_a_negative_like_count(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('投稿のいいね総数は0以上である必要があります。');

        new PostLikeCount(-1);
    }

    public function test_rejects_a_negative_support_count(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('投稿の応援総数は0以上である必要があります。');

        new PostSupportCount(-1);
    }

    public function test_increments_support_count_for_an_action_post(): void
    {
        $post = Post::create(
            postIdentifier: new PostIdentifier('f6ca9f4c-169b-4b2d-a717-4a4f40d1490f'),
            routineIdentifier: new RoutineIdentifier('34b8d590-07cb-49ca-bfd9-cb9f40e26bd3'),
            postCategory: PostCategory::ACTION,
            postLikeCount: new PostLikeCount(0),
            postSupportCount: new PostSupportCount(0),
        );

        $supportedPost = $post->incrementSupportCount();

        $this->assertSame(1, $supportedPost->postSupportCount()->value());
    }

    public function test_rejects_support_for_a_routine_post(): void
    {
        $this->expectException(UnsupportedPostSupportException::class);
        $this->expectExceptionMessage('応援できるのは実行投稿のみです。');

        Post::create(
            postIdentifier: new PostIdentifier('f6ca9f4c-169b-4b2d-a717-4a4f40d1490f'),
            routineIdentifier: new RoutineIdentifier('34b8d590-07cb-49ca-bfd9-cb9f40e26bd3'),
            postCategory: PostCategory::ROUTINE,
            postLikeCount: new PostLikeCount(0),
            postSupportCount: new PostSupportCount(0),
        )->incrementSupportCount();
    }

    public function test_increments_like_count_for_a_routine_post(): void
    {
        $post = Post::create(
            postIdentifier: new PostIdentifier('f6ca9f4c-169b-4b2d-a717-4a4f40d1490f'),
            routineIdentifier: new RoutineIdentifier('34b8d590-07cb-49ca-bfd9-cb9f40e26bd3'),
            postCategory: PostCategory::ROUTINE,
            postLikeCount: new PostLikeCount(0),
            postSupportCount: new PostSupportCount(0),
        );

        $likedPost = $post->incrementLikeCount();

        $this->assertSame(1, $likedPost->postLikeCount()->value());
    }

    public function test_rejects_like_for_an_action_post(): void
    {
        $this->expectException(UnsupportedPostLikeException::class);

        Post::create(
            postIdentifier: new PostIdentifier('f6ca9f4c-169b-4b2d-a717-4a4f40d1490f'),
            routineIdentifier: new RoutineIdentifier('34b8d590-07cb-49ca-bfd9-cb9f40e26bd3'),
            postCategory: PostCategory::ACTION,
            postLikeCount: new PostLikeCount(0),
            postSupportCount: new PostSupportCount(0),
        )->incrementLikeCount();
    }
}

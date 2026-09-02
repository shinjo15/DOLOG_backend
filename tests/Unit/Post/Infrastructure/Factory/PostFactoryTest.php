<?php

declare(strict_types=1);

namespace Tests\Unit\Post\Infrastructure\Factory;

use PHPUnit\Framework\TestCase;
use Src\Post\Domain\ValueObject\PostCategory;
use Src\Post\Infrastructure\Factory\PostFactory;
use Src\Shared\Application\Service\UuidServiceInterface;
use Src\Shared\Domain\ValueObject\Identifier\RoutineIdentifier;

final class PostFactoryTest extends TestCase
{
    public function test_creates_a_routine_post_with_zero_reactions(): void
    {
        $postFactory = new PostFactory(new class implements UuidServiceInterface
        {
            public function generate(): string
            {
                return 'e1954b83-b532-40ae-8b9e-49d488040d0f';
            }
        });

        $post = $postFactory->createRoutinePost(
            new RoutineIdentifier('34b8d590-07cb-49ca-bfd9-cb9f40e26bd3'),
        );

        $this->assertSame('e1954b83-b532-40ae-8b9e-49d488040d0f', $post->postIdentifier()->value());
        $this->assertSame('34b8d590-07cb-49ca-bfd9-cb9f40e26bd3', $post->routineIdentifier()->value());
        $this->assertSame(PostCategory::ROUTINE, $post->postCategory());
        $this->assertSame(0, $post->postLikeCount()->value());
        $this->assertSame(0, $post->postSupportCount()->value());
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Like\Application\UseCase\CreateLike;

use App\Models\PostModel;
use App\Models\RoutineModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Like\Application\UseCase\CreateLike\CreateLikeInput;
use Src\Like\Application\UseCase\CreateLike\CreateLikeInterface;
use Src\Like\Domain\Exception\AlreadyLikedException;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;
use Tests\TestCase;

final class CreateLikePersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_persists_like_and_increments_routine_post_like_count(): void
    {
        $this->createRoutinePost();
        $this->app->make(CreateLikeInterface::class)->execute($this->input());
        $this->assertDatabaseHas('likes', ['account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'post_identifier' => 'e1954b83-b532-40ae-8b9e-49d488040d0f']);
        $this->assertDatabaseHas('posts', ['post_identifier' => 'e1954b83-b532-40ae-8b9e-49d488040d0f', 'post_like_count' => 1]);
    }

    public function test_rejects_duplicate_like_without_incrementing_the_count(): void
    {
        $this->createRoutinePost();
        $useCase = $this->app->make(CreateLikeInterface::class);
        $useCase->execute($this->input());
        $this->expectException(AlreadyLikedException::class);
        try {
            $useCase->execute($this->input());
        } finally {
            $this->assertDatabaseCount('likes', 1);
            $this->assertDatabaseHas('posts', ['post_identifier' => 'e1954b83-b532-40ae-8b9e-49d488040d0f', 'post_like_count' => 1]);
        }
    }

    private function input(): CreateLikeInput
    {
        return new CreateLikeInput(new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'), new PostIdentifier('e1954b83-b532-40ae-8b9e-49d488040d0f'));
    }

    private function createRoutinePost(): void
    {
        RoutineModel::query()->create(['routine_identifier' => '34b8d590-07cb-49ca-bfd9-cb9f40e26bd3', 'routine_name' => '朝活', 'account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'routine_execution_minutes' => 1, 'available' => true]);
        PostModel::query()->create(['post_identifier' => 'e1954b83-b532-40ae-8b9e-49d488040d0f', 'routine_identifier' => '34b8d590-07cb-49ca-bfd9-cb9f40e26bd3', 'post_category' => 'routine', 'post_like_count' => 0, 'post_support_count' => 0, 'available' => true]);
    }
}

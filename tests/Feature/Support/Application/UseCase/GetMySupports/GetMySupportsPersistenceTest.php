<?php

declare(strict_types=1);

namespace Tests\Feature\Support\Application\UseCase\GetMySupports;

use App\Models\PostModel;
use App\Models\RoutineModel;
use App\Models\SupportModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Support\Application\UseCase\GetMySupports\GetMySupportsInput;
use Src\Support\Application\UseCase\GetMySupports\GetMySupportsInterface;
use Tests\TestCase;

final class GetMySupportsPersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_only_the_authenticated_account_action_supports_in_descending_support_datetime_order(): void
    {
        $this->createRoutine('11111111-1111-4111-8111-111111111111');
        $this->createRoutine('22222222-2222-4222-8222-222222222222');
        $this->createPost('aaaaaaaa-aaaa-4aaa-8aaa-aaaaaaaaaaaa', '11111111-1111-4111-8111-111111111111', 'action', 4, 8);
        $this->createPost('bbbbbbbb-bbbb-4bbb-8bbb-bbbbbbbbbbbb', '11111111-1111-4111-8111-111111111111', 'action', 2, 3);
        $this->createPost('cccccccc-cccc-4ccc-8ccc-cccccccccccc', '11111111-1111-4111-8111-111111111111', 'routine', 1, 9);
        $this->createPost('dddddddd-dddd-4ddd-8ddd-dddddddddddd', '22222222-2222-4222-8222-222222222222', 'action', 7, 6);
        $this->createSupport('33333333-3333-4333-8333-333333333333', 'aaaaaaaa-aaaa-4aaa-8aaa-aaaaaaaaaaaa', '2026-09-03 10:00:00');
        $this->createSupport('33333333-3333-4333-8333-333333333333', 'bbbbbbbb-bbbb-4bbb-8bbb-bbbbbbbbbbbb', '2026-09-03 12:00:00');
        $this->createSupport('33333333-3333-4333-8333-333333333333', 'cccccccc-cccc-4ccc-8ccc-cccccccccccc', '2026-09-03 13:00:00');
        $this->createSupport('44444444-4444-4444-8444-444444444444', 'dddddddd-dddd-4ddd-8ddd-dddddddddddd', '2026-09-03 14:00:00');

        $output = $this->app->make(GetMySupportsInterface::class)->execute(new GetMySupportsInput(new AccountIdentifier('33333333-3333-4333-8333-333333333333'), 1, 10));

        self::assertSame(2, $output->total());
        self::assertSame(1, $output->currentPage());
        self::assertSame(1, $output->lastPage());
        self::assertSame(10, $output->perPage());
        self::assertSame(['bbbbbbbb-bbbb-4bbb-8bbb-bbbbbbbbbbbb', 'aaaaaaaa-aaaa-4aaa-8aaa-aaaaaaaaaaaa'], array_map(static fn ($item): string => $item->postIdentifier()->value(), $output->items()));
        self::assertSame(3, $output->items()[0]->postSupportCount()->value());
        self::assertSame('2026-09-03 12:00:00', $output->items()[0]->supportedAt()->format('Y-m-d H:i:s'));
    }

    public function test_paginates_my_action_supports(): void
    {
        $this->createRoutine('11111111-1111-4111-8111-111111111111');
        $this->createPost('aaaaaaaa-aaaa-4aaa-8aaa-aaaaaaaaaaaa', '11111111-1111-4111-8111-111111111111', 'action', 0, 1);
        $this->createPost('bbbbbbbb-bbbb-4bbb-8bbb-bbbbbbbbbbbb', '11111111-1111-4111-8111-111111111111', 'action', 0, 2);
        $this->createPost('cccccccc-cccc-4ccc-8ccc-cccccccccccc', '11111111-1111-4111-8111-111111111111', 'action', 0, 3);
        $this->createSupport('33333333-3333-4333-8333-333333333333', 'aaaaaaaa-aaaa-4aaa-8aaa-aaaaaaaaaaaa', '2026-09-03 10:00:00');
        $this->createSupport('33333333-3333-4333-8333-333333333333', 'bbbbbbbb-bbbb-4bbb-8bbb-bbbbbbbbbbbb', '2026-09-03 11:00:00');
        $this->createSupport('33333333-3333-4333-8333-333333333333', 'cccccccc-cccc-4ccc-8ccc-cccccccccccc', '2026-09-03 12:00:00');

        $output = $this->app->make(GetMySupportsInterface::class)->execute(new GetMySupportsInput(new AccountIdentifier('33333333-3333-4333-8333-333333333333'), 2, 2));

        self::assertSame(3, $output->total());
        self::assertSame(2, $output->currentPage());
        self::assertSame(2, $output->lastPage());
        self::assertSame(2, $output->perPage());
        self::assertSame(['aaaaaaaa-aaaa-4aaa-8aaa-aaaaaaaaaaaa'], array_map(static fn ($item): string => $item->postIdentifier()->value(), $output->items()));
    }

    private function createRoutine(string $routineIdentifier): void
    {
        RoutineModel::query()->create(['routine_identifier' => $routineIdentifier, 'routine_name' => '朝活', 'account_identifier' => '33333333-3333-4333-8333-333333333333', 'routine_execution_minutes' => 1, 'available' => true]);
    }

    private function createPost(string $postIdentifier, string $routineIdentifier, string $postCategory, int $postLikeCount, int $postSupportCount): void
    {
        PostModel::query()->create(['post_identifier' => $postIdentifier, 'routine_identifier' => $routineIdentifier, 'post_category' => $postCategory, 'post_like_count' => $postLikeCount, 'post_support_count' => $postSupportCount, 'available' => true]);
    }

    private function createSupport(string $accountIdentifier, string $postIdentifier, string $createdAt): void
    {
        SupportModel::query()->create(['account_identifier' => $accountIdentifier, 'post_identifier' => $postIdentifier]);
        SupportModel::query()
            ->where('account_identifier', $accountIdentifier)
            ->where('post_identifier', $postIdentifier)
            ->update(['created_at' => $createdAt, 'updated_at' => $createdAt]);
    }
}

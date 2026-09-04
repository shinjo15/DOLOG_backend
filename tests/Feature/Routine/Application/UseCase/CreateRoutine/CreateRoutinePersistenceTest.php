<?php

declare(strict_types=1);

namespace Tests\Feature\Routine\Application\UseCase\CreateRoutine;

use App\Models\TagModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Routine\Application\UseCase\CreateRoutine\CreateRoutineActionInput;
use Src\Routine\Application\UseCase\CreateRoutine\CreateRoutineInput;
use Src\Routine\Application\UseCase\CreateRoutine\CreateRoutineInterface;
use Src\Routine\Domain\ValueObject\RoutineActionMinutes;
use Src\Routine\Domain\ValueObject\RoutineActionName;
use Src\Routine\Domain\ValueObject\RoutineExecutionMinutes;
use Src\Routine\Domain\ValueObject\RoutineMemo;
use Src\Routine\Domain\ValueObject\RoutineName;
use Src\Routine\Domain\ValueObject\RoutineTagIdentifiers;
use Src\Shared\Application\Service\UuidServiceInterface;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\TagIdentifier;
use Tests\TestCase;

final class CreateRoutinePersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_persists_a_routine_its_actions_tags_and_routine_post(): void
    {
        TagModel::query()->create([
            'tag_identifier' => 'b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5',
            'tag_name' => '朝活',
        ]);
        $this->app->instance(UuidServiceInterface::class, new class implements UuidServiceInterface
        {
            /** @var list<string> */
            private array $values = [
                '34b8d590-07cb-49ca-bfd9-cb9f40e26bd3',
                'f6ca9f4c-169b-4b2d-a717-4a4f40d1490f',
                '75017745-e475-4337-b0f3-3fc3d670e5c7',
                'e1954b83-b532-40ae-8b9e-49d488040d0f',
            ];

            public function generate(): string
            {
                return array_shift($this->values);
            }
        });

        $this->app->make(CreateRoutineInterface::class)->execute(new CreateRoutineInput(
            accountIdentifier: new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'),
            parentRoutineIdentifier: null,
            routineName: new RoutineName('朝の集中ルーティン'),
            routineActions: [
                new CreateRoutineActionInput(
                    routineActionName: new RoutineActionName('水を飲む'),
                    routineActionMemo: null,
                    routineActionMinutes: new RoutineActionMinutes(1),
                    parentRoutineActionIndex: null,
                ),
                new CreateRoutineActionInput(
                    routineActionName: new RoutineActionName('ストレッチ'),
                    routineActionMemo: null,
                    routineActionMinutes: new RoutineActionMinutes(5),
                    parentRoutineActionIndex: 0,
                ),
            ],
            routineMemo: new RoutineMemo('仕事前に集中力を高める'),
            routineExecutionMinutes: new RoutineExecutionMinutes(40),
            routineTagIdentifiers: new RoutineTagIdentifiers([
                new TagIdentifier('b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5'),
            ]),
        ));

        $this->assertDatabaseHas('routines', [
            'routine_identifier' => '34b8d590-07cb-49ca-bfd9-cb9f40e26bd3',
            'routine_name' => '朝の集中ルーティン',
            'routine_memo' => '仕事前に集中力を高める',
            'account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87',
            'routine_execution_minutes' => 40,
            'available' => true,
        ]);
        $this->assertDatabaseHas('routine_actions', [
            'routine_action_identifier' => 'f6ca9f4c-169b-4b2d-a717-4a4f40d1490f',
            'parent_routine_action_identifier' => null,
            'routine_identifier' => '34b8d590-07cb-49ca-bfd9-cb9f40e26bd3',
            'action_name' => '水を飲む',
            'action_minutes' => 1,
            'available' => true,
        ]);
        $this->assertDatabaseHas('routine_actions', [
            'routine_action_identifier' => '75017745-e475-4337-b0f3-3fc3d670e5c7',
            'parent_routine_action_identifier' => 'f6ca9f4c-169b-4b2d-a717-4a4f40d1490f',
            'routine_identifier' => '34b8d590-07cb-49ca-bfd9-cb9f40e26bd3',
            'action_name' => 'ストレッチ',
            'action_minutes' => 5,
            'available' => true,
        ]);
        $this->assertDatabaseHas('routine_tags', [
            'routine_identifier' => '34b8d590-07cb-49ca-bfd9-cb9f40e26bd3',
            'tag_identifier' => 'b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5',
            'available' => true,
        ]);
        $this->assertDatabaseHas('posts', [
            'post_identifier' => 'e1954b83-b532-40ae-8b9e-49d488040d0f',
            'routine_identifier' => '34b8d590-07cb-49ca-bfd9-cb9f40e26bd3',
            'post_category' => 'routine',
            'post_like_count' => 0,
            'post_support_count' => 0,
            'available' => true,
        ]);
    }
}

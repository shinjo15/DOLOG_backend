<?php

declare(strict_types=1);

namespace Tests\Feature\RoutineExecution\Presentation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class CreateRoutineExecutionActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_a_routine_execution_and_an_action_post_for_the_authenticated_account(): void
    {
        $accountIdentifier = '10000000-0000-4000-8000-000000000001';
        $routineIdentifier = '30000000-0000-4000-8000-000000000001';

        $this->insertAccount($accountIdentifier);
        $this->insertRoutine($routineIdentifier, $accountIdentifier);

        $this->withSession(['account_identifier' => $accountIdentifier])
            ->postJson('/api/routine-executions', [
                'routine_identifier' => $routineIdentifier,
            ])
            ->assertCreated()
            ->assertSeeText('');

        $this->assertDatabaseHas('routine_executions', [
            'executor_account_identifier' => $accountIdentifier,
            'routine_identifier' => $routineIdentifier,
        ]);
        $this->assertDatabaseHas('posts', [
            'routine_identifier' => $routineIdentifier,
            'post_category' => 'action',
            'post_like_count' => 0,
            'post_support_count' => 0,
        ]);
        $this->assertSame(1, DB::table('posts')
            ->where('routine_identifier', $routineIdentifier)
            ->where('post_category', 'action')
            ->whereNotNull('routine_execution_identifier')
            ->count());
    }

    public function test_returns_unauthorized_without_an_authenticated_account(): void
    {
        $this->postJson('/api/routine-executions', [
            'routine_identifier' => '30000000-0000-4000-8000-000000000001',
        ])->assertUnauthorized();
    }

    private function insertAccount(string $accountIdentifier): void
    {
        DB::table('accounts')->insert([
            'account_identifier' => $accountIdentifier,
            'account_name' => '実行者',
            'email_address' => 'executor@hibilio.local',
            'available' => true,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function insertRoutine(string $routineIdentifier, string $accountIdentifier): void
    {
        DB::table('routines')->insert([
            'routine_identifier' => $routineIdentifier,
            'account_identifier' => $accountIdentifier,
            'routine_name' => '実行するルーティン',
            'available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

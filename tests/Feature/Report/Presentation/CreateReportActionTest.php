<?php

declare(strict_types=1);

namespace Tests\Feature\Report\Presentation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

final class CreateReportActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_unauthorized_without_an_authenticated_account(): void
    {
        $this->postJson('/api/reports', $this->validPayload())->assertUnauthorized()->assertSeeText('');
    }

    public function test_creates_an_account_report_for_the_authenticated_account(): void
    {
        $this->insertAccount('3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'reporter@example.com');
        $this->insertAccount('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028', 'target@example.com');

        $response = $this->authenticatedRequest($this->validPayload());

        $response->assertNoContent();
        $this->assertDatabaseHas('reports', [
            'reporter_account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87',
            'target_account_identifier' => 'f0cfa1a3-1ac7-44af-9bf4-b36c9262f028',
            'target_post_identifier' => null,
            'category' => 'spam',
            'text' => '',
        ]);
    }

    public function test_creates_a_post_report_when_the_post_belongs_to_the_target_account(): void
    {
        $this->insertAccount('3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'reporter@example.com');
        $this->insertAccount('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028', 'target@example.com');
        $this->insertPost('e1954b83-b532-40ae-8b9e-49d488040d0f', 'f0cfa1a3-1ac7-44af-9bf4-b36c9262f028');

        $this->authenticatedRequest($this->validPayload(['target_post_identifier' => 'e1954b83-b532-40ae-8b9e-49d488040d0f']))->assertNoContent();

        $this->assertDatabaseHas('reports', ['target_post_identifier' => 'e1954b83-b532-40ae-8b9e-49d488040d0f']);
    }

    public function test_returns_conflict_for_a_duplicate_report_with_exact_json(): void
    {
        $this->insertAccount('3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'reporter@example.com');
        $this->insertAccount('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028', 'target@example.com');
        $this->authenticatedRequest($this->validPayload())->assertNoContent();

        $this->authenticatedRequest($this->validPayload(['category' => 'other', 'text' => '別の通報']))
            ->assertConflict()->assertExactJson(['message' => 'すでに通報済みです。']);
    }

    public function test_returns_unprocessable_for_a_self_report_with_exact_json(): void
    {
        $this->insertAccount('3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'reporter@example.com');

        $this->authenticatedRequest($this->validPayload(['target_account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87']))
            ->assertUnprocessable()->assertExactJson(['message' => '自分自身のアカウントまたは投稿を通報することはできません。']);
    }

    public function test_returns_not_found_for_a_missing_target_account_with_exact_json(): void
    {
        $this->insertAccount('3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'reporter@example.com');

        $this->authenticatedRequest($this->validPayload())
            ->assertNotFound()->assertExactJson(['message' => '通報対象のアカウントが見つかりません。']);
    }

    public function test_returns_unprocessable_for_a_post_not_owned_by_the_target_account_with_exact_json(): void
    {
        $this->insertAccount('3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'reporter@example.com');
        $this->insertAccount('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028', 'target@example.com');
        $this->insertAccount('fa51a6c4-a28a-43f1-9f6a-7f271b458fcc', 'owner@example.com');
        $this->insertPost('e1954b83-b532-40ae-8b9e-49d488040d0f', 'fa51a6c4-a28a-43f1-9f6a-7f271b458fcc');

        $this->authenticatedRequest($this->validPayload(['target_post_identifier' => 'e1954b83-b532-40ae-8b9e-49d488040d0f']))
            ->assertUnprocessable()->assertExactJson(['message' => '指定された投稿は通報対象アカウントの投稿ではありません。']);
    }

    public function test_returns_unprocessable_for_a_missing_post_with_exact_json(): void
    {
        $this->insertAccount('3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'reporter@example.com');
        $this->insertAccount('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028', 'target@example.com');

        $this->authenticatedRequest($this->validPayload(['target_post_identifier' => 'e1954b83-b532-40ae-8b9e-49d488040d0f']))
            ->assertUnprocessable()->assertExactJson(['message' => '指定された投稿は通報対象アカウントの投稿ではありません。']);
    }

    public function test_validates_the_report_request(): void
    {
        $this->withSession(['account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87'])->postJson('/api/reports', [
            'target_account_identifier' => 'invalid',
            'target_post_identifier' => 'invalid',
            'category' => 'invalid',
            'text' => str_repeat('a', 501),
        ])->assertUnprocessable()->assertJsonValidationErrors(['target_account_identifier', 'target_post_identifier', 'category', 'text']);

        $this->withSession(['account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87'])->postJson('/api/reports', [
            'target_account_identifier' => 'f0cfa1a3-1ac7-44af-9bf4-b36c9262f028',
            'category' => 'spam',
        ])->assertUnprocessable()->assertJsonValidationErrors(['text']);
    }

    /** @param array<string, string> $overrides */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'target_account_identifier' => 'f0cfa1a3-1ac7-44af-9bf4-b36c9262f028',
            'category' => 'spam',
            'text' => '',
        ], $overrides);
    }

    /** @param array<string, string> $payload */
    private function authenticatedRequest(array $payload): TestResponse
    {
        return $this->withSession(['account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87'])->postJson('/api/reports', $payload);
    }

    private function insertAccount(string $identifier, string $emailAddress): void
    {
        DB::table('accounts')->insert([
            'account_identifier' => $identifier,
            'account_name' => $emailAddress,
            'email_address' => $emailAddress,
            'available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function insertPost(string $postIdentifier, string $accountIdentifier): void
    {
        $routineIdentifier = '75017745-e475-4337-b0f3-3fc3d670e5c7';
        DB::table('routines')->insert([
            'routine_identifier' => $routineIdentifier,
            'routine_name' => '通報対象のルーティン',
            'account_identifier' => $accountIdentifier,
            'available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'post_identifier' => $postIdentifier,
            'routine_identifier' => $routineIdentifier,
            'post_category' => 'routine',
            'post_like_count' => 0,
            'post_support_count' => 0,
            'available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

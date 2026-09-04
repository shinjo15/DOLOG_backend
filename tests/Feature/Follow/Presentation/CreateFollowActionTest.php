<?php

declare(strict_types=1);

namespace Tests\Feature\Follow\Presentation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

final class CreateFollowActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_unauthorized_without_an_authenticated_account(): void
    {
        $this->postJson('/api/follows', $this->validPayload())
            ->assertUnauthorized()
            ->assertSeeText('');
    }

    public function test_creates_a_follow_for_the_authenticated_account(): void
    {
        $this->insertAccount('3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'following@example.com');
        $this->insertAccount('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028', 'followed@example.com');

        $this->authenticatedRequest()->assertNoContent();

        $this->assertDatabaseHas('follows', [
            'following_account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87',
            'followed_account_identifier' => 'f0cfa1a3-1ac7-44af-9bf4-b36c9262f028',
        ]);
    }

    public function test_returns_conflict_for_a_duplicate_follow_with_exact_json(): void
    {
        $this->insertAccount('3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'following@example.com');
        $this->insertAccount('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028', 'followed@example.com');
        $this->authenticatedRequest()->assertNoContent();

        $this->authenticatedRequest()
            ->assertConflict()
            ->assertExactJson(['message' => 'すでにフォロー済みです。']);
    }

    public function test_returns_unprocessable_for_a_self_follow_with_exact_json(): void
    {
        $this->insertAccount('3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'following@example.com');

        $this->authenticatedRequest([
            'followed_account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87',
        ])
            ->assertUnprocessable()
            ->assertExactJson(['message' => '自分自身をフォローすることはできません。']);
    }

    public function test_returns_not_found_for_a_missing_followed_account_with_exact_json(): void
    {
        $this->insertAccount('3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'following@example.com');

        $this->authenticatedRequest()
            ->assertNotFound()
            ->assertExactJson(['message' => 'フォロー対象のアカウントが見つかりません。']);
    }

    public function test_validates_the_follow_request(): void
    {
        $this->withSession(['account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87'])
            ->postJson('/api/follows', ['followed_account_identifier' => 'invalid'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['followed_account_identifier']);
    }

    /** @param array<string, string> $overrides */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'followed_account_identifier' => 'f0cfa1a3-1ac7-44af-9bf4-b36c9262f028',
        ], $overrides);
    }

    /** @param array<string, string> $overrides */
    private function authenticatedRequest(array $overrides = []): TestResponse
    {
        return $this->withSession(['account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87'])
            ->postJson('/api/follows', $this->validPayload($overrides));
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
}

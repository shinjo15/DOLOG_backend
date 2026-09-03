<?php

declare(strict_types=1);

namespace Tests\Feature\Account\Infrastructure\Persistence;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

final class AccountSocialLinkSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_stores_social_links_in_a_separate_table_without_an_accounts_json_column(): void
    {
        self::assertFalse(Schema::hasColumn('accounts', 'social_links'));
        self::assertTrue(Schema::hasColumns('account_social_links', [
            'account_identifier',
            'type',
            'url',
            'position',
            'created_at',
            'updated_at',
        ]));
    }

    public function test_stores_favorite_tags_in_a_separate_table_without_an_accounts_json_column(): void
    {
        self::assertFalse(Schema::hasColumn('accounts', 'favorite_tag_identifiers'));
        self::assertTrue(Schema::hasColumns('favorite_tags', [
            'account_identifier',
            'tag_identifier',
            'created_at',
            'updated_at',
        ]));
    }

    public function test_deleting_an_account_cascades_to_its_social_links(): void
    {
        DB::table('accounts')->insert([
            'account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87',
            'account_name' => '朝活ユーザー',
            'email_address' => 'user@example.com',
            'available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('account_social_links')->insert([
            'account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87',
            'type' => 'x',
            'url' => 'https://x.com/example',
            'position' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('accounts')->where('account_identifier', '3b5581e9-16df-4879-b7d2-5d88dca6ab87')->delete();

        $this->assertDatabaseCount('account_social_links', 0);
    }

    public function test_deleting_an_account_or_tag_cascades_to_its_favorite_tags(): void
    {
        $this->insertAccountAndTag();
        $favoriteTag = [
            'account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87',
            'tag_identifier' => 'b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('favorite_tags')->insert($favoriteTag);

        DB::table('accounts')->where('account_identifier', '3b5581e9-16df-4879-b7d2-5d88dca6ab87')->delete();

        $this->assertDatabaseCount('favorite_tags', 0);

        $this->insertAccount();
        DB::table('favorite_tags')->insert($favoriteTag);

        DB::table('tags')->where('tag_identifier', 'b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5')->delete();

        $this->assertDatabaseCount('favorite_tags', 0);
    }

    public function test_rejects_duplicate_favorite_tags_for_an_account(): void
    {
        $this->insertAccountAndTag();
        $favoriteTag = [
            'account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87',
            'tag_identifier' => 'b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('favorite_tags')->insert($favoriteTag);

        $this->expectException(QueryException::class);
        DB::table('favorite_tags')->insert($favoriteTag);
    }

    private function insertAccountAndTag(): void
    {
        $this->insertAccount();
        DB::table('tags')->insert([
            'tag_identifier' => 'b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5',
            'tag_name' => '朝活',
            'available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function insertAccount(): void
    {
        DB::table('accounts')->insert([
            'account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87',
            'account_name' => '朝活ユーザー',
            'email_address' => 'user@example.com',
            'available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

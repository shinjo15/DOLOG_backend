<?php

declare(strict_types=1);

namespace Tests\Feature\Account\Infrastructure\Persistence;

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

    public function test_deleting_an_account_cascades_to_its_social_links(): void
    {
        DB::table('accounts')->insert([
            'account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87',
            'account_name' => '朝活ユーザー',
            'email_address' => 'user@example.com',
            'favorite_tag_identifiers' => '[]',
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
}

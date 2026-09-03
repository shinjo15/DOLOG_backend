<?php

declare(strict_types=1);

namespace Tests\Feature\Account\Presentation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Src\Account\Infrastructure\Mail\AccountRegistrationMail;
use Tests\TestCase;

final class CreateAccountActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_registers_an_account_with_a_hash_and_returns_no_sensitive_values(): void
    {
        Mail::fake();
        $this->insertFavoriteTag();

        $response = $this->postJson('/api/accounts', $this->validPayload());

        $response->assertCreated();
        self::assertSame('', $response->getContent());
        self::assertStringNotContainsString('password', $response->getContent());
        $this->assertDatabaseHas('accounts', ['email_address' => 'user@example.com', 'account_name' => '朝活ユーザー']);
        $accountIdentifier = $this->app['db']->table('accounts')->where('email_address', 'user@example.com')->value('account_identifier');
        $this->assertDatabaseHas('account_social_links', [
            'account_identifier' => $accountIdentifier,
            'type' => 'x',
            'url' => 'https://x.com/example',
            'position' => 0,
        ]);
        $this->assertDatabaseHas('favorite_tags', [
            'account_identifier' => $accountIdentifier,
            'tag_identifier' => 'b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5',
        ]);
        $credential = $this->app['db']->table('account_credentials')->where('account_identifier', $accountIdentifier)->value('passcode_hash');
        self::assertNotSame('password', $credential);
        self::assertTrue(Hash::check('password', $credential));
        Mail::assertSent(AccountRegistrationMail::class, fn (AccountRegistrationMail $mail): bool => $mail->hasTo('user@example.com'));
    }

    public function test_returns_a_japanese_validation_error_for_a_duplicate_email_address(): void
    {
        Mail::fake();
        $this->insertFavoriteTag();
        $this->postJson('/api/accounts', $this->validPayload())->assertCreated();

        $this->postJson('/api/accounts', $this->validPayload())->assertUnprocessable()->assertJson(['message' => 'このメールアドレスはすでに登録されています。']);
    }

    public function test_validates_the_required_account_registration_input(): void
    {
        $this->postJson('/api/accounts', [
            'account_name' => '', 'email_address' => 'invalid', 'passcode' => 'short',
            'social_links' => [['social_type' => 'invalid', 'social_url' => 'invalid']],
            'favorite_tag_identifiers' => ['invalid'],
        ])->assertUnprocessable()->assertJsonValidationErrors(['account_name', 'email_address', 'passcode', 'social_links.0.social_type', 'social_links.0.social_url', 'favorite_tag_identifiers.0']);
    }

    /** @return array<string, mixed> */
    private function validPayload(): array
    {
        return ['account_name' => '朝活ユーザー', 'account_bio' => '朝の時間を大切にしています。', 'email_address' => 'user@example.com', 'passcode' => 'password', 'social_links' => [['social_type' => 'x', 'social_url' => 'https://x.com/example']], 'favorite_tag_identifiers' => ['b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5']];
    }

    private function insertFavoriteTag(): void
    {
        DB::table('tags')->insert([
            'tag_identifier' => 'b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5',
            'tag_name' => '朝活',
            'available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

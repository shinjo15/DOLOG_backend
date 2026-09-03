<?php

declare(strict_types=1);

namespace Tests\Feature\Report\Infrastructure\Repository;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Src\Report\Infrastructure\Repository\AccountRepository;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Tests\TestCase;

final class AccountRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_true_only_when_the_account_exists(): void
    {
        DB::table('accounts')->insert([
            'account_identifier' => '3b5581e9-16df-4879-b7d2-5d88dca6ab87',
            'account_name' => '通報対象',
            'email_address' => 'target@example.com',
            'available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $repository = new AccountRepository;

        self::assertTrue($repository->exists(new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87')));
        self::assertFalse($repository->exists(new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028')));
    }
}

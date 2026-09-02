<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Transaction;

use Illuminate\Support\Facades\DB;
use Src\Shared\Application\Transaction\TransactionManagerInterface;

final class LaravelTransactionManager implements TransactionManagerInterface
{
    public function transaction(callable $callback): mixed
    {
        return DB::transaction(static fn (): mixed => $callback());
    }
}

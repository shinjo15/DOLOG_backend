<?php

declare(strict_types=1);

namespace Src\Shared\Application\Transaction;

interface TransactionManagerInterface
{
    /**
     * @template TReturn
     *
     * @param  callable(): TReturn  $callback
     * @return TReturn
     */
    public function transaction(callable $callback): mixed;
}

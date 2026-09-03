<?php

declare(strict_types=1);

namespace Src\Support\Application\Usecase\Query\GetMySupports;

interface GetMySupportsOutputPort
{
    /**
     * @return list<GetMySupportsItemOutputPort>
     */
    public function items(): array;

    public function currentPage(): int;

    public function lastPage(): int;

    public function perPage(): int;

    public function total(): int;
}

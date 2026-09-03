<?php

declare(strict_types=1);

namespace Src\Support\Application\UseCase\GetMySupports;

interface GetMySupportsOutputPort
{
    /**
     * @return array<GetMySupportsItemOutputPort>
     */
    public function items(): array;

    public function currentPage(): int;

    public function lastPage(): int;

    public function perPage(): int;

    public function total(): int;
}

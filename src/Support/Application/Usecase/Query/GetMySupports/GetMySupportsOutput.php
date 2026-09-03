<?php

declare(strict_types=1);

namespace Src\Support\Application\Usecase\Query\GetMySupports;

final readonly class GetMySupportsOutput implements GetMySupportsOutputPort
{
    /**
     * @param  list<GetMySupportsItemOutputPort>  $items
     */
    public function __construct(
        private array $items,
        private int $currentPage,
        private int $lastPage,
        private int $perPage,
        private int $total,
    ) {}

    public function items(): array
    {
        return $this->items;
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }

    public function lastPage(): int
    {
        return $this->lastPage;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function total(): int
    {
        return $this->total;
    }
}

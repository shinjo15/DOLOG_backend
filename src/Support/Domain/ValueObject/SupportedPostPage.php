<?php

declare(strict_types=1);

namespace Src\Support\Domain\ValueObject;

use Src\Support\Domain\Entity\SupportedPost;

final readonly class SupportedPostPage
{
    /**
     * @param  array<SupportedPost>  $items
     */
    public function __construct(
        private array $items,
        private int $currentPage,
        private int $lastPage,
        private int $perPage,
        private int $total,
    ) {}

    /**
     * @return array<SupportedPost>
     */
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

<?php

declare(strict_types=1);

namespace Src\Support\Application\Usecase\Query\GetMySupports;

interface GetMySupportsInputPort
{
    public function accountIdentifier(): string;

    public function page(): int;

    public function numberOfItemsPerPage(): int;
}

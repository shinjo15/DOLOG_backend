<?php

declare(strict_types=1);

namespace Src\Shared\Application\Service;

interface UuidServiceInterface
{
    public function generate(): string;
}

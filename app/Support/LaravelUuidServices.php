<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Str;
use Src\Shared\Application\Service\UuidServiceInterface;

final class LaravelUuidServices implements UuidServiceInterface
{
    public function generate(): string
    {
        return (string) Str::uuid();
    }
}

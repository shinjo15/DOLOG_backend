<?php

declare(strict_types=1);

namespace Src\Shared\Application\Service;

interface AuthServiceInterface
{
    public function accountIdentifier(): string;
}

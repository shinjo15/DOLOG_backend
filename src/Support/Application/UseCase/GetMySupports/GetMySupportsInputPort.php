<?php

declare(strict_types=1);

namespace Src\Support\Application\UseCase\GetMySupports;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

interface GetMySupportsInputPort
{
    public function accountIdentifier(): AccountIdentifier;

    public function page(): int;

    public function perPage(): int;
}

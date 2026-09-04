<?php

declare(strict_types=1);

namespace Src\Account\Application\Service;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

interface StorageServiceInterface
{
    public function uploadIcon(
        AccountIdentifier $accountIdentifier,
        AccountImage $image,
    ): void;

    public function uploadHeader(
        AccountIdentifier $accountIdentifier,
        AccountImage $image,
    ): void;
}

<?php

declare(strict_types=1);

namespace Src\Account\Application\Service;

use Src\Account\Application\UseCase\CreateAccount\AccountImageFile;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

interface StorageServiceInterface
{
    public function uploadIcon(
        AccountIdentifier $accountIdentifier,
        AccountImageFile $image,
    ): void;

    public function uploadHeader(
        AccountIdentifier $accountIdentifier,
        AccountImageFile $image,
    ): void;
}

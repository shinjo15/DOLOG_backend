<?php

declare(strict_types=1);

namespace Src\Account\Application\Service;

use Src\Account\Domain\ValueObject\AccountHeader;
use Src\Account\Domain\ValueObject\AccountIcon;

interface AccountImageConverterServiceInterface
{
    public function convertToIcon(string $contents): AccountIcon;

    public function convertToHeader(string $contents): AccountHeader;
}

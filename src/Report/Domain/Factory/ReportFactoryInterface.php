<?php

declare(strict_types=1);

namespace Src\Report\Domain\Factory;

use Src\Report\Domain\Entity\Report;
use Src\Report\Domain\ValueObject\ReportCategory;
use Src\Report\Domain\ValueObject\ReportText;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

interface ReportFactoryInterface
{
    public function create(
        AccountIdentifier $reporterAccountIdentifier,
        AccountIdentifier $targetAccountIdentifier,
        ?PostIdentifier $targetPostIdentifier,
        ReportCategory $reportCategory,
        ReportText $reportText,
    ): Report;
}

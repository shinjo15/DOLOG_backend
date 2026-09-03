<?php

declare(strict_types=1);

namespace Src\Report\Domain\Repository;

use Src\Report\Domain\Entity\Report;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

interface ReportRepositoryInterface
{
    public function findByReporterAndTarget(AccountIdentifier $reporterAccountIdentifier, AccountIdentifier $targetAccountIdentifier): ?Report;

    public function save(Report $report): void;
}

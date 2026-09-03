<?php

declare(strict_types=1);

namespace Src\Report\Domain\Repository;

use Src\Report\Domain\Entity\Report;

interface ReportRepositoryInterface
{
    public function save(Report $report): void;
}

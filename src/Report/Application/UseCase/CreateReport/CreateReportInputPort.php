<?php

declare(strict_types=1);

namespace Src\Report\Application\UseCase\CreateReport;

use Src\Report\Domain\ValueObject\ReportCategory;
use Src\Report\Domain\ValueObject\ReportText;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

interface CreateReportInputPort
{
    public function reporterAccountIdentifier(): AccountIdentifier;

    public function targetAccountIdentifier(): AccountIdentifier;

    public function targetPostIdentifier(): ?PostIdentifier;

    public function reportCategory(): ReportCategory;

    public function reportText(): ReportText;
}

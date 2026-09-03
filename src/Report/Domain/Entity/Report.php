<?php

declare(strict_types=1);

namespace Src\Report\Domain\Entity;

use Src\Report\Domain\Exception\SelfReportException;
use Src\Report\Domain\ValueObject\ReportCategory;
use Src\Report\Domain\ValueObject\ReportIdentifier;
use Src\Report\Domain\ValueObject\ReportText;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

final readonly class Report
{
    public function __construct(
        private ReportIdentifier $reportIdentifier,
        private AccountIdentifier $reporterAccountIdentifier,
        private AccountIdentifier $targetAccountIdentifier,
        private ?PostIdentifier $targetPostIdentifier,
        private ReportCategory $reportCategory,
        private ReportText $reportText,
    ) {
        if ($reporterAccountIdentifier->value() === $targetAccountIdentifier->value()) {
            throw new SelfReportException;
        }
    }

    public function reportIdentifier(): ReportIdentifier
    {
        return $this->reportIdentifier;
    }

    public function reporterAccountIdentifier(): AccountIdentifier
    {
        return $this->reporterAccountIdentifier;
    }

    public function targetAccountIdentifier(): AccountIdentifier
    {
        return $this->targetAccountIdentifier;
    }

    public function targetPostIdentifier(): ?PostIdentifier
    {
        return $this->targetPostIdentifier;
    }

    public function reportCategory(): ReportCategory
    {
        return $this->reportCategory;
    }

    public function reportText(): ReportText
    {
        return $this->reportText;
    }
}

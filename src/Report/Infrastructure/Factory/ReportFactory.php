<?php

declare(strict_types=1);

namespace Src\Report\Infrastructure\Factory;

use Src\Report\Domain\Entity\Report;
use Src\Report\Domain\Factory\ReportFactoryInterface;
use Src\Report\Domain\ValueObject\ReportCategory;
use Src\Report\Domain\ValueObject\ReportIdentifier;
use Src\Report\Domain\ValueObject\ReportText;
use Src\Shared\Application\Service\UuidServiceInterface;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

final readonly class ReportFactory implements ReportFactoryInterface
{
    public function __construct(private UuidServiceInterface $uuidService) {}

    public function create(
        AccountIdentifier $reporterAccountIdentifier,
        AccountIdentifier $targetAccountIdentifier,
        ?PostIdentifier $targetPostIdentifier,
        ReportCategory $reportCategory,
        ReportText $reportText,
    ): Report {
        return new Report(
            new ReportIdentifier($this->uuidService->generate()),
            $reporterAccountIdentifier,
            $targetAccountIdentifier,
            $targetPostIdentifier,
            $reportCategory,
            $reportText,
        );
    }
}

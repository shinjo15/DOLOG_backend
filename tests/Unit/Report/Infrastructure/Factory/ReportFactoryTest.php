<?php

declare(strict_types=1);

namespace Tests\Unit\Report\Infrastructure\Factory;

use PHPUnit\Framework\TestCase;
use Src\Report\Domain\ValueObject\ReportCategory;
use Src\Report\Domain\ValueObject\ReportText;
use Src\Report\Infrastructure\Factory\ReportFactory;
use Src\Shared\Application\Service\UuidServiceInterface;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

final class ReportFactoryTest extends TestCase
{
    public function test_creates_a_report_with_the_uuid_service_identifier(): void
    {
        $report = (new ReportFactory(new FixedUuidService))->create(
            reporterAccountIdentifier: new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028'),
            targetAccountIdentifier: new AccountIdentifier('fa51a6c4-a28a-43f1-9f6a-7f271b458fcc'),
            targetPostIdentifier: new PostIdentifier('e1954b83-b532-40ae-8b9e-49d488040d0f'),
            reportCategory: ReportCategory::HARASSMENT,
            reportText: new ReportText('嫌がらせを受けました。'),
        );

        self::assertSame('3b5581e9-16df-4879-b7d2-5d88dca6ab87', $report->reportIdentifier()->value());
    }
}

final class FixedUuidService implements UuidServiceInterface
{
    public function generate(): string
    {
        return '3b5581e9-16df-4879-b7d2-5d88dca6ab87';
    }
}

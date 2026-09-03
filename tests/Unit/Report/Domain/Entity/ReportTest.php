<?php

declare(strict_types=1);

namespace Tests\Unit\Report\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Src\Report\Domain\Entity\Report;
use Src\Report\Domain\Exception\SelfReportException;
use Src\Report\Domain\ValueObject\ReportCategory;
use Src\Report\Domain\ValueObject\ReportIdentifier;
use Src\Report\Domain\ValueObject\ReportText;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

final class ReportTest extends TestCase
{
    public function test_retains_an_account_only_report(): void
    {
        $reportIdentifier = new ReportIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87');
        $reporterAccountIdentifier = new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028');
        $targetAccountIdentifier = new AccountIdentifier('e1954b83-b532-40ae-8b9e-49d488040d0f');
        $reportCategory = ReportCategory::SPAM;
        $reportText = new ReportText('繰り返し迷惑な投稿をしています。');

        $report = new Report(
            reportIdentifier: $reportIdentifier,
            reporterAccountIdentifier: $reporterAccountIdentifier,
            targetAccountIdentifier: $targetAccountIdentifier,
            targetPostIdentifier: null,
            reportCategory: $reportCategory,
            reportText: $reportText,
        );

        self::assertSame($reportIdentifier, $report->reportIdentifier());
        self::assertSame($reporterAccountIdentifier, $report->reporterAccountIdentifier());
        self::assertSame($targetAccountIdentifier, $report->targetAccountIdentifier());
        self::assertNull($report->targetPostIdentifier());
        self::assertSame($reportCategory, $report->reportCategory());
        self::assertSame($reportText, $report->reportText());
    }

    public function test_rejects_a_report_of_the_reporters_own_account(): void
    {
        $accountIdentifier = new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028');

        $this->expectException(SelfReportException::class);

        new Report(
            reportIdentifier: new ReportIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'),
            reporterAccountIdentifier: $accountIdentifier,
            targetAccountIdentifier: $accountIdentifier,
            targetPostIdentifier: null,
            reportCategory: ReportCategory::SPAM,
            reportText: new ReportText('自身のアカウントを通報します。'),
        );
    }

    public function test_rejects_a_report_of_the_reporters_own_post(): void
    {
        $accountIdentifier = new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028');

        $this->expectException(SelfReportException::class);
        $this->expectExceptionMessage('自分自身のアカウントまたは投稿を通報することはできません。');

        new Report(
            reportIdentifier: new ReportIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'),
            reporterAccountIdentifier: $accountIdentifier,
            targetAccountIdentifier: $accountIdentifier,
            targetPostIdentifier: new PostIdentifier('e1954b83-b532-40ae-8b9e-49d488040d0f'),
            reportCategory: ReportCategory::SPAM,
            reportText: new ReportText('自分の投稿を通報します。'),
        );
    }

    public function test_has_required_category_backing_values(): void
    {
        self::assertSame('spam', ReportCategory::SPAM->value);
        self::assertSame('harassment', ReportCategory::HARASSMENT->value);
        self::assertSame('inappropriate_content', ReportCategory::INAPPROPRIATE_CONTENT->value);
        self::assertSame('impersonation', ReportCategory::IMPERSONATION->value);
        self::assertSame('other', ReportCategory::OTHER->value);
    }

    public function test_retains_a_post_report(): void
    {
        $postIdentifier = new PostIdentifier('e1954b83-b532-40ae-8b9e-49d488040d0f');

        $report = new Report(
            reportIdentifier: new ReportIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'),
            reporterAccountIdentifier: new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028'),
            targetAccountIdentifier: new AccountIdentifier('fa51a6c4-a28a-43f1-9f6a-7f271b458fcc'),
            targetPostIdentifier: $postIdentifier,
            reportCategory: ReportCategory::INAPPROPRIATE_CONTENT,
            reportText: new ReportText('不適切な投稿です。'),
        );

        self::assertSame($postIdentifier, $report->targetPostIdentifier());
    }
}

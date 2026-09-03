<?php

declare(strict_types=1);

namespace Tests\Feature\Report\Infrastructure\Repository;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Src\Report\Domain\Entity\Report;
use Src\Report\Domain\Exception\DuplicateReportException;
use Src\Report\Domain\ValueObject\ReportCategory;
use Src\Report\Domain\ValueObject\ReportIdentifier;
use Src\Report\Domain\ValueObject\ReportText;
use Src\Report\Infrastructure\Repository\ReportRepository;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Tests\TestCase;

final class ReportRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_saves_and_restores_an_account_only_report(): void
    {
        $this->insertAccounts();
        $repository = new ReportRepository;
        $repository->save($this->report());

        $report = $repository->findByReporterAndTarget(new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'), new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028'));

        self::assertSame('75017745-e475-4337-b0f3-3fc3d670e5c7', $report?->reportIdentifier()->value());
        self::assertNull($report?->targetPostIdentifier());
        self::assertSame('', $report?->reportText()->value());
    }

    public function test_database_enforces_one_report_per_reporter_and_target(): void
    {
        $this->insertAccounts();
        $repository = new ReportRepository;
        $repository->save($this->report());

        $this->expectException(DuplicateReportException::class);
        $repository->save(new Report(new ReportIdentifier('e1954b83-b532-40ae-8b9e-49d488040d0f'), new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'), new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028'), null, ReportCategory::OTHER, new ReportText('重複')));
    }

    private function report(): Report
    {
        return new Report(
            new ReportIdentifier('75017745-e475-4337-b0f3-3fc3d670e5c7'),
            new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'),
            new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028'),
            null,
            ReportCategory::SPAM,
            new ReportText(''),
        );
    }

    private function insertAccounts(): void
    {
        foreach (['3b5581e9-16df-4879-b7d2-5d88dca6ab87', 'f0cfa1a3-1ac7-44af-9bf4-b36c9262f028'] as $identifier) {
            DB::table('accounts')->insert([
                'account_identifier' => $identifier,
                'account_name' => $identifier,
                'email_address' => $identifier.'@example.com',
                'available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

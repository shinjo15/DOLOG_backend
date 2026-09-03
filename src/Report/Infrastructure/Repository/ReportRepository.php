<?php

declare(strict_types=1);

namespace Src\Report\Infrastructure\Repository;

use App\Models\ReportModel;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Src\Report\Domain\Entity\Report;
use Src\Report\Domain\Exception\DuplicateReportException;
use Src\Report\Domain\Repository\ReportRepositoryInterface;
use Src\Report\Domain\ValueObject\ReportCategory;
use Src\Report\Domain\ValueObject\ReportIdentifier;
use Src\Report\Domain\ValueObject\ReportText;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

final class ReportRepository implements ReportRepositoryInterface
{
    public function findByReporterAndTarget(AccountIdentifier $reporterAccountIdentifier, AccountIdentifier $targetAccountIdentifier): ?Report
    {
        $model = ReportModel::query()
            ->where('reporter_account_identifier', $reporterAccountIdentifier->value())
            ->where('target_account_identifier', $targetAccountIdentifier->value())
            ->first();

        return $model === null ? null : $this->restore($model);
    }

    public function existsPostByAccount(PostIdentifier $postIdentifier, AccountIdentifier $accountIdentifier): bool
    {
        return DB::table('posts')
            ->join('routines', 'routines.routine_identifier', '=', 'posts.routine_identifier')
            ->where('posts.post_identifier', $postIdentifier->value())
            ->where('routines.account_identifier', $accountIdentifier->value())
            ->exists();
    }

    public function save(Report $report): void
    {
        try {
            ReportModel::query()->create([
                'report_identifier' => $report->reportIdentifier()->value(),
                'reporter_account_identifier' => $report->reporterAccountIdentifier()->value(),
                'target_account_identifier' => $report->targetAccountIdentifier()->value(),
                'target_post_identifier' => $report->targetPostIdentifier()?->value(),
                'category' => $report->reportCategory()->value,
                'text' => $report->reportText()->value(),
            ]);
        } catch (UniqueConstraintViolationException) {
            throw new DuplicateReportException;
        }
    }

    private function restore(ReportModel $model): Report
    {
        return new Report(
            new ReportIdentifier($model->report_identifier),
            new AccountIdentifier($model->reporter_account_identifier),
            new AccountIdentifier($model->target_account_identifier),
            $model->target_post_identifier === null ? null : new PostIdentifier($model->target_post_identifier),
            ReportCategory::from($model->category),
            new ReportText($model->text),
        );
    }
}

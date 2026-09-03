<?php

declare(strict_types=1);

namespace Src\Report\Application\UseCase\CreateReport;

use Src\Account\Domain\Repository\AccountRepositoryInterface;
use Src\Report\Application\Query\TargetPostOwnershipQueryInterface;
use Src\Report\Domain\Exception\DuplicateReportException;
use Src\Report\Domain\Exception\TargetAccountNotFoundException;
use Src\Report\Domain\Exception\TargetPostMismatchException;
use Src\Report\Domain\Factory\ReportFactoryInterface;
use Src\Report\Domain\Repository\ReportRepositoryInterface;
use Src\Shared\Application\Transaction\TransactionManagerInterface;

final readonly class CreateReport implements CreateReportInterface
{
    public function __construct(
        private TransactionManagerInterface $transactionManager,
        private AccountRepositoryInterface $accountRepository,
        private TargetPostOwnershipQueryInterface $targetPostOwnershipQuery,
        private ReportRepositoryInterface $reportRepository,
        private ReportFactoryInterface $reportFactory,
    ) {}

    public function execute(CreateReportInputPort $input): void
    {
        $this->transactionManager->transaction(function () use ($input): void {
            if ($this->accountRepository->find($input->targetAccountIdentifier()) === null) {
                throw new TargetAccountNotFoundException;
            }
            if ($input->targetPostIdentifier() !== null && ! $this->targetPostOwnershipQuery->belongsToAccount($input->targetPostIdentifier(), $input->targetAccountIdentifier())) {
                throw new TargetPostMismatchException;
            }
            if ($this->reportRepository->findByReporterAndTarget($input->reporterAccountIdentifier(), $input->targetAccountIdentifier()) !== null) {
                throw new DuplicateReportException;
            }

            $this->reportRepository->save($this->reportFactory->create(
                $input->reporterAccountIdentifier(),
                $input->targetAccountIdentifier(),
                $input->targetPostIdentifier(),
                $input->reportCategory(),
                $input->reportText(),
            ));
        });
    }
}

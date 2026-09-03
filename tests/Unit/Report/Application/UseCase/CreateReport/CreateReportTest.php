<?php

declare(strict_types=1);

namespace Tests\Unit\Report\Application\UseCase\CreateReport;

use PHPUnit\Framework\TestCase;
use Src\Account\Domain\Entity\Account;
use Src\Account\Domain\Repository\AccountRepositoryInterface;
use Src\Account\Domain\ValueObject\AccountName;
use Src\Account\Domain\ValueObject\EmailAddress;
use Src\Account\Domain\ValueObject\FavoriteTagIdentifiers;
use Src\Report\Application\Query\TargetPostOwnershipQueryInterface;
use Src\Report\Application\UseCase\CreateReport\CreateReport;
use Src\Report\Application\UseCase\CreateReport\CreateReportInput;
use Src\Report\Domain\Entity\Report;
use Src\Report\Domain\Exception\DuplicateReportException;
use Src\Report\Domain\Exception\SelfReportException;
use Src\Report\Domain\Exception\TargetAccountNotFoundException;
use Src\Report\Domain\Exception\TargetPostMismatchException;
use Src\Report\Domain\Factory\ReportFactoryInterface;
use Src\Report\Domain\Repository\ReportRepositoryInterface;
use Src\Report\Domain\ValueObject\ReportCategory;
use Src\Report\Domain\ValueObject\ReportIdentifier;
use Src\Report\Domain\ValueObject\ReportText;
use Src\Shared\Application\Transaction\TransactionManagerInterface;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

final class CreateReportTest extends TestCase
{
    public function test_creates_an_account_report(): void
    {
        $repository = new InMemoryReportRepository;
        $this->useCase($this->account('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028'), true, $repository)->execute($this->input());

        self::assertCount(1, $repository->saved);
        self::assertNull($repository->saved[0]->targetPostIdentifier());
    }

    public function test_creates_a_post_report(): void
    {
        $repository = new InMemoryReportRepository;
        $this->useCase($this->account('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028'), true, $repository)->execute($this->input(new PostIdentifier('e1954b83-b532-40ae-8b9e-49d488040d0f')));

        self::assertSame('e1954b83-b532-40ae-8b9e-49d488040d0f', $repository->saved[0]->targetPostIdentifier()?->value());
    }

    public function test_rejects_a_missing_target_account(): void
    {
        $this->expectException(TargetAccountNotFoundException::class);
        $this->useCase(null, true, new InMemoryReportRepository)->execute($this->input());
    }

    public function test_rejects_a_post_not_owned_by_the_target_account(): void
    {
        $this->expectException(TargetPostMismatchException::class);
        $this->useCase($this->account('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028'), false, new InMemoryReportRepository)->execute($this->input(new PostIdentifier('e1954b83-b532-40ae-8b9e-49d488040d0f')));
    }

    public function test_rejects_a_duplicate_report(): void
    {
        $repository = new InMemoryReportRepository;
        $repository->existing = $this->report();

        $this->expectException(DuplicateReportException::class);
        $this->useCase($this->account('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028'), true, $repository)->execute($this->input());
    }

    public function test_rejects_a_self_report(): void
    {
        $this->expectException(SelfReportException::class);
        $this->useCase($this->account('3b5581e9-16df-4879-b7d2-5d88dca6ab87'), true, new InMemoryReportRepository)->execute($this->input(null, '3b5581e9-16df-4879-b7d2-5d88dca6ab87'));
    }

    private function useCase(?Account $targetAccount, bool $postBelongsToTarget, InMemoryReportRepository $reportRepository): CreateReport
    {
        return new CreateReport(
            new ImmediateTransactionManager,
            new InMemoryAccountRepository($targetAccount),
            new FixedTargetPostOwnershipQuery($postBelongsToTarget),
            $reportRepository,
            new FixedReportFactory,
        );
    }

    private function input(?PostIdentifier $postIdentifier = null, string $targetAccountIdentifier = 'f0cfa1a3-1ac7-44af-9bf4-b36c9262f028'): CreateReportInput
    {
        return new CreateReportInput(new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'), new AccountIdentifier($targetAccountIdentifier), $postIdentifier, ReportCategory::SPAM, new ReportText(''));
    }

    private function account(string $identifier): Account
    {
        return Account::create(new AccountIdentifier($identifier), new AccountName('対象'), null, new EmailAddress($identifier.'@example.com'), [], new FavoriteTagIdentifiers([]));
    }

    private function report(): Report
    {
        return (new FixedReportFactory)->create(new AccountIdentifier('3b5581e9-16df-4879-b7d2-5d88dca6ab87'), new AccountIdentifier('f0cfa1a3-1ac7-44af-9bf4-b36c9262f028'), null, ReportCategory::SPAM, new ReportText(''));
    }
}

final class ImmediateTransactionManager implements TransactionManagerInterface
{
    public function transaction(callable $callback): mixed
    {
        return $callback();
    }
}
final class InMemoryAccountRepository implements AccountRepositoryInterface
{
    public function __construct(private ?Account $account) {}

    public function find(AccountIdentifier $accountIdentifier): ?Account
    {
        return $this->account;
    }

    public function findByEmailAddress(EmailAddress $emailAddress): ?Account
    {
        return null;
    }

    public function save(Account $account): void {}
}
final class FixedTargetPostOwnershipQuery implements TargetPostOwnershipQueryInterface
{
    public function __construct(private bool $belongs) {}

    public function belongsToAccount(PostIdentifier $postIdentifier, AccountIdentifier $accountIdentifier): bool
    {
        return $this->belongs;
    }
}
final class InMemoryReportRepository implements ReportRepositoryInterface
{
    public ?Report $existing = null;

    public array $saved = [];

    public function findByReporterAndTarget(AccountIdentifier $reporterAccountIdentifier, AccountIdentifier $targetAccountIdentifier): ?Report
    {
        return $this->existing;
    }

    public function save(Report $report): void
    {
        $this->saved[] = $report;
    }
}
final class FixedReportFactory implements ReportFactoryInterface
{
    public function create(AccountIdentifier $reporterAccountIdentifier, AccountIdentifier $targetAccountIdentifier, ?PostIdentifier $targetPostIdentifier, ReportCategory $reportCategory, ReportText $reportText): Report
    {
        return new Report(new ReportIdentifier('75017745-e475-4337-b0f3-3fc3d670e5c7'), $reporterAccountIdentifier, $targetAccountIdentifier, $targetPostIdentifier, $reportCategory, $reportText);
    }
}

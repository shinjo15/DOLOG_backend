<?php

declare(strict_types=1);

namespace Tests\Unit\Report\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Src\Report\Domain\ValueObject\ReportText;

final class ReportTextTest extends TestCase
{
    public function test_accepts_an_empty_report_text(): void
    {
        $reportText = new ReportText('');

        self::assertSame('', $reportText->value());
    }

    public function test_accepts_a_whitespace_only_report_text(): void
    {
        $reportText = new ReportText(" \t\n");

        self::assertSame(" \t\n", $reportText->value());
    }

    public function test_rejects_a_report_text_longer_than_500_characters(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('通報内容は500文字以内で入力してください。');

        new ReportText(str_repeat('あ', 501));
    }
}

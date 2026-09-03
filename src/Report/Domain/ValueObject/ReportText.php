<?php

declare(strict_types=1);

namespace Src\Report\Domain\ValueObject;

final readonly class ReportText
{
    public function __construct(
        private string $value,
    ) {
        if (mb_strlen($value) > 500) {
            throw new \InvalidArgumentException('通報内容は500文字以内で入力してください。');
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}

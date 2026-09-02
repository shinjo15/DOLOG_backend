<?php

declare(strict_types=1);

namespace Tests\Unit\RoutineAction\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Src\RoutineAction\Domain\ValueObject\RoutineActionMemo;
use Src\RoutineAction\Domain\ValueObject\RoutineActionMinutes;
use Src\RoutineAction\Domain\ValueObject\RoutineActionName;

final class RoutineActionValueObjectsTest extends TestCase
{
    public function test_rejects_a_routine_action_name_longer_than_50_characters(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('ルーティン行動名は50文字以下である必要があります。');

        new RoutineActionName(str_repeat('あ', 51));
    }

    public function test_rejects_a_routine_action_memo_longer_than_300_characters(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('ルーティン行動メモは300文字以下である必要があります。');

        new RoutineActionMemo(str_repeat('あ', 301));
    }

    public function test_rejects_non_positive_routine_action_minutes(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('ルーティン行動時間は1分以上である必要があります。');

        new RoutineActionMinutes(0);
    }
}

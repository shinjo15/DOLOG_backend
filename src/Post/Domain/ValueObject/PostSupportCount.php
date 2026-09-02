<?php

declare(strict_types=1);

namespace Src\Post\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\Base\IntegerValueObject;

final readonly class PostSupportCount extends IntegerValueObject
{
    protected function validate(int $value): void
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('投稿の応援総数は0以上である必要があります。');
        }
    }
}

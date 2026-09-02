<?php

declare(strict_types=1);

namespace Src\Post\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\Base\IntegerValueObject;

final readonly class PostLikeCount extends IntegerValueObject
{
    protected function validate(int $value): void
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('投稿のいいね総数は0以上である必要があります。');
        }
    }
}

<?php

declare(strict_types=1);

namespace Src\Tag\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\Base\StringValueObject;

final readonly class TagName extends StringValueObject
{
    protected function validate(string $value): void
    {
        parent::validate($value);

        if (mb_strlen($value) > 50) {
            throw new \InvalidArgumentException('タグ名は50文字以下である必要があります。');
        }
    }
}

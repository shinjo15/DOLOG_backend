<?php

declare(strict_types=1);

namespace Tests\Unit\Tag\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Src\Shared\Domain\ValueObject\Base\StringValueObject;
use Src\Tag\Domain\ValueObject\TagName;

final class TagNameTest extends TestCase
{
    public function test_retains_a_valid_tag_name(): void
    {
        $tagName = new TagName('朝活');

        $this->assertSame('朝活', $tagName->value());
    }

    public function test_accepts_a_tag_name_of_50_characters(): void
    {
        $tagName = new TagName(str_repeat('あ', 50));

        $this->assertSame(str_repeat('あ', 50), $tagName->value());
    }

    public function test_rejects_a_blank_tag_name_in_japanese(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('文字列の値は空白にできません。');

        new TagName('   ');
    }

    public function test_rejects_a_tag_name_longer_than_50_characters_in_japanese(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('タグ名は50文字以下である必要があります。');

        new TagName(str_repeat('あ', 51));
    }

    public function test_uses_the_shared_string_value_object_base(): void
    {
        $this->assertInstanceOf(StringValueObject::class, new TagName('朝活'));
    }
}

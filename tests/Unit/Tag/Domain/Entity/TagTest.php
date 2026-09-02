<?php

declare(strict_types=1);

namespace Tests\Unit\Tag\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Src\Shared\Domain\ValueObject\Identifier\TagIdentifier;
use Src\Tag\Domain\Entity\Tag;
use Src\Tag\Domain\ValueObject\TagName;

final class TagTest extends TestCase
{
    public function test_retains_the_values_of_a_created_tag(): void
    {
        $tagIdentifier = new TagIdentifier('b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5');
        $tagName = new TagName('朝活');

        $tag = Tag::create(
            tagIdentifier: $tagIdentifier,
            tagName: $tagName,
        );

        $this->assertSame($tagIdentifier, $tag->tagIdentifier());
        $this->assertSame($tagName, $tag->tagName());
    }
}

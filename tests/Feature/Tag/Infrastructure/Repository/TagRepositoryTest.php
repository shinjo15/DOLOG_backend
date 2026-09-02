<?php

declare(strict_types=1);

namespace Tests\Feature\Tag\Infrastructure\Repository;

use App\Models\TagModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Shared\Domain\ValueObject\Identifier\TagIdentifier;
use Src\Tag\Domain\Entity\Tag;
use Src\Tag\Domain\ValueObject\TagName;
use Src\Tag\Infrastructure\Repository\TagRepository;
use Tests\TestCase;

final class TagRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_uses_the_tags_table_model(): void
    {
        $this->assertSame('tags', (new TagModel)->getTable());
    }

    public function test_saves_a_tag(): void
    {
        $tag = Tag::create(
            tagIdentifier: new TagIdentifier('b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5'),
            tagName: new TagName('朝活'),
        );

        (new TagRepository)->save($tag);

        $this->assertDatabaseHas('tags', [
            'tag_identifier' => 'b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5',
            'tag_name' => '朝活',
            'available' => true,
        ]);
    }
}

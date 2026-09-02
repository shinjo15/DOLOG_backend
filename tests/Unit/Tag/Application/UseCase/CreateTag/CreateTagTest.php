<?php

declare(strict_types=1);

namespace Tests\Unit\Tag\Application\UseCase\CreateTag;

use PHPUnit\Framework\TestCase;
use Src\Shared\Domain\ValueObject\Identifier\TagIdentifier;
use Src\Tag\Application\UseCase\CreateTag\CreateTag;
use Src\Tag\Application\UseCase\CreateTag\CreateTagInput;
use Src\Tag\Domain\Entity\Tag;
use Src\Tag\Domain\Factory\TagFactoryInterface;
use Src\Tag\Domain\Repository\TagRepositoryInterface;
use Src\Tag\Domain\ValueObject\TagName;

final class CreateTagTest extends TestCase
{
    public function test_creates_and_saves_a_tag(): void
    {
        $repository = new InMemoryTagRepository;
        $factory = new InMemoryTagFactory('b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5');
        $useCase = new CreateTag(
            tagRepository: $repository,
            tagFactory: $factory,
        );
        $useCase->execute(new CreateTagInput(new TagName('朝活')));

        $this->assertCount(1, $repository->savedTags);
        $this->assertSame('b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5', $repository->savedTags[0]->tagIdentifier()->value());
        $this->assertSame('朝活', $factory->createdTagName?->value());
        $this->assertSame('朝活', $repository->savedTags[0]->tagName()->value());
    }
}

final class InMemoryTagFactory implements TagFactoryInterface
{
    public ?TagName $createdTagName = null;

    public function __construct(
        private readonly string $tagIdentifier,
    ) {}

    public function create(TagName $tagName): Tag
    {
        $this->createdTagName = $tagName;

        return Tag::create(
            tagIdentifier: new TagIdentifier($this->tagIdentifier),
            tagName: $tagName,
        );
    }
}

final class InMemoryTagRepository implements TagRepositoryInterface
{
    /**
     * @var list<Tag>
     */
    public array $savedTags = [];

    public function save(Tag $tag): void
    {
        $this->savedTags[] = $tag;
    }
}

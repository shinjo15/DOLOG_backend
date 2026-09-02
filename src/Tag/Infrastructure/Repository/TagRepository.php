<?php

declare(strict_types=1);

namespace Src\Tag\Infrastructure\Repository;

use App\Models\TagModel;
use Src\Tag\Domain\Entity\Tag;
use Src\Tag\Domain\Repository\TagRepositoryInterface;

final readonly class TagRepository implements TagRepositoryInterface
{
    public function save(Tag $tag): void
    {
        TagModel::query()->create([
            'tag_identifier' => $tag->tagIdentifier()->value(),
            'tag_name' => $tag->tagName()->value(),
            'available' => true,
        ]);
    }
}

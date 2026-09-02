<?php

declare(strict_types=1);

namespace Src\Tag\Application\UseCase\CreateTag;

use Src\Tag\Domain\Factory\TagFactoryInterface;
use Src\Tag\Domain\Repository\TagRepositoryInterface;

final readonly class CreateTag implements CreateTagInterface
{
    public function __construct(
        private TagRepositoryInterface $tagRepository,
        private TagFactoryInterface $tagFactory,
    ) {}

    public function execute(CreateTagInputPort $input): void
    {
        $tag = $this->tagFactory->create($input->tagName());

        $this->tagRepository->save($tag);
    }
}

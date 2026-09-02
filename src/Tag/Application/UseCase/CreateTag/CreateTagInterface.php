<?php

declare(strict_types=1);

namespace Src\Tag\Application\UseCase\CreateTag;

interface CreateTagInterface
{
    public function execute(CreateTagInputPort $input): void;
}

<?php

declare(strict_types=1);

namespace Src\Like\Application\UseCase\CreateLike;

interface CreateLikeInterface
{
    public function execute(CreateLikeInput $input): void;
}

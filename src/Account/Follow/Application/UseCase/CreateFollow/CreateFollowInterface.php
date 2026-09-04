<?php

declare(strict_types=1);

namespace Src\Account\Follow\Application\UseCase\CreateFollow;

interface CreateFollowInterface
{
    public function execute(CreateFollowInputPort $input): void;
}

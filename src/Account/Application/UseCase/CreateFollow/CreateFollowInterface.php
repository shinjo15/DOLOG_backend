<?php

declare(strict_types=1);

namespace Src\Account\Application\UseCase\CreateFollow;

interface CreateFollowInterface
{
    public function execute(CreateFollowInputPort $input): void;
}

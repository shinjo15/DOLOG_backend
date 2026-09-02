<?php

declare(strict_types=1);

namespace Src\Support\Application\UseCase\CreateSupport;

interface CreateSupportInterface
{
    public function execute(CreateSupportInput $input): void;
}

<?php

declare(strict_types=1);

namespace Src\Support\Application\UseCase\GetMySupports;

interface GetMySupportsInterface
{
    public function execute(GetMySupportsInputPort $input): GetMySupportsOutputPort;
}

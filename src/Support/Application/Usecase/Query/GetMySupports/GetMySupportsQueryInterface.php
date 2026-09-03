<?php

declare(strict_types=1);

namespace Src\Support\Application\Usecase\Query\GetMySupports;

interface GetMySupportsQueryInterface
{
    public function execute(GetMySupportsInputPort $input): GetMySupportsOutputPort;
}

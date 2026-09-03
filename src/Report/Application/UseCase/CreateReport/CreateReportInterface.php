<?php

declare(strict_types=1);

namespace Src\Report\Application\UseCase\CreateReport;

interface CreateReportInterface
{
    public function execute(CreateReportInputPort $input): void;
}

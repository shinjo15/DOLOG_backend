<?php

declare(strict_types=1);

namespace Src\Report\Domain\Exception;

final class DuplicateReportException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('すでに通報済みです。');
    }
}

<?php

declare(strict_types=1);

namespace Src\Support\Domain\Exception;

final class AlreadySupportedException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('すでに応援済みです。');
    }
}

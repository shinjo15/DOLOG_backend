<?php

declare(strict_types=1);

namespace Src\Account\Domain\Exception;

final class DuplicateBlockException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('すでにブロック済みです。');
    }
}

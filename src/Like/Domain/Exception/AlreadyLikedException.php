<?php

declare(strict_types=1);

namespace Src\Like\Domain\Exception;

final class AlreadyLikedException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('すでにいいね済みです。');
    }
}

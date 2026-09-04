<?php

declare(strict_types=1);

namespace Src\Account\Follow\Domain\Exception;

final class DuplicateFollowException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('すでにフォロー済みです。');
    }
}

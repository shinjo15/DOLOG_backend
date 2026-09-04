<?php

declare(strict_types=1);

namespace Src\Account\Domain\Exception;

final class SelfFollowException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('自分自身をフォローすることはできません。');
    }
}

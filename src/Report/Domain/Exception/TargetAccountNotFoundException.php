<?php

declare(strict_types=1);

namespace Src\Report\Domain\Exception;

final class TargetAccountNotFoundException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('通報対象のアカウントが見つかりません。');
    }
}

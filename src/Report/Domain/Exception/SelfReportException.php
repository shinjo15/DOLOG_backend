<?php

declare(strict_types=1);

namespace Src\Report\Domain\Exception;

final class SelfReportException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('自分自身のアカウントまたは投稿を通報することはできません。');
    }
}

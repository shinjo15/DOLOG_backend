<?php

declare(strict_types=1);

namespace Src\Report\Domain\Exception;

final class TargetPostMismatchException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('指定された投稿は通報対象アカウントの投稿ではありません。');
    }
}

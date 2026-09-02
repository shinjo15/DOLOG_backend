<?php

declare(strict_types=1);

namespace Src\Post\Domain\Exception;

final class UnsupportedPostSupportException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('応援できるのは実行投稿のみです。');
    }
}

<?php

declare(strict_types=1);

namespace Src\Support\Domain\Exception;

final class PostNotFoundForSupportException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('投稿が見つかりません。');
    }
}

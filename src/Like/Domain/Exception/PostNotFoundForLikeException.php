<?php

declare(strict_types=1);

namespace Src\Like\Domain\Exception;

final class PostNotFoundForLikeException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('投稿が見つかりません。');
    }
}

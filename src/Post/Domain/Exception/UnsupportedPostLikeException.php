<?php

declare(strict_types=1);

namespace Src\Post\Domain\Exception;

final class UnsupportedPostLikeException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('いいねできるのはルーティン投稿のみです。');
    }
}

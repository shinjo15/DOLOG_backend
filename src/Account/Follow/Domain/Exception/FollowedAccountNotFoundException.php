<?php

declare(strict_types=1);

namespace Src\Account\Follow\Domain\Exception;

final class FollowedAccountNotFoundException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('フォロー対象のアカウントが見つかりません。');
    }
}

<?php

declare(strict_types=1);

namespace Src\Account\Domain\Exception;

final class AccountNotFoundException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('アカウントが見つかりません。');
    }
}

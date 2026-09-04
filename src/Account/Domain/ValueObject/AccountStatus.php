<?php

declare(strict_types=1);

namespace Src\Account\Domain\ValueObject;

enum AccountStatus: string
{
    case ACTIVE = 'active';
    case TEMPORARILY_BANNED = 'temporarily_banned';
    case PERMANENTLY_BANNED = 'permanently_banned';
}

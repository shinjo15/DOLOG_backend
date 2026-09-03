<?php

declare(strict_types=1);

namespace Src\Account\Domain\Exception;

use DomainException;

final class DuplicateEmailAddressException extends DomainException
{
    public function __construct()
    {
        parent::__construct('このメールアドレスはすでに登録されています。');
    }
}

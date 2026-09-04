<?php

declare(strict_types=1);

namespace Src\Account\Domain\Exception;

final class InvalidAccountStatusException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('利用ステータスとBAN解除日時の組み合わせが不正です。');
    }
}

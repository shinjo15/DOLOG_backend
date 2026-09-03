<?php

declare(strict_types=1);

namespace Src\Report\Domain\ValueObject;

enum ReportCategory: string
{
    case SPAM = 'spam';
    case HARASSMENT = 'harassment';
    case INAPPROPRIATE_CONTENT = 'inappropriate_content';
    case IMPERSONATION = 'impersonation';
    case OTHER = 'other';
}

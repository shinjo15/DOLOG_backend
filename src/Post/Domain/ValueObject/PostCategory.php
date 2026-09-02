<?php

declare(strict_types=1);

namespace Src\Post\Domain\ValueObject;

enum PostCategory: string
{
    case ROUTINE = 'routine';
    case ACTION = 'action';
}

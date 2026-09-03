<?php

declare(strict_types=1);

namespace Src\Account\Domain\ValueObject;

enum SocialType: string
{
    case X = 'x';
    case INSTAGRAM = 'instagram';
    case TIKTOK = 'tiktok';
    case YOUTUBE = 'youtube';
    case THREADS = 'threads';
    case TWITCH = 'twitch';
    case DISCORD = 'discord';
    case BEREAL = 'bereal';
}

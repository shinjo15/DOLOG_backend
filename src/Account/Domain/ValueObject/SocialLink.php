<?php

declare(strict_types=1);

namespace Src\Account\Domain\ValueObject;

final readonly class SocialLink
{
    public function __construct(
        private SocialType $socialType,
        private SocialUrl $socialUrl,
    ) {}

    public function socialType(): SocialType
    {
        return $this->socialType;
    }

    public function socialUrl(): SocialUrl
    {
        return $this->socialUrl;
    }
}

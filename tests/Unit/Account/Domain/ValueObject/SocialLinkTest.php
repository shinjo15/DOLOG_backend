<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Src\Account\Domain\ValueObject\SocialLink;
use Src\Account\Domain\ValueObject\SocialType;
use Src\Account\Domain\ValueObject\SocialUrl;

final class SocialLinkTest extends TestCase
{
    public function test_retains_a_social_type_and_social_url(): void
    {
        $socialType = SocialType::X;
        $socialUrl = new SocialUrl('https://x.com/example');

        $socialLink = new SocialLink(
            socialType: $socialType,
            socialUrl: $socialUrl,
        );

        $this->assertSame($socialType, $socialLink->socialType());
        $this->assertSame($socialUrl, $socialLink->socialUrl());
    }
}

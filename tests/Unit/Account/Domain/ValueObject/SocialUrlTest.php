<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Src\Account\Domain\ValueObject\SocialUrl;
use Src\Shared\Domain\ValueObject\Base\StringValueObject;

final class SocialUrlTest extends TestCase
{
    public function test_retains_a_valid_social_url(): void
    {
        $socialUrl = new SocialUrl('https://example.com/profile');

        $this->assertSame('https://example.com/profile', $socialUrl->value());
    }

    public function test_rejects_an_invalid_social_url(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new SocialUrl('not-a-url');
    }

    public function test_uses_the_shared_string_value_object_base(): void
    {
        $this->assertInstanceOf(StringValueObject::class, new SocialUrl('https://example.com/profile'));
    }
}

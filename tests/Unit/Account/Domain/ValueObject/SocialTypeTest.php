<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Src\Account\Domain\ValueObject\SocialType;
use Src\Shared\Domain\ValueObject\Base\StringValueObject;

final class SocialTypeTest extends TestCase
{
    public function test_retains_an_extensible_social_type(): void
    {
        $socialType = new SocialType('new-social-network');

        $this->assertSame('new-social-network', $socialType->value());
    }

    public function test_rejects_a_blank_social_type(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new SocialType('   ');
    }

    public function test_uses_the_shared_string_value_object_base(): void
    {
        $this->assertInstanceOf(StringValueObject::class, new SocialType('x'));
    }
}

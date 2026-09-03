<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Src\Account\Domain\ValueObject\SocialNetworkType;
use Src\Shared\Domain\ValueObject\Base\StringValueObject;

final class SocialNetworkTypeTest extends TestCase
{
    public function test_accepts_a_social_network_type_as_an_extensible_string(): void
    {
        $socialNetworkType = new SocialNetworkType('new-social-network');

        $this->assertSame('new-social-network', $socialNetworkType->value());
    }

    public function test_rejects_a_blank_social_network_type(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new SocialNetworkType('   ');
    }

    public function test_uses_the_shared_string_value_object_base(): void
    {
        $this->assertInstanceOf(StringValueObject::class, new SocialNetworkType('x'));
    }
}

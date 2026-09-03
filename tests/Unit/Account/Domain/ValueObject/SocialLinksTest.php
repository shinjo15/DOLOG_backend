<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Src\Account\Domain\ValueObject\SocialLinks;
use Src\Account\Domain\ValueObject\SocialNetworkType;

final class SocialLinksTest extends TestCase
{
    public function test_retains_multiple_social_network_and_url_pairs(): void
    {
        $links = [
            [
                'socialNetworkType' => new SocialNetworkType('x'),
                'url' => 'https://x.com/example',
            ],
            [
                'socialNetworkType' => new SocialNetworkType('blog'),
                'url' => 'https://example.com/blog',
            ],
        ];

        $socialLinks = new SocialLinks($links);

        $this->assertSame($links, $socialLinks->values());
    }

    public function test_accepts_no_social_links(): void
    {
        $socialLinks = new SocialLinks([]);

        $this->assertSame([], $socialLinks->values());
    }

    public function test_rejects_a_social_link_with_an_invalid_url(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new SocialLinks([
            [
                'socialNetworkType' => new SocialNetworkType('x'),
                'url' => 'not-a-url',
            ],
        ]);
    }

    public function test_rejects_a_social_link_without_a_social_network_type(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new SocialLinks([
            [
                'socialNetworkType' => 'x',
                'url' => 'https://x.com/example',
            ],
        ]);
    }

    public function test_rejects_a_non_array_social_link(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('ソーシャルリンクの各要素は配列である必要があります。');

        new SocialLinks(['not-an-array']);
    }
}

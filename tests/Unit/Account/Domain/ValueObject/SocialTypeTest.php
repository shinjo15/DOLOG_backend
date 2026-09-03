<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Domain\ValueObject;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Src\Account\Domain\ValueObject\SocialType;

final class SocialTypeTest extends TestCase
{
    /**
     * @return array<string, array{SocialType, string}>
     */
    public static function socialTypes(): array
    {
        return [
            'X' => [SocialType::X, 'x'],
            'Instagram' => [SocialType::INSTAGRAM, 'instagram'],
            'TikTok' => [SocialType::TIKTOK, 'tiktok'],
            'YouTube' => [SocialType::YOUTUBE, 'youtube'],
            'Threads' => [SocialType::THREADS, 'threads'],
            'Twitch' => [SocialType::TWITCH, 'twitch'],
            'Discord' => [SocialType::DISCORD, 'discord'],
            'BeReal' => [SocialType::BEREAL, 'bereal'],
        ];
    }

    #[DataProvider('socialTypes')]
    public function test_has_the_expected_backing_value(SocialType $socialType, string $value): void
    {
        $this->assertSame($value, $socialType->value);
        $this->assertSame($socialType, SocialType::from($value));
    }

    public function test_rejects_an_unknown_social_type(): void
    {
        $this->expectException(\ValueError::class);

        SocialType::from('new-social-network');
    }
}

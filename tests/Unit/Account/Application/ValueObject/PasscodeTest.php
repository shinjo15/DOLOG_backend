<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Application\ValueObject;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Src\Account\Application\ValueObject\Passcode;

final class PasscodeTest extends TestCase
{
    public function test_retains_a_passcode_with_the_minimum_length(): void
    {
        $passcode = new Passcode('password');

        $this->assertSame('password', $passcode->value());
    }

    #[DataProvider('invalidPasscodes')]
    public function test_rejects_a_passcode_outside_the_allowed_length(string $value): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Passcode($value);
    }

    /** @return array<string, array{string}> */
    public static function invalidPasscodes(): array
    {
        return [
            'seven characters' => ['passwor'],
            'seventy-three characters' => [str_repeat('a', 73)],
        ];
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Src\Account\Domain\ValueObject\FavoriteTagIdentifiers;
use Src\Shared\Domain\ValueObject\Identifier\TagIdentifier;

final class FavoriteTagIdentifiersTest extends TestCase
{
    public function test_retains_favorite_tag_identifiers(): void
    {
        $identifiers = [
            new TagIdentifier('b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5'),
            new TagIdentifier('75017745-e475-4337-b0f3-3fc3d670e5c7'),
        ];

        $favoriteTagIdentifiers = new FavoriteTagIdentifiers($identifiers);

        $this->assertSame($identifiers, $favoriteTagIdentifiers->values());
    }

    public function test_accepts_an_empty_list(): void
    {
        $favoriteTagIdentifiers = new FavoriteTagIdentifiers([]);

        $this->assertSame([], $favoriteTagIdentifiers->values());
    }

    public function test_accepts_a_list_without_an_upper_bound(): void
    {
        $identifiers = array_map(
            static fn (int $index): TagIdentifier => new TagIdentifier(sprintf('%08d-1111-4111-8111-%012d', $index + 1, $index + 1)),
            range(0, 99),
        );

        $favoriteTagIdentifiers = new FavoriteTagIdentifiers($identifiers);

        $this->assertCount(100, $favoriteTagIdentifiers->values());
    }

    public function test_rejects_a_non_tag_identifier(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new FavoriteTagIdentifiers(['not-a-tag-identifier']);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\Tag\Infrastructure\Factory;

use PHPUnit\Framework\TestCase;
use Src\Shared\Application\Service\UuidServiceInterface;
use Src\Tag\Domain\ValueObject\TagName;
use Src\Tag\Infrastructure\Factory\TagFactory;

final class TagFactoryTest extends TestCase
{
    public function test_creates_a_tag_with_the_uuid_service_identifier(): void
    {
        $factory = new TagFactory(new FixedUuidService('b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5'));

        $tag = $factory->create(new TagName('朝活'));

        $this->assertSame('b0caa7f4-e1da-4f48-a8db-12fcf9bf47d5', $tag->tagIdentifier()->value());
        $this->assertSame('朝活', $tag->tagName()->value());
    }
}

final readonly class FixedUuidService implements UuidServiceInterface
{
    public function __construct(
        private string $uuid,
    ) {}

    public function generate(): string
    {
        return $this->uuid;
    }
}

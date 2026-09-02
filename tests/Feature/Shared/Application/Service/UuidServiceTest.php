<?php

declare(strict_types=1);

namespace Tests\Feature\Shared\Application\Service;

use App\Support\LaravelUuidServices;
use Src\Shared\Application\Service\UuidServiceInterface;
use Tests\TestCase;

final class UuidServiceTest extends TestCase
{
    public function test_resolves_the_laravel_uuid_service(): void
    {
        $uuidService = $this->app->make(UuidServiceInterface::class);

        $this->assertInstanceOf(LaravelUuidServices::class, $uuidService);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/',
            $uuidService->generate(),
        );
    }
}

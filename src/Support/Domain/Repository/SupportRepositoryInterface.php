<?php

declare(strict_types=1);

namespace Src\Support\Domain\Repository;

use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;
use Src\Support\Domain\Entity\Support;
use Src\Support\Domain\ValueObject\SupportedPostPage;

interface SupportRepositoryInterface
{
    public function exists(AccountIdentifier $accountIdentifier, PostIdentifier $postIdentifier): bool;

    public function paginateActionPostsByAccountIdentifier(AccountIdentifier $accountIdentifier, int $page, int $perPage): SupportedPostPage;

    public function save(Support $support): void;
}

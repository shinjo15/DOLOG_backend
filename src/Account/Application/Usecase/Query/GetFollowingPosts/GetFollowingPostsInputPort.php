<?php

declare(strict_types=1);

namespace Src\Account\Application\Usecase\Query\GetFollowingPosts;

interface GetFollowingPostsInputPort
{
    public function accountIdentifier(): string;

    public function page(): int;

    public function numberOfItemsPerPage(): int;
}

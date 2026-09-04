<?php

declare(strict_types=1);

namespace Src\Account\Application\Usecase\Query\GetFollowingPosts;

interface GetFollowingPostsInterface
{
    public function execute(GetFollowingPostsInputPort $input): GetFollowingPostsOutputPort;
}

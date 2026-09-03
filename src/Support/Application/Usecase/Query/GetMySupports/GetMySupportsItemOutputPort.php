<?php

declare(strict_types=1);

namespace Src\Support\Application\Usecase\Query\GetMySupports;

interface GetMySupportsItemOutputPort
{
    public function postIdentifier(): string;

    public function routineIdentifier(): string;

    public function postCategory(): string;

    public function postLikeCount(): int;

    public function postSupportCount(): int;

    public function supportedAt(): string;
}

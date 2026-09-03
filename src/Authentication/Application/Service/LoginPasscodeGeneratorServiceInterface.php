<?php

declare(strict_types=1);

namespace Src\Authentication\Application\Service;

interface LoginPasscodeGeneratorServiceInterface
{
    public function generate(): string;
}

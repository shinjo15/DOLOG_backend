<?php

declare(strict_types=1);

namespace Src\Routine\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\Identifier\ActionIdentifier;

final readonly class RoutineActionIdentifiers
{
    /**
     * @param  list<ActionIdentifier>  $values
     */
    public function __construct(
        private array $values,
    ) {
        if ($values === []) {
            throw new \InvalidArgumentException('ルーティンには少なくとも1つの行動が必要です。');
        }
    }

    /**
     * @return list<ActionIdentifier>
     */
    public function values(): array
    {
        return $this->values;
    }
}

<?php

declare(strict_types=1);

namespace Src\Routine\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\Identifier\TagIdentifier;

final readonly class RoutineTagIdentifiers
{
    /**
     * @param  list<TagIdentifier>  $values
     */
    public function __construct(
        private array $values,
    ) {}

    /**
     * @return list<TagIdentifier>
     */
    public function values(): array
    {
        return $this->values;
    }
}

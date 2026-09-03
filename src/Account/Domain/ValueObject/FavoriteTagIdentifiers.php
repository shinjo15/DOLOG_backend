<?php

declare(strict_types=1);

namespace Src\Account\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\Identifier\TagIdentifier;

final readonly class FavoriteTagIdentifiers
{
    /**
     * @param  list<TagIdentifier>  $values
     */
    public function __construct(
        private array $values,
    ) {
        if (! array_is_list($values)) {
            throw new \InvalidArgumentException('お気に入りタグ識別子は一覧で指定する必要があります。');
        }

        foreach ($values as $value) {
            if (! $value instanceof TagIdentifier) {
                throw new \InvalidArgumentException('お気に入りタグ識別子にはTagIdentifierのみ指定できます。');
            }
        }
    }

    /**
     * @return list<TagIdentifier>
     */
    public function values(): array
    {
        return $this->values;
    }
}

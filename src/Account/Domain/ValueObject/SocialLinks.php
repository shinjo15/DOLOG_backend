<?php

declare(strict_types=1);

namespace Src\Account\Domain\ValueObject;

final readonly class SocialLinks
{
    /**
     * @param  list<array{socialNetworkType: SocialNetworkType, url: string}>  $values
     */
    public function __construct(
        private array $values,
    ) {
        if (! array_is_list($values)) {
            throw new \InvalidArgumentException('ソーシャルリンクは一覧で指定する必要があります。');
        }

        foreach ($values as $value) {
            if (! is_array($value)) {
                throw new \InvalidArgumentException('ソーシャルリンクの各要素は配列である必要があります。');
            }

            if (! isset($value['socialNetworkType'], $value['url'])) {
                throw new \InvalidArgumentException('ソーシャルリンクは種別とURLの組である必要があります。');
            }

            if (! $value['socialNetworkType'] instanceof SocialNetworkType) {
                throw new \InvalidArgumentException('ソーシャルリンクの種別はSocialNetworkTypeである必要があります。');
            }

            if (! is_string($value['url']) || filter_var($value['url'], FILTER_VALIDATE_URL) === false) {
                throw new \InvalidArgumentException('ソーシャルリンクには有効なURLが必要です。');
            }
        }
    }

    /**
     * @return list<array{socialNetworkType: SocialNetworkType, url: string}>
     */
    public function values(): array
    {
        return $this->values;
    }
}

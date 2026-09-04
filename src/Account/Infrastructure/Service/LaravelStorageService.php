<?php

declare(strict_types=1);

namespace Src\Account\Infrastructure\Service;

use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Src\Account\Application\Service\AccountImage;
use Src\Account\Application\Service\StorageServiceInterface;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;

final class LaravelStorageService implements StorageServiceInterface
{
    public function uploadIcon(
        AccountIdentifier $accountIdentifier,
        AccountImage $image,
    ): void {
        $this->upload(
            $accountIdentifier,
            'icon/icon.webp',
            $image,
        );
    }

    public function uploadHeader(
        AccountIdentifier $accountIdentifier,
        AccountImage $image,
    ): void {
        $this->upload(
            $accountIdentifier,
            'header/header.webp',
            $image,
        );
    }

    private function upload(
        AccountIdentifier $accountIdentifier,
        string $filename,
        AccountImage $image,
    ): void {
        $resource = imagecreatefromstring($image->contents());

        if ($resource === false) {
            throw new RuntimeException('画像をWebPへ変換できません。');
        }

        ob_start();
        imagewebp($resource, null, 80);
        $webp = ob_get_clean();
        imagedestroy($resource);

        if ($webp === false) {
            throw new RuntimeException('画像をWebPへ変換できません。');
        }

        $written = Storage::disk('s3')->put(
            "accounts/{$accountIdentifier->value()}/{$filename}",
            $webp,
            ['visibility' => 'private'],
        );

        if (! $written) {
            throw new RuntimeException('画像をストレージへ保存できません。');
        }
    }
}

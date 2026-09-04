<?php

declare(strict_types=1);

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Src\Account\Application\UseCase\CreateAccount\AccountImageFile;
use Src\Account\Application\UseCase\CreateAccount\CreateAccountInput;
use Src\Account\Domain\ValueObject\AccountBio;
use Src\Account\Domain\ValueObject\AccountName;
use Src\Account\Domain\ValueObject\EmailAddress;
use Src\Account\Domain\ValueObject\FavoriteTagIdentifiers;
use Src\Account\Domain\ValueObject\SocialLink;
use Src\Account\Domain\ValueObject\SocialType;
use Src\Account\Domain\ValueObject\SocialUrl;
use Src\Shared\Domain\ValueObject\Identifier\TagIdentifier;

final class CreateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'account_name' => ['required', 'string', 'max:50'],
            'account_bio' => ['nullable', 'string', 'max:300'],
            'email_address' => ['required', 'email'],
            'social_links' => ['required', 'array'],
            'social_links.*.social_type' => ['required', Rule::enum(SocialType::class)],
            'social_links.*.social_url' => ['required', 'url'],
            'favorite_tag_identifiers' => ['required', 'array'],
            'favorite_tag_identifiers.*' => ['required', 'uuid'],
            'icon_image' => [
                'nullable',
                'file',
                'mimes:png,jpg,jpeg,webp',
                'max:5120',
                'dimensions:min_width=128,min_height=128,max_width=2048,max_height=2048,ratio=1/1',
            ],
            'header_image' => [
                'nullable',
                'file',
                'mimes:png,jpg,jpeg,webp',
                'max:10240',
                'dimensions:min_width=640,min_height=320,max_width=2560,max_height=1440',
            ],
        ];
    }

    public function toInput(): CreateAccountInput
    {
        $v = $this->validated();

        return new CreateAccountInput(
            new AccountName($v['account_name']),
            isset($v['account_bio']) ? new AccountBio($v['account_bio']) : null,
            new EmailAddress($v['email_address']),
            array_map(
                static fn (array $link): SocialLink => new SocialLink(
                    SocialType::from($link['social_type']),
                    new SocialUrl($link['social_url']),
                ),
                $v['social_links'],
            ),
            new FavoriteTagIdentifiers(
                array_map(
                    static fn (string $id): TagIdentifier => new TagIdentifier($id),
                    $v['favorite_tag_identifiers'],
                ),
            ),
            isset($v['icon_image'])
                ? new AccountImageFile($v['icon_image']->getContent())
                : null,
            isset($v['header_image'])
                ? new AccountImageFile($v['header_image']->getContent())
                : null,
        );
    }
}

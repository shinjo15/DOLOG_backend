<?php

declare(strict_types=1);

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;
use Src\Authentication\Application\UseCase\VerifyLoginPasscode\VerifyLoginPasscodeInput;
use Src\Authentication\Domain\ValueObject\LoginPasscode;
use Src\Authentication\Domain\ValueObject\LoginPasscodeChallengeIdentifier;

final class VerifyLoginPasscodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['passcode' => ['required', 'string', 'regex:/^\\d{6}$/D']];
    }

    public function messages(): array
    {
        return [
            'passcode.required' => 'ログインパスコードを入力してください。',
            'passcode.regex' => 'ログインパスコードは6桁の数字で入力してください。',
        ];
    }

    public function toInput(string $challengeIdentifier): VerifyLoginPasscodeInput
    {
        return new VerifyLoginPasscodeInput(
            new LoginPasscodeChallengeIdentifier($challengeIdentifier),
            new LoginPasscode($this->validated('passcode')),
        );
    }
}

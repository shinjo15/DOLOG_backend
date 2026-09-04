<?php

declare(strict_types=1);

namespace Src\Account\Infrastructure\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class AccountRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly string $accountName) {}

    public function build(): self
    {
        return $this->subject('HIBILIO アカウント登録完了')->text('mail.account-registration-completed-text');
    }
}

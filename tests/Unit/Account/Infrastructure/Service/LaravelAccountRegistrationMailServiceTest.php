<?php

declare(strict_types=1);

namespace Tests\Unit\Account\Infrastructure\Service;

use Illuminate\Support\Facades\Mail;
use Src\Account\Domain\ValueObject\AccountName;
use Src\Account\Domain\ValueObject\EmailAddress;
use Src\Account\Infrastructure\Mail\AccountRegistrationMail;
use Src\Account\Infrastructure\Service\LaravelAccountRegistrationMailService;
use Tests\TestCase;

final class LaravelAccountRegistrationMailServiceTest extends TestCase
{
    public function test_sends_a_plaintext_registration_completion_email_without_a_passcode(): void
    {
        Mail::fake();

        (new LaravelAccountRegistrationMailService)->send(new EmailAddress('user@example.com'), new AccountName('朝活ユーザー'));

        Mail::assertSent(AccountRegistrationMail::class, function (AccountRegistrationMail $mail): bool {
            self::assertSame('user@example.com', $mail->hasTo('user@example.com') ? 'user@example.com' : null);
            self::assertStringContainsString('朝活ユーザー', $mail->render());
            self::assertStringNotContainsString('password', $mail->render());

            return true;
        });
    }
}

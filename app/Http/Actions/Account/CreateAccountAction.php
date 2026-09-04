<?php

declare(strict_types=1);

namespace App\Http\Actions\Account;

use App\Http\Requests\Account\CreateAccountRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Src\Account\Application\Service\AccountImageConverterServiceInterface;
use Src\Account\Application\UseCase\CreateAccount\CreateAccountInterface;
use Src\Account\Domain\Exception\DuplicateEmailAddressException;

final readonly class CreateAccountAction
{
    public function __construct(
        private CreateAccountInterface $createAccount,
        private AccountImageConverterServiceInterface $accountImageConverter,
    ) {}

    public function __invoke(CreateAccountRequest $request): Response|JsonResponse
    {
        try {
            $icon = $request->iconImageContents();
            $header = $request->headerImageContents();

            $this->createAccount->execute($request->toInput(
                $icon === null ? null : $this->accountImageConverter->convertToIcon($icon),
                $header === null ? null : $this->accountImageConverter->convertToHeader($header),
            ));

            return new Response('', 201);
        } catch (DuplicateEmailAddressException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], 422);
        }
    }
}

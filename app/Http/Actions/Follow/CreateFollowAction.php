<?php

declare(strict_types=1);

namespace App\Http\Actions\Follow;

use App\Http\Requests\Follow\CreateFollowRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use RuntimeException;
use Src\Account\Follow\Application\UseCase\CreateFollow\CreateFollowInterface;
use Src\Account\Follow\Domain\Exception\DuplicateFollowException;
use Src\Account\Follow\Domain\Exception\FollowedAccountNotFoundException;
use Src\Account\Follow\Domain\Exception\SelfFollowException;
use Src\Shared\Application\Service\AuthServiceInterface;

final readonly class CreateFollowAction
{
    public function __construct(
        private CreateFollowInterface $createFollow,
        private AuthServiceInterface $authService,
    ) {}

    public function __invoke(CreateFollowRequest $request): Response|JsonResponse
    {
        try {
            $this->createFollow->execute($request->toInput($this->authService->accountIdentifier()));

            return new Response('', 204);
        } catch (RuntimeException) {
            return new Response('', 401);
        } catch (FollowedAccountNotFoundException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], 404);
        } catch (SelfFollowException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], 422);
        } catch (DuplicateFollowException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], 409);
        }
    }
}

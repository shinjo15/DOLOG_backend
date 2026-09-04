<?php

declare(strict_types=1);

namespace App\Http\Actions\RoutineExecution;

use App\Http\Requests\RoutineExecution\CreateRoutineExecutionRequest;
use Illuminate\Http\Response;
use RuntimeException;
use Src\RoutineExecution\Application\UseCase\CreateRoutineExecution\CreateRoutineExecutionInterface;
use Src\Shared\Application\Service\AuthServiceInterface;
use Throwable;

use function report;

final readonly class CreateRoutineExecutionAction
{
    public function __construct(
        private CreateRoutineExecutionInterface $createRoutineExecution,
        private AuthServiceInterface $authService,
    ) {}

    public function __invoke(CreateRoutineExecutionRequest $request): Response
    {
        try {
            $this->createRoutineExecution->execute(
                $request->toInput($this->authService->accountIdentifier()),
            );

            return new Response('', 201);
        } catch (Throwable $exception) {
            if (! $exception instanceof RuntimeException) {
                report($exception);
            }

            return new Response('', $exception instanceof RuntimeException ? 401 : 500);
        }
    }
}

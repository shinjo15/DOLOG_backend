<?php

declare(strict_types=1);

namespace App\Http\Requests\RoutineExecution;

use Illuminate\Foundation\Http\FormRequest;
use Src\RoutineExecution\Application\UseCase\CreateRoutineExecution\CreateRoutineExecutionInput;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\RoutineIdentifier;

final class CreateRoutineExecutionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'routine_identifier' => ['required', 'uuid'],
        ];
    }

    public function toInput(string $accountIdentifier): CreateRoutineExecutionInput
    {
        /** @var array{routine_identifier: string} $validated */
        $validated = $this->validated();

        return new CreateRoutineExecutionInput(
            new AccountIdentifier($accountIdentifier),
            new RoutineIdentifier($validated['routine_identifier']),
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Src\Report\Application\UseCase\CreateReport\CreateReportInput;
use Src\Report\Domain\ValueObject\ReportCategory;
use Src\Report\Domain\ValueObject\ReportText;
use Src\Shared\Domain\ValueObject\Identifier\AccountIdentifier;
use Src\Shared\Domain\ValueObject\Identifier\PostIdentifier;

final class CreateReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'target_account_identifier' => ['required', 'uuid'],
            'target_post_identifier' => ['nullable', 'uuid'],
            'category' => ['required', Rule::enum(ReportCategory::class)],
            'text' => ['present', 'nullable', 'string', 'max:500'],
        ];
    }

    public function toInput(string $reporterAccountIdentifier): CreateReportInput
    {
        $validated = $this->validated();

        return new CreateReportInput(
            new AccountIdentifier($reporterAccountIdentifier),
            new AccountIdentifier($validated['target_account_identifier']),
            isset($validated['target_post_identifier']) ? new PostIdentifier($validated['target_post_identifier']) : null,
            ReportCategory::from($validated['category']),
            new ReportText($validated['text'] ?? ''),
        );
    }
}

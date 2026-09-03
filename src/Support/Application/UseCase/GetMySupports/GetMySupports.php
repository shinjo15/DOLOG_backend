<?php

declare(strict_types=1);

namespace Src\Support\Application\UseCase\GetMySupports;

use Src\Support\Domain\Repository\SupportRepositoryInterface;

final readonly class GetMySupports implements GetMySupportsInterface
{
    public function __construct(private SupportRepositoryInterface $supportRepository) {}

    public function execute(GetMySupportsInputPort $input): GetMySupportsOutputPort
    {
        $page = $this->supportRepository->paginateActionPostsByAccountIdentifier($input->accountIdentifier(), $input->page(), $input->perPage());
        $items = array_map(static fn ($supportedPost): GetMySupportsItemOutputPort => new GetMySupportsItemOutput(
            $supportedPost->post()->postIdentifier(),
            $supportedPost->post()->routineIdentifier(),
            $supportedPost->post()->postCategory(),
            $supportedPost->post()->postLikeCount(),
            $supportedPost->post()->postSupportCount(),
            $supportedPost->supportedAt(),
        ), $page->items());

        return new GetMySupportsOutput($items, $page->currentPage(), $page->lastPage(), $page->perPage(), $page->total());
    }
}

<?php

declare(strict_types=1);

namespace Src\Like\Application\UseCase\CreateLike;

use Src\Like\Domain\Exception\AlreadyLikedException;
use Src\Like\Domain\Exception\PostNotFoundForLikeException;
use Src\Like\Domain\Factory\LikeFactoryInterface;
use Src\Like\Domain\Repository\LikeRepositoryInterface;
use Src\Post\Domain\Repository\PostRepositoryInterface;
use Src\Shared\Application\Transaction\TransactionManagerInterface;

final readonly class CreateLike implements CreateLikeInterface
{
    public function __construct(private TransactionManagerInterface $transactionManager, private PostRepositoryInterface $postRepository, private LikeRepositoryInterface $likeRepository, private LikeFactoryInterface $likeFactory) {}

    public function execute(CreateLikeInput $input): void
    {
        $this->transactionManager->transaction(function () use ($input): void {
            $post = $this->postRepository->find($input->postIdentifier);
            if ($post === null) {
                throw new PostNotFoundForLikeException;
            }
            if ($this->likeRepository->exists($input->accountIdentifier, $input->postIdentifier)) {
                throw new AlreadyLikedException;
            }
            $this->likeRepository->save($this->likeFactory->create($input->accountIdentifier, $input->postIdentifier));
            $this->postRepository->save($post->incrementLikeCount());
        });
    }
}

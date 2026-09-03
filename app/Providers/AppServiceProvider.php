<?php

namespace App\Providers;

use App\Support\LaravelUuidServices;
use Illuminate\Support\ServiceProvider;
use Src\Account\Application\Service\AccountRegistrationMailServiceInterface;
use Src\Account\Application\Service\PasscodeHashingServiceInterface;
use Src\Account\Application\UseCase\CreateAccount\CreateAccount;
use Src\Account\Application\UseCase\CreateAccount\CreateAccountInterface;
use Src\Account\Domain\Factory\AccountFactoryInterface;
use Src\Account\Domain\Repository\AccountCredentialRepositoryInterface;
use Src\Account\Domain\Repository\AccountRepositoryInterface;
use Src\Account\Infrastructure\Factory\AccountFactory;
use Src\Account\Infrastructure\Repository\AccountCredentialRepository;
use Src\Account\Infrastructure\Repository\AccountRepository;
use Src\Account\Infrastructure\Service\LaravelAccountRegistrationMailService;
use Src\Account\Infrastructure\Service\LaravelPasscodeHashingService;
use Src\Like\Application\UseCase\CreateLike\CreateLike;
use Src\Like\Application\UseCase\CreateLike\CreateLikeInterface;
use Src\Like\Application\Usecase\Query\GetMyLikes\GetMyLikesInterface;
use Src\Like\Domain\Factory\LikeFactoryInterface;
use Src\Like\Domain\Repository\LikeRepositoryInterface;
use Src\Like\Infrastructure\Factory\LikeFactory;
use Src\Like\Infrastructure\Query\GetMyLikes\GetMyLikes;
use Src\Like\Infrastructure\Repository\LikeRepository;
use Src\Post\Domain\Factory\PostFactoryInterface;
use Src\Post\Domain\Repository\PostRepositoryInterface;
use Src\Post\Infrastructure\Factory\PostFactory;
use Src\Post\Infrastructure\Repository\PostRepository;
use Src\Routine\Application\UseCase\CreateRoutine\CreateRoutine;
use Src\Routine\Application\UseCase\CreateRoutine\CreateRoutineInterface;
use Src\Routine\Domain\Factory\RoutineActionFactoryInterface;
use Src\Routine\Domain\Factory\RoutineFactoryInterface;
use Src\Routine\Domain\Repository\RoutineActionRepositoryInterface;
use Src\Routine\Domain\Repository\RoutineRepositoryInterface;
use Src\Routine\Infrastructure\Factory\RoutineActionFactory;
use Src\Routine\Infrastructure\Factory\RoutineFactory;
use Src\Routine\Infrastructure\Repository\RoutineActionRepository;
use Src\Routine\Infrastructure\Repository\RoutineRepository;
use Src\Shared\Application\Service\AuthServiceInterface;
use Src\Shared\Application\Service\UuidServiceInterface;
use Src\Shared\Application\Transaction\TransactionManagerInterface;
use Src\Shared\Infrastructure\Service\LaravelAuthService;
use Src\Shared\Infrastructure\Transaction\LaravelTransactionManager;
use Src\Support\Application\UseCase\CreateSupport\CreateSupport;
use Src\Support\Application\UseCase\CreateSupport\CreateSupportInterface;
use Src\Support\Application\Usecase\Query\GetMySupports\GetMySupportsInterface;
use Src\Support\Domain\Factory\SupportFactoryInterface;
use Src\Support\Domain\Repository\SupportRepositoryInterface;
use Src\Support\Infrastructure\Factory\SupportFactory;
use Src\Support\Infrastructure\Query\GetMySupports\GetMySupports;
use Src\Support\Infrastructure\Repository\SupportRepository;
use Src\Tag\Application\UseCase\CreateTag\CreateTag;
use Src\Tag\Application\UseCase\CreateTag\CreateTagInterface;
use Src\Tag\Domain\Factory\TagFactoryInterface;
use Src\Tag\Domain\Repository\TagRepositoryInterface;
use Src\Tag\Infrastructure\Factory\TagFactory;
use Src\Tag\Infrastructure\Repository\TagRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, LaravelAuthService::class);
        $this->app->bind(UuidServiceInterface::class, LaravelUuidServices::class);
        $this->app->bind(AccountFactoryInterface::class, AccountFactory::class);
        $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);
        $this->app->bind(AccountCredentialRepositoryInterface::class, AccountCredentialRepository::class);
        $this->app->bind(PasscodeHashingServiceInterface::class, LaravelPasscodeHashingService::class);
        $this->app->bind(AccountRegistrationMailServiceInterface::class, LaravelAccountRegistrationMailService::class);
        $this->app->bind(CreateAccountInterface::class, CreateAccount::class);
        $this->app->bind(TagFactoryInterface::class, TagFactory::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(CreateTagInterface::class, CreateTag::class);
        $this->app->bind(TransactionManagerInterface::class, LaravelTransactionManager::class);
        $this->app->bind(LikeFactoryInterface::class, LikeFactory::class);
        $this->app->bind(LikeRepositoryInterface::class, LikeRepository::class);
        $this->app->bind(CreateLikeInterface::class, CreateLike::class);
        $this->app->bind(GetMyLikesInterface::class, GetMyLikes::class);
        $this->app->bind(SupportFactoryInterface::class, SupportFactory::class);
        $this->app->bind(SupportRepositoryInterface::class, SupportRepository::class);
        $this->app->bind(CreateSupportInterface::class, CreateSupport::class);
        $this->app->bind(GetMySupportsInterface::class, GetMySupports::class);
        $this->app->bind(RoutineFactoryInterface::class, RoutineFactory::class);
        $this->app->bind(RoutineRepositoryInterface::class, RoutineRepository::class);
        $this->app->bind(RoutineActionFactoryInterface::class, RoutineActionFactory::class);
        $this->app->bind(RoutineActionRepositoryInterface::class, RoutineActionRepository::class);
        $this->app->bind(PostFactoryInterface::class, PostFactory::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CreateRoutineInterface::class, CreateRoutine::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Core\Annex\AnnexRepository;
use App\core\Annex\AnnexRepositoryInterface;
use App\Core\Comment\CommentRepository;
use App\Core\Comment\CommentRepositoryInterface;
use App\Core\CommentResponse\CommentResponseRepository;
use App\Core\CommentResponse\CommentResponseRepositoryInterface;
use App\Core\CustomColumn\CustomColumnRepository;
use App\Core\CustomColumn\CustomColumnRepositoryInterface;
use App\Core\CustomColumnsValue\CustomColumnsValueRepository;
use App\Core\CustomColumnsValue\CustomColumnsValueRepositoryInterface;
use App\Core\Department\DepartmentRepository;
use App\Core\Department\DepartmentRepositoryInterface;
use App\Core\Follower\FollowerRepository;
use App\Core\Follower\FollowerRepositoryInterface;
use App\Core\Position\PositionRepository;
use App\Core\Position\PositionRepositoryInterface;
use App\Core\Sprint\SprintRepository;
use App\Core\Sprint\SprintRepositoryInterface;
use App\Core\Task\TaskRepository;
use App\Core\Task\TaskRepositoryInterface;
use App\Core\TaskActivity\TaskActivityRepository;
use App\Core\TaskActivity\TaskActivityRepositoryInterface;
use App\Core\TaskExecutionStatus\TaskExecutionStatusRepositoryInterface;
use App\Core\TaskExecutionStatus\TaskExecutionStatusRepository;
use App\Core\TaskRoadMap\TaskRoadMapRepository;
use App\Core\TaskRoadMap\TaskRoadMapRepositoryInterface;
use App\Core\User\UserRepository;
use App\Core\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(AnnexRepositoryInterface::class, AnnexRepository::class);
        $this->app->bind(FollowerRepositoryInterface::class, FollowerRepository::class);
        $this->app->bind(TaskRoadMapRepositoryInterface::class, TaskRoadMapRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(CommentResponseRepositoryInterface::class, CommentResponseRepository::class);
        $this->app->bind(CustomColumnRepositoryInterface::class, CustomColumnRepository::class);
        $this->app->bind(CustomColumnsValueRepositoryInterface::class, CustomColumnsValueRepository::class);
        $this->app->bind(TaskActivityRepositoryInterface::class, TaskActivityRepository::class);
        $this->app->bind(TaskExecutionStatusRepositoryInterface::class, TaskExecutionStatusRepository::class);
        $this->app->bind(SprintRepositoryInterface::class, SprintRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

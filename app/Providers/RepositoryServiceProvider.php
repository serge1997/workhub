<?php

namespace App\Providers;

use App\Core\Department\DepartmentRepository;
use App\Core\Department\DepartmentRepositoryInterface;
use App\Core\Position\PositionRepository;
use App\Core\Position\PositionRepositoryInterface;
use App\Core\Task\TaskRepository;
use App\Core\Task\TaskRepositoryInterface;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

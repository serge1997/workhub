<?php

namespace App\Observers;

use App\Models\TaskRoadMap;
use App\Core\TaskActivity\TaskActivityRepositoryInterface;

class TaskRoadMapObserver
{

    public function __construct(
        public TaskActivityRepositoryInterface $taskActivityRepositoryInterface
    )
    {}
    /**
     * Handle the TaskRoadMap "created" event.
     */
    public function created(TaskRoadMap $taskRoadMap): void
    {
        $this->taskActivityRepositoryInterface->create(
            description: 'Road map',
            author_id: $taskRoadMap->user_id,
            task_id: $taskRoadMap->task_id,
            content: "adicionou uma guia"
        );
    }

    /**
     * Handle the TaskRoadMap "updated" event.
     */
    public function updated(TaskRoadMap $taskRoadMap): void
    {
        //
    }

    /**
     * Handle the TaskRoadMap "deleted" event.
     */
    public function deleted(TaskRoadMap $taskRoadMap): void
    {
        $this->taskActivityRepositoryInterface->create(
            description: 'Road map',
            author_id: $taskRoadMap->user_id,
            task_id: $taskRoadMap->task_id,
            content: "deletou uma guia"
        );
    }

    /**
     * Handle the TaskRoadMap "restored" event.
     */
    public function restored(TaskRoadMap $taskRoadMap): void
    {
        //
    }

    /**
     * Handle the TaskRoadMap "force deleted" event.
     */
    public function forceDeleted(TaskRoadMap $taskRoadMap): void
    {
        //
    }
}

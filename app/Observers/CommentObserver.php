<?php

namespace App\Observers;

use App\Core\TaskActivity\TaskActivityRepositoryInterface;
use App\Models\Comment;
use App\Models\TaskActivity;

class CommentObserver
{

    public function __construct(
        public TaskActivityRepositoryInterface $taskActivityRepositoryInterface
    )
    {}
    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        $this->taskActivityRepositoryInterface->create(
            description: 'comment',
            author_id: $comment->user_id,
            task_id: $comment->task_id,
            content: "adicionou um commentario"
        );
    }

    /**
     * Handle the Comment "updated" event.
     */
    public function updated(Comment $comment): void
    {
        $this->taskActivityRepositoryInterface->create(
            description: 'comment',
            author_id: $comment->user_id,
            task_id: $comment->task_id,
            content: "Atualizou um commentario"
        );
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        $this->taskActivityRepositoryInterface->create(
            description: 'comment',
            author_id: $comment->user_id,
            task_id: $comment->task_id,
            content: "apagou um commentario"
        );
    }

    /**
     * Handle the Comment "restored" event.
     */
    public function restored(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     */
    public function forceDeleted(Comment $comment): void
    {
        //
    }
}

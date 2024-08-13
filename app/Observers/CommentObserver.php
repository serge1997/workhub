<?php

namespace App\Observers;

use App\Core\TaskActivity\TaskActivityRepositoryInterface;
use App\Http\Resources\TaskActivityResource;
use App\Models\Comment;
use App\Models\TaskActivity;
use App\Services\Servers\WsServer;

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
       $ws = new WsServer("ws://localhost:8155/teste");
       $activity = $this->taskActivityRepositoryInterface->create(
            description: 'comment',
            author_id: $comment->user_id,
            task_id: $comment->task_id,
            content: "adicionou um commentario"
        );
        $ws->notify(new TaskActivityResource($activity));
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

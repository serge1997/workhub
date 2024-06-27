<?php
namespace App\Core\Comment;

use App\Core\Comment\Actions\CreateCommentAction;
use App\Core\Comment\Actions\DeleteCommentAction;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Core\Comment\Actions\FindCommentAction;

class CommentRepository implements CommentRepositoryInterface
{
    public function create($request)
    {
        CreateCommentAction::run($request);
        return $this->listAllByTask($request);
    }

    public function listAllByTask($request)
    {
        return CommentResource::collection(
            Comment::query()
                ->where('task_id', $request->task_id)
                    ->orderBy('created_at', 'asc')
                        ->get()
        );
    }

    public function find($request)
    {
        return new CommentResource(FindCommentAction::run($request));
    }

    public function update($request)
    {

    }
    public function softDelete($request)
    {
        (new DeleteCommentAction(FindCommentAction::run($request)))
            ->soft();
    }

    public function delete($request)
    {

    }
}

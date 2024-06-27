<?php
namespace App\Core\Comment;

use App\Core\Comment\Actions\CreateCommentAction;
use App\Http\Resources\CommentResource;
use App\Models\Comment;

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
                    ->get()
        );
    }

    public function update($request)
    {

    }
    public function delete($request)
    {

    }
}

<?php
namespace App\Core\Comment;

use App\Core\Comment\Actions\CreateCommentAction;
use App\Core\Comment\Actions\DeleteCommentAction;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Core\Comment\Actions\FindCommentAction;
use App\Core\Comment\Actions\UpdateCommentContentAction;
use Illuminate\Support\Facades\Gate;

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
                ->where([['task_id', $request->task_id], ['deleted_at', null]])
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
        (new UpdateCommentContentAction(FindCommentAction::run($request), $request))
            ->run();
    }
    public function softDelete($request)
    {
        $comment = FindCommentAction::run($request);
        Gate::authorize("delete", $comment);
        (new DeleteCommentAction($comment))
            ->soft();
    }

    public function delete($request)
    {

    }

    public function listAllSoftDeleted($request)
    {
        return CommentResource::collection(
            Comment::query()
                ->where([['deleted_at', '<>', null], ['user_id', $request->user()->id]])
                    ->get()
        );
    }
}

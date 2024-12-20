<?php
namespace App\Core\Comment;

use App\Core\Comment\Actions\CreateCommentAction;
use App\Core\Comment\Actions\DeleteCommentAction;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Core\Comment\Actions\FindCommentAction;
use App\Core\Comment\Actions\UpdateCommentContentAction;
use App\Core\Comment\Actions\RefreshCommentSoftDeleteAction;
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
                    ->orderBy('id', 'desc')
                        ->get()
        );
    }

    public function find($request)
    {
        return new CommentResource(FindCommentAction::run($request));
    }

    public function update($request)
    {
        (new UpdateCommentContentAction(FindCommentAction::run($request), $request))->run();
    }
    public function softDelete($request)
    {
        $comment = FindCommentAction::run($request);
        Gate::authorize("delete", $comment);
        (new DeleteCommentAction($comment))->soft();
    }

    public function delete($request)
    {

    }

    public function listAllCommentTrash($request)
    {
        return CommentResource::collection(
            Comment::query()
                ->withoutGlobalScopes()
                    ->deleted()
                        ->commentOf($request->user()->id)
                            ->get()
        );
    }

    public function refreshSodftDelete($request)
    {
        (new RefreshCommentSoftDeleteAction(
            FindCommentAction::run($request))
        )->handle();
    }
}

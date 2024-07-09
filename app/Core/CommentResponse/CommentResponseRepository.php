<?php
namespace App\Core\CommentResponse;

use App\Core\Comment\CommentRepositoryInterface;
use App\Core\CommentResponse\Actions\CreateCommentResponse;
use App\Core\CommentResponse\Actions\FindCommentResponseAction;
use App\Core\CommentResponse\Actions\listByCommentAction;
use App\Core\CommentResponse\Actions\UpdateCommentResponseAction;
use App\Core\Task\Actions\FindTaskAction;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentResponseResource;
use App\Models\Task;

class CommentResponseRepository implements CommentResponseRepositoryInterface
{
    public function __construct(
        public CommentRepositoryInterface $commentRepositoryInterface
    ){}
    public function create($request)
    {
        CreateCommentResponse::run($request);
        return $this->commentRepositoryInterface
            ->listAllByTask($request);
    }

    public function find($request)
    {
        return new CommentResponseResource(
            FindCommentResponseAction::get($request)
        );
    }

    public function update($request)
    {
        (new UpdateCommentResponseAction(FindCommentResponseAction::get($request), $request))->run();
        return $this->commentRepositoryInterface
            ->listAllByTask($request);
    }

    public function delete($request)
    {

    }

    public function listByComment($request)
    {
        return CommentResponseResource::collection(
            (new listByCommentAction($request))->get()
        );
    }
}

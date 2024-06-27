<?php
namespace App\Core\CommentResponse;

use App\Core\Comment\CommentRepositoryInterface;
use App\Core\CommentResponse\Actions\CreateCommentResponse;
use App\Core\Task\Actions\FindTaskAction;
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
    public function update($request)
    {

    }
    public function delete($request)
    {

    }
}

<?php
namespace App\Core\Comment;

use App\Core\Comment\Actions\CreateAction;
class CommentRepository implements CommentRepositoryInterface
{
    public function create($request)
    {
        CreateAction::run($request);
    }
    public function update($request)
    {

    }
    public function delete($request)
    {

    }
}

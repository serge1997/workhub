<?php
namespace App\Core\CommentResponse;

use App\Core\CommentResponse\Actions\CreateAction;
class CommentResponseRepository implements CommentResponseRepositoryInterface
{
    public function create($request)
    {
        CreateACtion::run($request);
    }
    public function update($request)
    {

    }
    public function delete($request)
    {

    }
}

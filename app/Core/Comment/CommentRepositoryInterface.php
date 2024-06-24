<?php
namespace App\Core\Comment;

interface CommentRepositoryInterface
{
    public function create($request);
    public function update($request);
    public function delete($request);
}

<?php
namespace App\Core\CommentResponse;

interface CommentResponseRepositoryInterface
{
    public function create($request);
    public function update($request);
    public function delete($request);
}

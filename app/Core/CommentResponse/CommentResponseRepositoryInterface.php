<?php
namespace App\Core\CommentResponse;

use App\Models\CommentResponse;

interface CommentResponseRepositoryInterface
{
    public function create($request);
    public function find($request);
    public function update($request);
    public function delete($request);
    public function listByComment($request);
}

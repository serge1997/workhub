<?php
namespace App\Core\Comment;

use App\Models\Comment;

interface CommentRepositoryInterface
{
    public function create($request);
    public function listAllByTask($request);
    public function find($request);
    public function update($request);
    public function softDelete($request);
    public function delete($request);
    public function listAllSoftDeleted($request);
}

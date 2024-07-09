<?php
namespace App\Core\CommentResponse\Actions;

use App\Models\CommentResponse;

final class listByCommentAction
{
    public function __construct(
        private mixed $request
    )
    { }

    public function get()
    {
        return CommentResponse::where('comment_id', $this->request->comment_id)
            ->get();
    }
}

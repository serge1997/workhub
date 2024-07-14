<?php
namespace App\Core\Comment\Actions;

use App\Models\Comment;

final class UpdateCommentContentAction
{
    public function __construct(
        private Comment $comment,
        private mixed $request
    ){}

    public function run()
    {
        $this->comment->update([
            'comment' => $this->request->comment
        ]);
    }
}

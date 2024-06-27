<?php
namespace App\Core\Comment\Actions;

use App\Models\Comment;

final class CommentHasResponse
{
    public function __construct(
        private Comment $comment
    )
    {}

    public function handle() : Comment
    {
        $this->comment->update([
            'has_response' => true
        ]);

        return $this->comment;
    }
}

<?php
namespace App\Core\Comment\Actions;

use App\Models\Comment;

final class RefreshCommentSoftDeleteAction
{
    public function __construct(
        private Comment $comment,
    )
    {}

    public function handle()
    {
        $this->comment->query()->update([
            'deleted_at' => null
        ]);
    }
}

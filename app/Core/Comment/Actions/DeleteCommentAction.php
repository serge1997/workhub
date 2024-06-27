<?php
namespace App\Core\Comment\Actions;

use App\Models\Comment;
use Carbon\Carbon;

final class DeleteCommentAction
{
    public function __construct(
        private Comment $comment
    )
    {

    }

    public function soft()
    {
        $this->comment->update([
            'deleted_at' => Carbon::now()->isoFormat("Y-MM-DD H:mm:s")
        ]);
    }

    public function delete()
    {
        $this->comment->delete();
    }
}

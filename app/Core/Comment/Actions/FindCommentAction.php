<?php
namespace App\Core\Comment\Actions;

use App\Models\Comment;

final class FindCommentAction
{
    public static function run($request) : Comment
    {
        return Comment::findOrFail($request->comment_id);
    }
}

<?php
namespace App\Core\Comment\Actions;

use App\Models\Comment;

final class FindCommentAction
{
    public static function run($request) : Comment
    {
        return Comment::withoutGlobalScopes()->findOrFail($request->comment_id);
    }
}

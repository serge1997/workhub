<?php
namespace App\Core\CommentResponse\Actions;

use App\Models\CommentResponse;

final class FindCommentResponseAction
{

    public static function get($request) : CommentResponse
    {
        return CommentResponse::find($request->response_id);
    }
}

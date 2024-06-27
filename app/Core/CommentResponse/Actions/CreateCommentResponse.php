<?php
namespace App\Core\CommentResponse\Actions;

use App\Models\CommentResponse;
use App\Core\Task\Actions\FindTaskAction;
use App\Core\Comment\Actions\FindCommentAction;
use App\Core\Comment\Actions\CommentHasResponse;
use App\Models\Comment;

final class CreateCommentResponse
{

    private function handle($request) : CommentResponse
    {
        return CommentResponse::query()->create([
            "response" => $request->response(),
            "comment_id" =>  (new CommentHasResponse(FindCommentAction::run($request)))->handle()->id,
            "user_id" => $request->user()->id
        ]);
    }

    public static function run($request) : CommentResponse
    {
        return (new self())->handle($request);
    }
}

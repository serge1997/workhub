<?php
namespace App\Core\CommentResponse\Actions;

use App\Core\Comment\Actions\FindACommentAction;
use App\Models\CommentResponse;
use App\Core\Task\Actions\FindTaskAction;
use App\Core\Comment\Actions\FindCommentAction;
final class CreateAction
{

    private function handle($request) : CommentResponse
    {
        dd(FindTaskAction::run($request->task()));
        return CommentResponse::query()->create([
            "response" => $request->response(),
            "task_id"  => FindTaskAction::run($request->task())->id,
            "comment_id" => FindACommentAction::run($request->comment())->id,
            "user_id" => $request->user()->id
        ]);
    }

    public static function run($request) : CommentResponse
    {
        return (new self())->handle($request);
    }
}

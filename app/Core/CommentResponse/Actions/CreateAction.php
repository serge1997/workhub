<?php
namespace App\Core\CommentResponse\Actions;

use App\Models\CommentResponse;

final class CreateAction
{

    private function handle($request) : CommentResponse
    {
        return CommentResponse::query()->create([
            "response" => $request->response(),
            "task_id"  => $request->task()
        ]);
    }

    public static function run($request) : CommentResponse
    {
        return (new self())->handle($request);
    }
}

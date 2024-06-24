<?php
namespace App\Core\Comment\Actions;

use App\Models\Comment;

final class CreateAction
{

    public function handle($request) : Comment
    {
        return Comment::query()->create([
            "comment" => $request->comment(),
            "task_id" => $request->task(),
            "user_id" => $request->user()->id
        ]);
    }

    public static function run($request) : Comment
    {
        return (new self())->handle($request);
    }
}

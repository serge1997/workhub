<?php
namespace App\Core\Task\Actions;

use App\Models\Task;

final class ListTaskByFilteredUserAction
{

    public static function list($request)
    {
        return Task::where('user_id', $request->user_id)
            ->orderBy('created_at', 'desc')
                ->get();
    }
}

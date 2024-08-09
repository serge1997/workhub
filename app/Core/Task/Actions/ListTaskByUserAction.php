<?php
namespace App\Core\Task\Actions;

use App\Models\Task;

final class ListTaskByUserAction
{

    public static function list($request)
    {
        return Task::query()
            ->where('user_id', $request->user()->id)
                ->limit(10)
                    ->orderBy('created_at')
                        ->get();
    }
}

<?php
namespace App\Core\Follower\Actions;

use App\Models\Follower;

final class ListaByTaskAction
{

    public function run($request)
    {
        return Follower::where('task_id', $request->id)->get();
    }
}

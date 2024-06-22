<?php
namespace App\Core\Follower;

use App\Models\Follower;
use App\Models\Task;
use Exception;
use App\Core\Follower\Actions\ListaByTaskAction;
use App\Http\Resources\FollowerResource;

class FollowerRepository implements FollowerRepositoryInterface
{
    public function create($request, Task $task)
    {
        if ($request->has('followers') && $request->followers !== null){
            $followers = explode(',', $request->followers);
            if (count($followers) > 0) {
                foreach ($followers as $follower) {
                    $model = new Follower();
                    $model->follower_id = $follower;
                    $model->task_id = $task->id;
                    $model->save();
                    if (!Follower::find($model->id)->exists()) {
                        throw new Exception("Não foi possivel salvar os seguidores");
                    }
                }
            }
        }
    }

    public function listAllByTask($request)
    {
        $action = app()->make(ListaByTaskAction::class);
        return FollowerResource::collection($action->run($request));
    }

    public function find($request)
    {

    }

    public function update($request)
    {

    }

    public function delete($request)
    {

    }
}

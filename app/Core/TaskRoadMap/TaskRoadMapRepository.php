<?php
namespace App\Core\TaskRoadMap;

use App\Models\Task;
use App\Models\TaskRoadMap;
use Exception;

class TaskRoadMapRepository implements TaskRoadMapRepositoryInterface
{
    public function create($request, ?Task $task = null)
    {
        if ($request->has('road_map_titles') && !is_null($request->road_map_titles)) {
            $titles = explode(',', $request->road_map_titles);
            $descriptions = explode(',', $request->road_map_descriptions);
            if (count($titles) >= count($descriptions)) {
                foreach($titles as $key => $title) {
                    $roadMap = new TaskRoadMap();
                    $roadMap->title = $title;
                    $roadMap->description = $descriptions[$key];
                    $roadMap->task_id = $task === null ? $request->task_id : $task->id;
                    $roadMap->save();
                    if (! TaskRoadMap::find($roadMap->id)->exists()) {
                        throw new Exception("Erro ao salvar a guia da tarefa");
                    }
                }
                return;
            }
            throw new Exception("Não foi possivel criar a tarefa. Dados do road map incorreto");
        }
    }
    public function find($request)
    {

    }
}

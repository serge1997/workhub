<?php
namespace App\Core\Sprint;

use App\Http\Resources\SprintResource;
use App\Http\Resources\TaskResource;
use App\Models\Sprint;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskExecutionStatus;
use Illuminate\Support\Facades\DB;

class SprintRepository implements SprintRepositoryInterface
{
    public function create($request)
    {
        if ($request->has('name')) {
            $sprint = Sprint::create($request->validated());
            return $sprint;
        }
        if ($request->generate() === true){
            return Sprint::create([
                'name' => $this->findLatest() ? 'Sprint '. $this->findLatest()->id + 1 : "Sprint 1"
            ]);
        }


    }

    public function findLatest() : ?Sprint
    {
        return Sprint::latest()->first();
    }

    public function listAll()
    {
        return SprintResource::collection(Sprint::orderBy('id', 'desc')->get());
    }

    public function findAllByProject(Project $project)
    {
        $query = Sprint::select(
            DB::raw('DISTINCT tasks.sprint_id as id'),
            'sprints.name',
            DB::raw('COUNT(DISTINCT tasks.id) as task_total')
        )
            ->addSelect(['task_concluded' => Task::selectRaw(
                "COUNT(t2.id)"
                )
                    ->from('tasks as t2')
                        ->whereColumn('t2.sprint_id', 'tasks.sprint_id')
                            ->where([
                                ['t2.project_id', $project->id],
                                ['t2.execution_status_id', TaskExecutionStatus::CONCLUDED],
                                ['t2.deleted_at', null]
                            ])
                                ->groupBy('t2.sprint_id')
            ])
                ->join('tasks', 'sprints.id', '=', 'tasks.sprint_id')
                    ->where([['tasks.project_id', $project->id], ['tasks.deleted_at', null]])
                        ->groupby(
                            'sprints.id',
                            'sprints.name',
                            'tasks.sprint_id'
                        )
                            ->orderBy('sprints.id', 'desc')
                                ->get();
        $query->each(function($tModel)use($project) {
            $tModel->tasks = TaskResource::collection(
                Task::where([
                    ['project_id', $project->id],
                    ['sprint_id', $tModel->id]
                ])
                    ->get()
            );
        });
        return $query;
    }
}

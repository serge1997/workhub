<?php
namespace App\Core\Project;

use App\Core\Project\Exception\ProjectException;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskExecutionStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function create($request) : Project
    {
        if ($this->findByName($request->name)) {
            throw new ProjectException("projeto já existe");
        }
        return Project::create($request->all());
    }

    public function findAll()
    {
        return ProjectResource::collection(
            Project::all()
        );
    }
    public function findByName(string $name) : ?Project
    {
        return Project::where("name", $name)->first();
    }

    public function find(int $id) : Project
    {
        return Project::find($id);
    }

    public function findAllByTeamSpace(int $team_space_id)
    {
        $query =  Project::select(
            DB::raw("DISTINCT projects.id as id"),
            'projects.name',
            DB::raw("CONCAT('#', projects.severity) as severity"),
            DB::raw("COUNT(tasks.id) task_total")
        )
            ->addSelect(['task_concluded' => Task::selectRaw("
                    COUNT(t2.id)
                ")
                    ->from('tasks as t2')
                        ->where([
                            ['t2.team_id', $team_space_id],
                            ['t2.execution_status_id', TaskExecutionStatus::CONCLUDED],
                            ['t2.deleted_at', null]
                        ])
                            ->whereColumn('t2.project_id', 'projects.id')
                                ->groupBy('t2.project_id')
            ])
                ->withoutGlobalScopes()
                    ->join('tasks', 'tasks.project_id', '=', 'projects.id')
                        ->where([
                            ['tasks.team_id', $team_space_id],
                            ['tasks.deleted_at', null]
                        ])
                            ->groupBy('projects.id', 'projects.name', 'projects.severity')
                                ->get();

        $query->each(function($tQuery) use($team_space_id){
            return $tQuery->tasks = TaskResource::collection(
                Task::where([
                    ['team_id', $team_space_id],
                    ['project_id', $tQuery->id]
                ])->get()
            );
        });
        return $query;
    }

}

<?php
namespace App\Core\Project;

use App\Core\Project\Exception\ProjectException;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
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
        return Project::select(
            DB::raw("DISTINCT projects.id"),
            'projects.name',
            'projects.severity',
            DB::raw("COUNT(tasks.id) tasks_count")
        )
            ->join('tasks', 'tasks.project_id', '=', 'projects.id')
                ->where('tasks.team_id', $team_space_id)
                    ->groupBy('projects.id', 'projects.name', 'projects.severity')
                        ->get();
    }

}

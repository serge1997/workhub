<?php
namespace App\Core\Sprint;

use App\Http\Resources\SprintResource;
use App\Models\Sprint;
use App\Models\Project;
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
            'sprints.id',
            'sprints.name',
            'sprints.start_at',
            'sprints.close_at',
            'sprints.deleted_at',
            DB::raw('COUNT(tasks.id) as count_tasks')
        )
        ->join('tasks', 'sprints.id', '=', 'tasks.sprint_id')
            ->where([['tasks.project_id', $project->id], ['tasks.deleted_at', null]])
                ->groupby(
                    'sprints.id',
                    'sprints.name',
                    'sprints.start_at',
                    'sprints.close_at',
                    'sprints.deleted_at'
                )
                    ->orderBy('sprints.id', 'desc')
                        ->get();
        return $query;
    }
}

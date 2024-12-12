<?php
namespace App\Core\Bi\Repository;

use App\Models\Scopes\NotDeletScope;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class BiRepository implements BiRepositoryInterface
{

    public function countTaskBySprintProject(int $project_id)
    {
        return Task::select(
            DB::raw("COUNT(tasks.id) as task_count"),
            'sprints.name as labels'

        )
            ->join('sprints', 'sprints.id', '=', 'tasks.sprint_id')
                ->where([
                    ['tasks.project_id', $project_id],
                    ['tasks.deleted_at', null]
                ])
                ->withoutGlobalScope(NotDeletScope::class)
                    ->groupBy('sprints.name')
                        ->get();
    }
}

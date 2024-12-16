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

    public function listTaskCompletedAndNotByProject(int $project_id)
    {
        return Task::select('sp.id', 'sp.name')
            ->withoutGlobalScopes()
                ->selectRaw('COUNT(tasks.id) as total_tasks')
                    ->from('tasks as tasks')
                        ->addSelect(['concluded' => Task::selectRaw("COUNT(t2.id)")
                            ->from('tasks as t2')
                                ->whereColumn([
                                    ['tasks.project_id', 't2.project_id'],
                                    ['tasks.sprint_id', 't2.sprint_id'],
                                ])
                                    ->where([
                                        ['t2.execution_status_id', 8],
                                        ['t2.deleted_at', null]
                                    ])
                                        ->groupBy('t2.sprint_id')
                        ])
                        ->join('sprints as sp', 'sp.id', '=', 'tasks.sprint_id')
                            ->where([
                                ['tasks.project_id', 1],
                                ['tasks.deleted_at', null]
                            ])
                                ->groupBy('sp.id', 'sp.name', 'tasks.project_id', 'tasks.sprint_id')
                                    ->orderBy('tasks.sprint_id', 'DESC')
                                        ->get();
    }
}

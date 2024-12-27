<?php
namespace App\Core\Bi\Repository;

use App\Http\Resources\TaskResource;
use App\Models\Scopes\NotDeletScope;
use App\Models\Task;
use App\Models\TaskExecutionStatus;
use App\Models\User;
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
                                        ['t2.execution_status_id', TaskExecutionStatus::CONCLUDED],
                                        ['t2.deleted_at', null]
                                    ])
                                        ->groupBy('t2.sprint_id')
                        ])
                        ->join('sprints as sp', 'sp.id', '=', 'tasks.sprint_id')
                            ->where([
                                ['tasks.project_id', $project_id],
                                ['tasks.deleted_at', null]
                            ])
                                ->groupBy('sp.id', 'sp.name', 'tasks.project_id', 'tasks.sprint_id')
                                    ->orderBy('tasks.sprint_id', 'DESC')
                                        ->get();
    }
    public function concludedAndNotBySprint(int $sprint_id)
    {
        $groupBy = "IF(tasks.execution_status_id =". TaskExecutionStatus::CONCLUDED .",'CONCLUDED', 'NOT CONCLUDED')";
        $collection = Task::selectRaw(
            "COUNT(tasks.id) as task_count,
            IF(tasks.execution_status_id = 8, 'Concluded', 'Not concluded') as label",
        )
            ->join('task_execution_status as status', 'tasks.execution_status_id', '=', 'status.id')
                ->where([
                    ['tasks.sprint_id', $sprint_id],
                    ['tasks.deleted_at', null],
                    ['tasks.execution_status_id', '<>', TaskExecutionStatus::BACKLOG]
                ])
                    ->withoutGlobalScopes()
                        ->groupByRaw($groupBy)
                            ->get();
        $totalTask = $collection->sum(fn($data) => $data->task_count);
        $collection->each(function($tModel) use($totalTask) {
            $tModel->value = number_format($tModel->task_count * 100 / $totalTask, "2") . "%";
            $tModel->color = $tModel->label == "Concluded" ? "#34d399" : '#f59e0b';
        });
        return $collection;
    }

    public function findAllMembersTaskByTeam(int $team_id)
    {
        $query = User::selectRaw(
            "DISTINCT(users.id) as user_id,
            IF(COUNT(t.id) IS NOT NULL, COUNT(t.id), '-') as task_total,
            users.name,
            users.avatar"
        )
            ->addSelect(['task_concluded' => Task::selectRaw(
                "IF(COUNT(t2.id) IS NOT NULL, COUNT(t2.id), '-')"
            )
                ->from('tasks as t2')
                    ->whereColumn('t2.user_id', 't.user_id')
                        ->where([
                            ['t2.team_id', $team_id],
                            ['t2.execution_status_id', TaskExecutionStatus::CONCLUDED],
                            ['t2.deleted_at', null]
                        ])
                            ->groupBy('t2.user_id')
            ])
                ->leftJoin('tasks as t', function($leftJoin){
                    $leftJoin->on('users.team_id', '=', 't.team_id');
                    $leftJoin->on('users.id', '=','t.user_id');
                })
                    ->where([
                        ['users.team_id', $team_id],
                        ['t.deleted_at', null]
                    ])
                        ->withoutGlobalScopes()
                            ->orderByRaw('COUNT(t.id) DESC')
                                ->groupBy('users.name', 't.user_id', 'users.avatar', 'users.id')
                                    ->get();
        $query->each(function($tModel) use($team_id) {
            return $tModel->tasks = TaskResource::collection(
                Task::where([
                    ['user_id', $tModel->user_id],
                    ['team_id', $team_id]
                ])->get()
            );
        });
        return $query;
    }
}

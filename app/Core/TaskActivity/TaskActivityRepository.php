<?php
namespace App\Core\TaskActivity;

use App\Http\Resources\TaskActivityResource;
use App\Models\TaskActivity;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Termwind\Components\Raw;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TaskActivityRepository implements TaskActivityRepositoryInterface
{
    public function create(int $author_id, int $task_id, string $content, ?string $description, ?int $origin_id = null) : TaskActivity
    {
        $activity = TaskActivity::query()->create([
                    'description' => $description,
                    'user_id' => $author_id,
                    'task_id' => $task_id,
                    'activity' => $content,
                    'origin_id' => $origin_id
                ]);
        return $activity;
    }

    public function listByTask()
    {

    }

    public function notifyByTaskExecutor($request)
    {
        return TaskActivity::query()
                    ->select(
                        DB::raw('DISTINCT tasks_activities.id as id'),
                        'tasks_activities.created_at',
                        'tasks_activities.description',
                        'tasks_activities.origin_id',
                        'tasks.id as task_id',
                        DB::raw("CASE
                            WHEN tasks_activities.user_id =". $request->user()->id . " THEN RPAD(CONCAT('você',' ',tasks_activities.activity), 23,'')
                            ELSE RPAD(CONCAT(users.name,' ',tasks_activities.activity), 23,'')
                            END as notification"
                        ))
                        ->join('tasks', function (JoinClause $join){
                            $join->on('tasks.id', '=', 'tasks_activities.task_id')
                                ->where('tasks_activities.is_readed', false);
                            })
                            ->join('users', 'tasks_activities.user_id', '=', 'users.id')
                                    ->join('followers', 'tasks.id', '=', 'followers.task_id')
                                        ->where('tasks.user_id', $request->user()->id)
                                            ->orWhere('followers.follower_id', $request->user()->id)
                                                ->orWhere('tasks.manager_id', $request->user()->id)
                                                    ->orderBy('tasks_activities.created_at', 'desc')
                                                        ->get();

    }

    public function markAsReaded($request) : void
    {
        TaskActivity::find($request->task_activity_id)
            ->update([
                'is_readed' => true
            ]);
    }
}

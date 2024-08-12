<?php
namespace App\Core\TaskActivity;

use App\Http\Resources\TaskActivityResource;
use App\Models\TaskActivity;

class TaskActivityRepository implements TaskActivityRepositoryInterface
{
    public function create(int $author_id, int $task_id, string $content, ?string $description) : TaskActivity
    {
        $activity = TaskActivity::query()->create([
                    'description' => $description,
                    'user_id' => $author_id,
                    'task_id' => $task_id,
                    'activity' => $content,
                ]);
        return $activity;
    }

    public function listByTask()
    {

    }

    public function notifyByTaskExecutor($request)
    {
        $taskActivities = TaskActivity::query()
                    ->select('tasks_activities.id', 'tasks_activities.created_at')
                        ->join('tasks', 'tasks_activities.task_id', '=', 'tasks.id')
                            ->where('tasks.user_id', $request->user()->id)
                                ->orderBy('tasks_activities.created_at', 'desc')
                                    ->get();


        return $taskActivities;
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Annex;
use App\Models\TaskRoadMap;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RoadMapResource;
use Carbon\Carbon;
use App\Utility\Utilities;
use Illuminate\Support\Str;
use App\Models\Follower;
use App\Models\Task;
use App\Enums\UserTypeEnum;
use App\Models\Comment;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'short_description' => Str::limit($this->description, 60),
            'priority' => $this->priority,
            'priority_fullDescription' => $this->prioriryFullDescription($this->priority),
            'manager_id' => $this->manager_id,
            'user_id'    => $this->user_id,
            'manager_name' => $this->manager,
            'project_id' => $this->project_id,
            'project_severity' => $this->project->severity,
            'project_name' => $this->project->name,
            'user_name'    => $this->user,
            'execution_delay' => $this->execution_delay,
            'is_expired' => $this->execution_delay > $this->delay_used,
            'roads_map' => RoadMapResource::collection(TaskRoadMap::where('task_id', $this->id)->get()),
            'execution_status' => $this->executionStatus->status,
            'execution_status_severity' => $this->executionStatus->executionStatusSeveriry(),
            'followers' => FollowerResource::collection($this->followers),
            'followers_count' => $this->followers->count(),
            'annex_count' => $this->annexes->count(),
            'annexes' => AnnexResource::collection($this->annexes),
            'task_owner' => $this->when($request->user()->id == $this->user_id, true),
            'customColumnValue' => CustomsColumnsValueResource::collection($this->customColumnValue),
            'full_task_execution_status' => strtolower($this->executionStatus->name),
            'can_delete' => $this->when($request->user()->id == $this->user_id, true),
            'comment_count' => $this->when($this->comment->count() > 0, $this->comment->count(), true),
            'activities' => TaskActivityResource::collection($this->taskActivity->take(4)),
            'sprint_name' => $this->sprint ? ucfirst($this->sprint->name) : 'Nenhum sprint',
            'sub_task_count' => $this->subTasks->where('deleted_at', null)->count(),
            'is_sub_task' => $this->isSubTask(),
            'parent_id' => $this->parent?->task_id

        ];
    }
}

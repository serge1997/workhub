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
            'user_name'    => $this->user,
            'execution_delay' => $this->execution_delay,
            'is_expired' => $this->execution_delay > $this->delay_used,
            'roads_map' => RoadMapResource::collection(TaskRoadMap::where('task_id', $this->id)->get()),
            'execution_status' => $this->execution_status,
            'followers' => FollowerResource::collection($this->followers),
            'followers_count' => $this->countFollowers(),
            'annex_count' => $this->countAnnex(),
            'annexes' => AnnexResource::collection($this->annexes),
            'task_owner' => $this->when($request->user()->id == $this->user_id, true),
            'customColumnValue' => CustomsColumnsValueResource::collection($this->customColumnValue),
            'full_task_execution_status' => $this->fullExecutionLabel(),
            'can_delete' => $this->when($this->isAdminAndTaskOwner($request->user()->id), true),
            'comment_count' => $this->when($this->countComment() > 0, $this->countComment()),

        ];
    }

    public function countFollowers()
    {
        return Follower::where('task_id', $this->id)->count() ?? "-";
    }

    public function countAnnex()
    {
        return Annex::where('task_id', $this->id)->count() ?? "-";
    }

    public function prioriryFullDescription(string $priority) : string
    {
        return match($priority)
        {
            Task::URG => "Urgente",
            Task::ALT => "Alta",
            Task::MED => "Media",
            Task::LOW => "Baixa"
        };
    }

    public function countComment() : int
    {
        return Comment::where('task_id', $this->id)->count() ?? 0;
    }
}

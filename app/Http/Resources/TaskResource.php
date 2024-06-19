<?php

namespace App\Http\Resources;

use App\Models\TaskRoadMap;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Utility\Utilities;
use Illuminate\Support\Str;

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
            'manager_id' => $this->manager_id,
            'user_id'    => $this->user_id,
            'manager_name' => $this->manager,
            'user_name'    => $this->user,
            'execution_delay' => $this->execution_delay,
            'is_expired' => $this->execution_delay > $this->delay_used,
            'roads_map' => TaskResource::collection(TaskRoadMap::where('task_id', $this->id)->get()),
            'execution_status' => $this->execution_status

        ];
    }
}

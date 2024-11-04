<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'start_at' => date('d/m/Y', strtotime($this->start_at)),
            'end_at' => date('d/m/Y', strtotime($this->end_at)),
            'tasks_count_in_progress' => $this->tasks_in_progress->count(),
            'task_count_concluded' => $this->tasks_concluded->count(),
            'members_count' => $this->members_count[0]['user_id']
        ];
    }
}

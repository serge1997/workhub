<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TaskActivityResource extends JsonResource
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
            'description' => $this->description,
            'notification' => Str::limit("{$this->user->name} {$this->activity}", 25),
            'activity' => $this->activity,
            'author' => $this->user->name,
            'task_executed_by' => $this->task->user_id,
            'created_at' => date('d/m/y H:i:s', strtotime($this->created_at))
        ];
    }
}

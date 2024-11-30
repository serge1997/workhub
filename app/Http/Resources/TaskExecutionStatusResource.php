<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskExecutionStatusResource extends JsonResource
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
            'name_ucfirst' => ucfirst(strtolower($this->name)),
            'status' => $this->status,
            'description' => $this->description,
            'severity' => $this->executionStatusSeveriry(),
            'task_count' => $this->count_task() ?: "-"
        ];
    }
}

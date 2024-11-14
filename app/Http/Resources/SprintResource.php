<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SprintResource extends JsonResource
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
            'name' => ucfirst($this->name),
            'start_at' => $this->start_at,
            'close_at' => $this->close_at,
            'deleted_at' => $this->deleted_at,
            'count_tasks' => $this->tasks->count()
        ];
    }
}

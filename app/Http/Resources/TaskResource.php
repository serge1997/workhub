<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Utility\Utilities;

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
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'manager_id' => $this->manager_id,
            'user_id'    => $this->user_id,
            'manager_name' => $this->manager->name,
            'user_name'    => $this->user->name,
            'execution_delay' => $this->execution_delay,
            'is_expired' => $this->execution_delay > Utilities::now()

        ];
    }
}

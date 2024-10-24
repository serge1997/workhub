<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnexResource extends JsonResource
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
            'task_id' => $this->task_id,
            'annex' => $this->annex,
            'owner' => $this->when($request->user()->id === $this->task->user_id, true),
            'created_at' => date('d/m/Y H:i', strtotime($this->created_at)),
            'user_name' => $this->task->user->name,
            'annex_type' => $this->annexType()
        ];
    }

    public function annexType() : string
    {
        if (in_array($this->extention(), ['jpeg', 'jpg', 'png'])){
            return "image";
        }
        return "pdf";
    }
}

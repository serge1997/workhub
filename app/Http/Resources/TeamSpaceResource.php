<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TeamSpaceResource extends JsonResource
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
            'first_letter' => ucfirst($this->name[0]),
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => date('d/m/y H:i:s', strtotime($this->created_at)),
            'slug' => Str::slug($this->name, '-')
        ];
    }
}

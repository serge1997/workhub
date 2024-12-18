<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "response" => $this->response,
            "user_name" => $this->user->name,
            "avatar" => $this->user->avatar,
            "user_id" => $this->user_id,
            "comment_id" => $this->comment_id,
            "owner" => $this->when($request->user()->id === $this->user_id, true),
            "since" => $this->since()

        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\CommentResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"        => $this->id,
            "comment"   => $this->comment,
            "user_name" => $this->user->name,
            "avatar"    => $this->user->avatar,
            "user_id"   => $this->user_id,
            "owner"     => $this->when($request->user()->id == $this->user_id, true),
            "response"  => $this->when($this->has_response,
                CommentResponseResource::collection(
                    CommentResponse::where('comment_id', $this->id)
                        ->orderBy('created_at', 'asc')
                            ->get()
                        ))
        ];
    }
}

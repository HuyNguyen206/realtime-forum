<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => $this->user->name,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at->toFormattedDateString(),
            'like_count' => $this->likedUsers->count(),
            'is_like' => optional(auth()->user())->likeReply($this)
        ];
    }
}

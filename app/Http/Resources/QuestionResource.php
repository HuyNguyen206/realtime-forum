<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $replies = $this->replies;
        $replyCount = $replies->count();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'path' => route('questions.show', $this->slug),
            'slug' => $this->slug,
            'body' => $this->body,
            'user' => $this->user->name,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at->toFormattedDateString(),
            'replies' => ReplyResource::collection($replies),
            'replies_count' => $replyCount.' '.Str::plural('reply', $replyCount)
        ];
    }
}

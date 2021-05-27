<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'path' => route('questions.show', $this->slug),
            'slug' => $this->slug,
            'body' => $this->body,
            'user' => $this->user->name,
            'created_at' => $this->created_at->toFormattedDateString(),
        ];
    }
}

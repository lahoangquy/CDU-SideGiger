<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status,
            'description' => $this->description,
            'statusText' => config('app.project_status')[$this->status],
            'due_date' => strtotime($this->due_date),
            'created_at' => $this->created_at->diffForHumans(),
            'hasRequestCompleted' => $this->requestCompleted ?? false,
            'category' => $this->category,
            'poster' => new UserResource($this->whenLoaded('poster')),
            'feedback' =>  $this->whenLoaded('feedback'),
            'offers' => $this->whenLoaded('offers'),
            'attachments' => $this->documents->where('moment', 1),
            'messages' => MessageResource::collection($this->whenLoaded('messages'))
        ];
    }
}

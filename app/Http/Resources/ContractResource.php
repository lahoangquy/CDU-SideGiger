<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
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
            'status' => $this->status,
            'started_at' => Carbon::createFromDate($this->started_at)->format('F j, Y'),
            'completed_at' => Carbon::createFromDate($this->completed_at)->format('F, Y'),
            'feedback' => new ProjectContractFeedbackResource($this->whenLoaded('feedback')),
            'project' => new ProjectResource($this->whenLoaded('project')),
            'student' => new UserResource($this->whenLoaded('student')),
            'owner' => new UserResource($this->whenLoaded('owner')),
        ];
    }
}

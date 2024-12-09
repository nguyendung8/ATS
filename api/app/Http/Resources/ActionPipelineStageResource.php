<?php

namespace App\Http\Resources;

use App\Http\Resources\Custom\ShareResource;

class ActionPipelineStageResource extends ShareResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     * @var  \Illuminate\Http\Request $request
     *
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'actionId' => $this->action_id,
            'pipelineStageId' => $this->pipeline_stage_id,
            'options' => $this->options,
            'action' => ActionResource::make($this->whenLoaded('action')),
        ];
    }
}

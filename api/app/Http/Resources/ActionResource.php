<?php

namespace App\Http\Resources;

use App\Http\Resources\Custom\ShareResource;

class ActionResource extends ShareResource
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
            'name' => $this->name,
            'fileName' => $this->convertToFileName($this->name),
            'type' => $this->type,
            'options' => $this->options,
            'pipelineStages' => PipelineStageResource::collection($this->whenLoaded('pipelineStages')),
        ];
    }

    function convertToFileName($string)
    {
        $fileName = ucwords($string);

        return str_replace(' ', '', $fileName);
    }
}

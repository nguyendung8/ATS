<?php

namespace App\Http\Controllers\PipelineStage;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActionResource;
use App\Models\PipelineStage;

class GetActionsByPipelineStageController extends Controller
{
    public function __invoke(PipelineStage $pipelineStage)
    {
        return ActionResource::collection($pipelineStage->actions);
    }
}

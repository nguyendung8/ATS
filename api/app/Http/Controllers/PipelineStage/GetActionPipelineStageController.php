<?php

namespace App\Http\Controllers\PipelineStage;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActionPipelineStageResource;
use App\Http\Resources\ActionResource;
use App\Models\Action;
use App\Models\ActionPipelineStage;
use App\Models\PipelineStage;

class GetActionPipelineStageController extends Controller
{
    public function __invoke(PipelineStage $pipelineStage, Action $action)
    {
        $result = ActionPipelineStage::where([
            'action_id' => $action->id,
            'pipeline_stage_id' => $pipelineStage->id,
        ])->first();

        return $result ? ActionPipelineStageResource::make($result) : ActionResource::make($action);
    }
}

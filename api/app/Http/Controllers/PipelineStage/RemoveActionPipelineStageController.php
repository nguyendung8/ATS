<?php

namespace App\Http\Controllers\PipelineStage;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\ActionPipelineStage;
use App\Models\PipelineStage;

class RemoveActionPipelineStageController extends Controller
{
    public function __invoke(PipelineStage $pipelineStage, Action $action)
    {
        try {
            return ActionPipelineStage::where([
                'action_id' => $action->id,
                'pipeline_stage_id' => $pipelineStage->id,
            ])->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

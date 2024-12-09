<?php

namespace App\Http\Controllers\PipelineStage;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActionResource;
use App\Models\Action;
use App\Models\ActionPipelineStage;
use App\Models\PipelineStage;
use Illuminate\Http\Request;

class SaveActionPipelineStageController extends Controller
{
    public function __invoke(Request $request, PipelineStage $pipelineStage, Action $action)
    {
        $result = ActionPipelineStage::updateOrCreate(
            [
                'action_id' => $action->id,
                'pipeline_stage_id' => $pipelineStage->id,
            ],
            [
                'options' => $request->input('options'),
            ]
        );

        return ActionResource::make($result->action);
    }
}

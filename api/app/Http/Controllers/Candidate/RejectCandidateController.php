<?php

namespace App\Http\Controllers\Candidate;

use App\Enums\Action\ActionType;
use App\Helper\FillRejectionMail;
use App\Http\Controllers\Controller;
use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use App\Models\Pipeline;
use App\Models\Rejection;
use App\Models\Stage;
use App\Notifications\RejectCandidate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RejectCandidateController extends Controller
{
    public function __invoke(Request $request, Candidate $candidate, Pipeline $pipeline, Stage $stage)
    {
        $pipelineStage = $pipeline->pipelineStages()->where('stage_id', $candidate->currentCandidateJob->stage_id)->first();

        $rejectedAction = optional($pipelineStage)->actions()
            ->where('type', ActionType::REJECT_CANDIDATE)
            ->first();

        if ($rejectedAction) {
            $options = json_decode($rejectedAction->actionPipelineStage->options, false);

            $candidate->currentCandidateJob()->update([
                'rejection_id' => $request->input('rejection_id'),
            ]);

            if ($options->is_send_mail) {
                $mailTemplate = Rejection::find($request->input('rejection_id'))->mailTemplate;
                $mail = (new FillRejectionMail($candidate, $mailTemplate))->fill();

                $candidate->notify(new RejectCandidate($candidate, (object) $mail));
            }

            return CandidateResource::make($candidate);
        }

        return response()->json(['success' => false]);
    }
}

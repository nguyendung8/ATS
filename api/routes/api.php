<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\Candidate\RejectCandidateController;
use App\Http\Controllers\PipelineStage\RemoveActionPipelineStageController;
use App\Http\Controllers\PipelineStage\SaveActionPipelineStageController;
use App\Http\Controllers\AssessmentFormController;
use App\Http\Controllers\Candidate\CountCandidatesByMonthController;
use App\Http\Controllers\Candidate\CreateEducationController;
use App\Http\Controllers\Candidate\CreateExperienceController;
use App\Http\Controllers\Candidate\MoveStageController;
use App\Http\Controllers\Candidate\UpdateCandidateStar;
use App\Http\Controllers\Candidate\UpdateProfileController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\GenAIController;
use App\Http\Controllers\Interview\SubmitAssessmentForm;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\Job\CreateCandidateController;
use App\Http\Controllers\Job\AdminCreateCandidateController;
use App\Http\Controllers\Job\GetAllLocationController;
use App\Http\Controllers\Job\GetAllPublishedJobController;
use App\Http\Controllers\Job\GetPublishedJobController;
use App\Http\Controllers\Job\GetAllTagController;
use App\Http\Controllers\Job\GetPublishedJobNameController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MailTemplate\FillInterviewMailController;
use App\Http\Controllers\MailTemplateController;
use App\Http\Controllers\Permission\AddRolesToPermissionController;
use App\Http\Controllers\Permission\AddUsersToPermissionController;
use App\Http\Controllers\Permission\RemoveRolesFromPermissionController;
use App\Http\Controllers\Permission\RemoveUsersFromPermissionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\PipelineStage\GetActionPipelineStageController;
use App\Http\Controllers\PipelineStage\GetActionsByPipelineStageController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RejectionController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ResumeTemplateController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Stage\GetCandidatesByStageAndJobController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\User\UpdateAvatarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoCall\GenerateAgoraToken;
use App\Http\Controllers\WebInitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/gen-ai/upload', [GenAIController::class, 'upload']);

Route::post('/users/register', [UserController::class, 'register']);

Route::prefix('interviews')->group(function () {
    Route::get('{interviewHashId}', [InterviewController::class, 'show']);
});

Route::prefix('users')->group(function () {
    Route::post('/{user}/upload-avatar', UpdateAvatarController::class);
});

Route::prefix('jobs')->group(function () {
    Route::get('/published', GetAllPublishedJobController::class);
    Route::get('/published/get-names', GetPublishedJobNameController::class);
    Route::get('/published/{job}', GetPublishedJobController::class);
    Route::get('/locations', GetAllLocationController::class);
    Route::get('/tags', GetAllTagController::class);
    Route::post('/{job}/candidates', CreateCandidateController::class);
    Route::post('/{job}/admin/candidates', AdminCreateCandidateController::class);
    Route::delete('/{job}/candidates/{candidate}', [JobController::class, 'deleteCandidate']);
    Route::get('/{id}/applied', [JobController::class, 'getAppliedJobs']);
});

Route::prefix('resumes')->group(function () {
    Route::post('/{resume}/save-content', [ResumeController::class, 'saveContent']);
    Route::get('/{resume}/load-content', [ResumeController::class, 'loadContent']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', WebInitController::class);

    Route::prefix('stages')->group(function () {
        Route::get('/{stage}/pipelines/{pipeline}/jobs/{jobId}/candidates', GetCandidatesByStageAndJobController::class);
        Route::post('/{stage}/jobs/{job}/add-candidate', \App\Http\Controllers\Stage\AddCandidateToStageController::class);
    });

    Route::prefix('mail-templates')->group(function () {
        Route::get('{mailTemplate}/interviews/{interview}/fill-interview-mail', FillInterviewMailController::class);
    });

    Route::prefix('video-call')->group(function () {
        Route::post('interviews/{interviewHashId}/token', GenerateAgoraToken::class);
    });

    Route::prefix('candidates')->group(function () {
        Route::put('update-profile', UpdateProfileController::class);
        Route::get('{candidate}/star', UpdateCandidateStar::class);
        Route::get('{candidate}/stages/{stage}/move', MoveStageController::class);
        Route::post('{candidate}/education', CreateEducationController::class);
        Route::post('{candidate}/experiences', CreateExperienceController::class);
        Route::get('count-by-months', CountCandidatesByMonthController::class);
        Route::post('{candidate}/pipelines/{pipeline}/stages/{stage}/reject', RejectCandidateController::class);
    });

    Route::prefix('interviews')->group(function () {
        Route::post('{interview}/submit-assessment-form', SubmitAssessmentForm::class);
        Route::put('{interview}/cancel', [InterviewController::class, 'cancelInterview']);
    });

    Route::prefix('permissions')->group(function () {
        Route::post('/{permission}/add-users', AddUsersToPermissionController::class);
        Route::post('/{permission}/remove-users', RemoveUsersFromPermissionController::class);
        Route::post('/{permission}/add-roles', AddRolesToPermissionController::class);
        Route::post('/{permission}/remove-roles', RemoveRolesFromPermissionController::class);
    });

    Route::prefix('pipeline-stages')->group(function () {
        Route::get('/{pipelineStage}/actions', GetActionsByPipelineStageController::class);
        Route::get('/{pipelineStage}/actions/{action}', GetActionPipelineStageController::class);
        Route::post('/{pipelineStage}/actions/{action}', SaveActionPipelineStageController::class);
        Route::delete('/{pipelineStage}/actions/{action}', RemoveActionPipelineStageController::class);
    });

    Route::resources([
        'jobs' => JobController::class,
        'candidates' => CandidateController::class,
        'pipelines' => PipelineController::class,
        'mail-templates' => MailTemplateController::class,
        'staffs' => StaffController::class,
        'rooms' => RoomController::class,
        'resumes' => ResumeController::class,
        'education' => EducationController::class,
        'experiences' => ExperienceController::class,
        'stages' => StageController::class,
        'assessment-forms' => AssessmentFormController::class,
        'criteria' => CriterionController::class,
        'questions' => QuestionController::class,
        'permissions' => PermissionController::class,
        'users' => UserController::class,
        'roles' => RoleController::class,
        'actions' => ActionController::class,
        'rejections' => RejectionController::class,
        'resume-templates' => ResumeTemplateController::class,
    ]);
    Route::resource('interviews', InterviewController::class)->except(['show']);
});

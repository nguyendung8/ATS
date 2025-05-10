<?php

namespace App\Http\Controllers\Job;

use App\Enums\Candidate\CandidateStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GenAIController;
use App\Http\Requests\Job\StoreCandidateRequest;
use App\Http\Resources\CandidateResource;
use App\Models\Education;
use App\Models\Job;
use App\Repositories\Candidate\CandidateRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class AdminCreateCandidateController extends Controller
{
    protected CandidateRepositoryInterface $candidateRepository;

    public function __construct(CandidateRepositoryInterface $candidateRepository)
    {
        $this->candidateRepository = $candidateRepository;
    }

    public function __invoke(StoreCandidateRequest $request, Job $job)
    {
        try {
            DB::beginTransaction();

            $file = $request->file('resume');
            $filePath = $file->store('public/resumes');
            $pathResume = Storage::url($filePath);
            
            // Kiểm tra email đã tồn tại chưa
            $user = \App\Models\User::where('email', $request->input('email'))->first();
            
            if (!$user) {
                // Tạo user mới nếu chưa tồn tại
                $user = \App\Models\User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone_number' => $request->input('phoneNumber'),
                    'password' => bcrypt(Str::random(12)), // Tạo mật khẩu ngẫu nhiên
                ]);
                
                // Gán role candidate cho user mới
                $candidateRole = Role::where('name', 'candidate')->first();
                if ($candidateRole) {
                    $user->assignRole($candidateRole);
                }
            } else {
                // Cập nhật thông tin nếu đã tồn tại
                $user->update([
                    'name' => $request->input('name'),
                    'phone_number' => $request->input('phoneNumber'),
                ]);
            }
            
            $educationData = [];
            $workExperienceData = [];
            $personalInfo = [];
            
            try {
                $response = GenAIController::sendToGenerativeAI($file);
                $educationData = $response['education'] ?? [];
                $workExperienceData = $response['work_experience'] ?? [];
                $personalInfo = $response['personal_info'] ?? [];
            } catch (Exception $e) {
                // Log error but continue with empty data
                Log::error('GenAI Error in AdminCreateCandidate: ' . $e->getMessage());
            }

            // Tạo candidate trước nếu chưa tồn tại
            $candidate = $user->candidate;
            if (!$candidate) {
                $candidate = $user->candidate()->create([
                    'resume_url' => $pathResume,
                    'status' => CandidateStatus::NEW,
                ]);
                $user->refresh();
            } else {
                $candidate->update([
                    'resume_url' => $pathResume,
                    'status' => CandidateStatus::NEW,
                ]);
            }

            if (!empty($educationData)) {
                foreach ($educationData as $edu) {
                    $startDate = null;
                    $endDate = null;
                    try {
                        $startDate = Carbon::parse($edu['start_date'] ?? '')->toDateString();
                        $endDate = Carbon::parse($edu['end_date'] ?? '')->toDateString();
                    } catch (Exception $e) {
                    }
                    
                    Education::create([
                        'school_name' => $edu['school_name'] ?? 'Unknown School',
                        'field_of_study' => $edu['field_of_study'] ?? 'General Studies',
                        'degree' => $edu['degree'] ?? 'No Degree Specified',
                        'grade' => $edu['grade'] ?? 'Not Available',
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'candidate_id' => $candidate->id,
                    ]);
                }
            }
            
            if (!empty($workExperienceData)) {
                foreach ($workExperienceData as $workExperience) {
                    $startDate = null;
                    $endDate = null;
                    try {
                        $startDate = Carbon::parse($workExperience['start_date'] ?? '')->toDateString();
                        $endDate = Carbon::parse($workExperience['end_date'] ?? '')->toDateString();
                    } catch (Exception $e) {
                    }

                    $candidate->experiences()->create([
                        'company_name' => $workExperience['company_name'] ?? 'Unknown Company',
                        'position' => $workExperience['position'] ?? 'Unknown Position',
                        'summary' => $workExperience['summary'] ?? 'No details provided',
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'candidate_id' => $candidate->id,
                    ]);
                }
            }

            $stage = optional($job->pipeline)->stages[0];
            
            // Đánh dấu tất cả candidate_job cũ là không active
            DB::table('candidate_jobs')
                ->where('candidate_id', $candidate->id)
                ->where('job_id', $job->id)
                ->update(['is_active' => false]);
                
            // Tạo bản ghi mới với is_active = true
            $job->candidateJobs()->create([
                'candidate_id' => $candidate->id,
                'job_id' => $job->id,
                'stage_id' => optional($stage)->id,
                'is_active' => true
            ]);

            DB::commit();
            return CandidateResource::make($candidate->load('user'));
        } catch (Exception $e) {
            DB::rollback();

            // Kiểm tra nếu lỗi liên quan đến GenAI
            if (strpos($e->getMessage(), 'generativelanguage.googleapis.com') !== false) {
                Log::error('GenAI Service Unavailable: ' . $e->getMessage());
                return response()->json([
                    'message' => 'Hệ thống hiện không thể phân tích CV. CV đã được lưu và có thể cập nhật thông tin thủ công.',
                    'errors' => ['resume' => ['Dịch vụ phân tích CV đang bận, vui lòng thử lại sau hoặc cập nhật thông tin thủ công.']]
                ], 503);
            }

            throw $e;
        }
    }
}

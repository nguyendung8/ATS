<?php

namespace App\Http\Controllers\Stage;

use App\Enums\Candidate\CandidateStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GenAIController;
use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use App\Models\CandidateJob;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Job;
use App\Models\Stage;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AddCandidateToStageController extends Controller
{
    /**
     * Thêm ứng viên mới vào một stage cụ thể
     */
    public function __invoke(Request $request, Stage $stage, Job $job)
    {
        try {
            // Validate dữ liệu đầu vào
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phoneNumber' => 'required|string|max:20',
                'resume' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:2000',
                'gender' => 'nullable|string',
                'birthday' => 'nullable|date',
                'address' => 'nullable|string',
                'description' => 'nullable|string',
                'education' => 'nullable|array',
                'experiences' => 'nullable|array',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Kiểm tra email đã tồn tại chưa
            $user = User::where('email', $request->input('email'))->first();
            
            if (!$user) {
                // Tạo user mới nếu chưa tồn tại
                $user = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone_number' => $request->input('phoneNumber'),
                    'gender' => $request->input('gender'),
                    'birthday' => $request->input('birthday'),
                    'address' => $request->input('address'),
                    'password' => bcrypt(Str::random(12)), // Tạo mật khẩu ngẫu nhiên
                ]);
            } else {
                // Cập nhật thông tin nếu đã tồn tại
                $user->update([
                    'name' => $request->input('name'),
                    'phone_number' => $request->input('phoneNumber'),
                    'gender' => $request->input('gender'),
                    'birthday' => $request->input('birthday'),
                    'address' => $request->input('address'),
                ]);
            }
            
            // Xử lý file CV
            $file = $request->file('resume');
            $filePath = $file->store('public/resumes');
            $pathResume = Storage::url($filePath);

            // Xử lý dữ liệu từ CV bằng GenAI
            $educationData = [];
            $workExperienceData = [];
            $personalInfo = [];
            
            try {
                $response = GenAIController::sendToGenerativeAI($file);
                $educationData = $response['education'] ?? [];
                $workExperienceData = $response['work_experience'] ?? [];
                $personalInfo = $response['personal_info'] ?? [];
            } catch (Exception $e) {
                Log::error('GenAI Error in AddCandidateToStage: ' . $e->getMessage());
            }

            // Tạo hoặc cập nhật candidate
            $candidate = $user->candidate;
            
            if (!$candidate) {
                $candidate = $user->candidate()->create([
                    'resume_url' => $pathResume,
                    'status' => CandidateStatus::NEW,
                    'description' => $request->input('description'),
                ]);
                $user->refresh();
            } else {
                $candidate->update([
                    'resume_url' => $pathResume,
                    'status' => CandidateStatus::NEW,
                    'description' => $request->input('description'),
                ]);
            }

            // Thêm thông tin giáo dục từ form hoặc CV
            if ($request->has('education') && !empty($request->input('education'))) {
                foreach ($request->input('education') as $edu) {
                    Education::create([
                        'school_name' => $edu['school_name'] ?? '',
                        'field_of_study' => $edu['field_of_study'] ?? '',
                        'degree' => $edu['degree'] ?? '',
                        'grade' => $edu['grade'] ?? '',
                        'start_date' => isset($edu['start_date']) ? Carbon::parse($edu['start_date']) : null,
                        'end_date' => isset($edu['end_date']) ? Carbon::parse($edu['end_date']) : null,
                        'candidate_id' => $candidate->id,
                    ]);
                }
            } elseif (!empty($educationData)) {
                foreach ($educationData as $edu) {
                    $startDate = null;
                    $endDate = null;
                    try {
                        $startDate = Carbon::parse($edu['start_date'] ?? '')->toDateString();
                        $endDate = Carbon::parse($edu['end_date'] ?? '')->toDateString();
                    } catch (Exception $e) {
                        // Bỏ qua lỗi định dạng ngày tháng
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
            
            // Thêm thông tin kinh nghiệm làm việc từ form hoặc CV
            if ($request->has('experiences') && !empty($request->input('experiences'))) {
                foreach ($request->input('experiences') as $exp) {
                    Experience::create([
                        'company_name' => $exp['company_name'] ?? '',
                        'position' => $exp['position'] ?? '',
                        'summary' => $exp['summary'] ?? '',
                        'start_date' => isset($exp['start_date']) ? Carbon::parse($exp['start_date']) : null,
                        'end_date' => isset($exp['end_date']) ? Carbon::parse($exp['end_date']) : null,
                        'candidate_id' => $candidate->id,
                    ]);
                }
            } elseif (!empty($workExperienceData)) {
                foreach ($workExperienceData as $workExperience) {
                    $startDate = null;
                    $endDate = null;
                    try {
                        $startDate = Carbon::parse($workExperience['start_date'] ?? '')->toDateString();
                        $endDate = Carbon::parse($workExperience['end_date'] ?? '')->toDateString();
                    } catch (Exception $e) {
                        // Bỏ qua lỗi định dạng ngày tháng
                    }

                    Experience::create([
                        'company_name' => $workExperience['company_name'] ?? 'Unknown Company',
                        'position' => $workExperience['position'] ?? 'Unknown Position',
                        'summary' => $workExperience['summary'] ?? 'No details provided',
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'candidate_id' => $candidate->id,
                    ]);
                }
            }

            // Tạo liên kết giữa candidate, job và stage
            // Đánh dấu tất cả các candidate_job cũ là không active
            CandidateJob::where('candidate_id', $candidate->id)
                ->where('job_id', $job->id)
                ->update(['is_active' => false]);
                
            // Tạo candidate_job mới
            $job->candidateJobs()->create([
                'candidate_id' => $candidate->id,
                'job_id' => $job->id,
                'stage_id' => $stage->id,
                'is_active' => true,
            ]);

            DB::commit();
            
            return response()->json([
                'message' => 'Đã thêm ứng viên vào stage thành công',
                'data' => CandidateResource::make($candidate->load([
                    'user', 
                    'education', 
                    'experiences', 
                    'currentCandidateJob.stage',
                    'currentCandidateJob.job'
                ])),
            ]);
            
        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Add Candidate To Stage Error: ' . $e->getMessage());
            
            // Kiểm tra nếu lỗi liên quan đến GenAI
            if (strpos($e->getMessage(), 'generativelanguage.googleapis.com') !== false) {
                return response()->json([
                    'message' => 'Hệ thống hiện không thể phân tích CV. CV đã được lưu nhưng cần cập nhật thông tin thủ công.',
                    'errors' => ['resume' => ['Dịch vụ phân tích CV đang bận, vui lòng thử lại sau.']]
                ], 503);
            }
            
            return response()->json([
                'message' => 'Có lỗi xảy ra khi thêm ứng viên vào stage',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 
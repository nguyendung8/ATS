<?php

namespace App\Http\Controllers;

use App\Http\Requests\Job\JobRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Repositories\Job\JobRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function response;

class JobController extends Controller
{
    protected JobRepositoryInterface $jobRepository;

    public function __construct(JobRepositoryInterface $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Job::class);

        $queries = $request->query();
        $jobs = $this->jobRepository->queryAllByConditions($queries, [
            'pipeline',
            'tags',
        ]);

        return JobResource::collection($jobs);
    }

    public function store(JobRequest $request)
    {
        $this->authorize('create', Job::class);

        try {
            DB::beginTransaction();

            $job = $this->jobRepository->create([
                'name' => $request->input('name'),
                'country' => $request->input('country'),
                'city' => $request->input('city'),
                'employment_type' => $request->input('employmentType'),
                'min_offer' => $request->input('minOffer'),
                'max_offer' => $request->input('maxOffer'),
                'currency' => $request->input('currency'),
                'deadline' => $request->input('deadline'),
                'description' => $request->input('description'),
                'requirement' => $request->input('requirement'),
                'benefit' => $request->input('benefit'),
                'status' => $request->input('status'),
                'pipeline_id' => $request->input('pipelineId'),
            ]);

            DB::commit();

            return JobResource::make($job);
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    public function show(Job $job)
    {
        $this->authorize('view', $job);

        return JobResource::make($job);
    }

    public function update(Request $request, Job $job)
    {
        $this->authorize('update', $job);

        try {
            DB::beginTransaction();

            $job->update([
                'name' => $request->input('name'),
                'country' => $request->input('country'),
                'city' => $request->input('city'),
                'employment_type' => $request->input('employmentType'),
                'min_offer' => $request->input('minOffer'),
                'max_offer' => $request->input('maxOffer'),
                'currency' => $request->input('currency'),
                'deadline' => $request->input('deadline'),
                'description' => $request->input('description'),
                'requirement' => $request->input('requirement'),
                'benefit' => $request->input('benefit'),
                'status' => $request->input('status'),
                'pipeline_id' => $request->input('pipelineId'),
            ]);

            DB::commit();

            return JobResource::make($job);
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);

        return $job->delete();
    }

    public function getAppliedJobs(int $candidateId)
    {
        $jobs = $this->jobRepository->getAppliedJobs($candidateId);

        return response()->json([
            'data' => $jobs,
        ]);
    }
}

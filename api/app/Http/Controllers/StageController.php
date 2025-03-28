<?php

namespace App\Http\Controllers;

use App\Http\Requests\Stage\StageRequest;
use App\Http\Resources\StageResource;
use App\Models\Stage;
use App\Repositories\Stage\StageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StageController extends Controller
{
    protected StageRepositoryInterface $stageRepository;

    public function __construct(StageRepositoryInterface $stageRepository)
    {
        $this->stageRepository = $stageRepository;
    }

    public function index()
    {
//        $this->authorize('viewAny', Stage::class);

        return StageResource::collection($this->stageRepository->getAll());
    }

    public function store(StageRequest $request)
    {
        $this->authorize('create', Stage::class);

        $existed = $this->stageRepository->findByConditions([
            'type' => Str::slug($request->input('name')),
        ])->exists();
        abort_if($existed, 500, 'This stage has already existed!');

        $stage = $this->stageRepository->create([
            'name' => $request->input('name'),
            'is_active' => 1,
        ]);

        return StageResource::make($stage);
    }

    public function update(Request $request, Stage $stage)
    {
        $this->authorize('update', $stage);
    }

    public function destroy(Stage $stage)
    {
        $this->authorize('delete', $stage);
        $stage->pipelineStages()->delete();

        return $stage->delete();
    }
}

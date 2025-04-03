<?php

namespace App\Http\Controllers\Job;

use App\Enums\Job\JobStatus;
use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use ONGR\ElasticsearchDSL\Query\TermLevel\FuzzyQuery;

class GetPublishedJobNameController extends Controller
{
    public function __invoke(Request $request)
    {
        $jobNames = [];
        $name = $request->query('name');

        if ($name) {
            $jobNames = Job::where('status', JobStatus::PUBLISHED)
                ->where('name', 'LIKE', '%' . $name . '%')
                ->pluck('name')
                ->unique()
                ->toArray();
        }

        return response()->json(['data' => $jobNames]);
    }
}

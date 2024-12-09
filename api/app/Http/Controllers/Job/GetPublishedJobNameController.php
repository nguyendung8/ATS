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
            $searchResult = Job::search(JobStatus::PUBLISHED, function($client, $body) use ($name) {
                $fuzzyQuery = new FuzzyQuery(
                    'name',
                    $name,
                    [
                        'boost' => 1,
                        'fuzziness' => 2,
                        'prefix_length' => 0,
                        'max_expansions' => 100,
                    ]
                );
                $body->addQuery($fuzzyQuery);

                return $client->search(['index' => 'jobs', 'body' => $body->toArray()]);
            })->raw();

            foreach ($searchResult['hits']['hits'] as $result) {
                $jobNames[] = $result['_source']['name'];
            }
        }

        return response()->json(['data' => array_unique($jobNames)]);
    }
}

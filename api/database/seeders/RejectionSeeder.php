<?php

namespace Database\Seeders;

use App\Models\Rejection;
use Illuminate\Database\Seeder;

class RejectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rejection::truncate();

        $rejections = [
            'Candidate Withdrew',
            'Choose another candidate',
            'Expect too high salary for rank',
            'Fail HR/ Not a culture fit',
            'Lacking skill(s)/qualification(s)',
            'Move to another job',
            'Not available now',
            'Position Closed',
            'Reject offer',
            'Reject Offer (Due to responsibility in current company)',
            'Reject Offer (Not fit with Sun* development orientation - culture)',
            'Reject Offer (Offer is lower than expect)',
            'Reject Offer (Personal reason)',
            'Spam',
            'Unable to contact',
        ];

        foreach ($rejections as $rejection) {
            Rejection::create([
                'reason' => $rejection,
                'mail_template_id' => 6,
            ]);
        }
    }
}

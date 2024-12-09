<?php

namespace Database\Seeders;

use App\Enums\Action\ActionType;
use App\Models\Action;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Action::truncate();

        Action::create([
            'name' => 'Reject candidate',
            'type' => ActionType::REJECT_CANDIDATE,
            'options' => [
                'is_send_mail' => false,
            ],
        ]);
    }
}

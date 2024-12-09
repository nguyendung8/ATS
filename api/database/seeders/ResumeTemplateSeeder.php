<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\ResumeTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ResumeTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ResumeTemplate::truncate();

        ResumeTemplate::create([
            'name' => 'Template1',
            'image_url' => 'http://localhost:3000/images/template1.png',
        ]);

        ResumeTemplate::create([
            'name' => 'Template2',
            'image_url' => 'http://localhost:3000/images/template2.png',
        ]);
    }
}

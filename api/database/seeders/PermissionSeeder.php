<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        Role::truncate();

        $role = Role::create(['name' => 'Recruitment director']);
        $user = User::find(1);
        $user->assignRole('Recruitment director');

        $permissions = [
            \App\Enums\Permission::MANAGE_INTERVIEW_SCHEDULE,
            \App\Enums\Permission::VIEW_INTERVIEW_SCHEDULE,
            \App\Enums\Permission::MANAGE_PIPELINE,
            \App\Enums\Permission::VIEW_PIPELINE,
            \App\Enums\Permission::MANAGE_CANDIDATE,
            \App\Enums\Permission::MANAGE_JOB,
            \App\Enums\Permission::MANAGE_ASSESSMENT_FORM,
            \App\Enums\Permission::MANAGE_PERMISSION,
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $role->syncPermissions($permissions);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

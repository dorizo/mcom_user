<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            [
                'id' => 1,
                'title' => 'task_create',
            ],
            [
                'id' => 2,
                'title' => 'task_edit',
            ],
            [
                'id' => 3,
                'title' => 'task_destroy',
            ],
        ];
        Permission::insert($permissions);
    }
}

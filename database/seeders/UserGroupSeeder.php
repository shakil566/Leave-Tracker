<?php

namespace Database\Seeders;

use App\Models\UserGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_group')->delete();

        $users = [
            ['id' => 1, 'title' => 'Admin'],
            ['id' => 2, 'title' => 'Employee']
        ];

        UserGroup::insert($users);
    }
}

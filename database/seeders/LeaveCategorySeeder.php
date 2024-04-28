<?php

namespace Database\Seeders;

use App\Models\LeaveCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('leave_category')->delete();

        $projects = [
            ['id' => 1, 'title' => 'Casual Leave', 'description' => 'For Casual Leave'],
            ['id' => 2, 'title' => 'Sick Leave', 'description' => 'For Sick Leave'],
            ['id' => 3, 'title' => 'Emergency Leave', 'description' => 'For Emergency Leave'],
            ['id' => 4, 'title' => 'Others', 'description' => 'Others Reason'],
        ];

        LeaveCategory::insert($projects);
    }
}

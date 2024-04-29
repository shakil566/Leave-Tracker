<?php

namespace Database\Seeders;

use App\Models\LeaveManagement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('leave_management')->delete();
        $tasks = [
            ['id' => 1, 'title' => 'Leave Application 1', 'leave_category_id' => '1','start_date' => '2024-05-01', 'end_date' => '2024-05-07', 'employee_id' => '3', 'description' => 'Leave description 1'],
            ['id' => 2, 'title' => 'Leave Application 2', 'leave_category_id' => '1','start_date' => '2024-04-03', 'end_date' => '2024-04-07', 'employee_id' => '4', 'description' => 'Leave description 2'],
            ['id' => 3, 'title' => 'Leave Application 3', 'leave_category_id' => '2','start_date' => '2024-05-06', 'end_date' => '2024-05-07', 'employee_id' => '5', 'description' => 'Leave description 3'],
            ['id' => 4, 'title' => 'Leave Application 4', 'leave_category_id' => '2','start_date' => '2024-05-11', 'end_date' => '2024-05-13', 'employee_id' => '4', 'description' => 'Leave description 4'],
            ['id' => 5, 'title' => 'Leave Application 5', 'leave_category_id' => '3','start_date' => '2024-05-22', 'end_date' => '2024-05-25', 'employee_id' => '3', 'description' => 'Leave description 5'],
        ];

        LeaveManagement::insert($tasks);
    }
}

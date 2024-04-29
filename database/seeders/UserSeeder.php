<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        $users = [
            ['id' => 1, 'name' => 'Admin', 'user_group_id' => '1', 'status' => '1', 'employee_id' => 'admin123', 'email' => 'admin@gmail.com', 'password' => bcrypt('Admin123@')],
            ['id' => 2, 'name' => 'Manager', 'user_group_id' => '1', 'status' => '1', 'employee_id' => 'manager123', 'email' => 'manager@gmail.com', 'password' => bcrypt('Admin123@')],
            ['id' => 3, 'name' => 'Shakil', 'user_group_id' => '2', 'status' => '1', 'employee_id' => 'shakil123', 'email' => 'shakils923@gmail.com', 'password' => bcrypt('Admin123@')],
            ['id' => 4, 'name' => 'Selim', 'user_group_id' => '2', 'status' => '1', 'employee_id' => 'selim123', 'email' => 'shakilhossen566@gmail.com', 'password' => bcrypt('Admin123@')],
            ['id' => 5, 'name' => 'Sagor', 'user_group_id' => '2', 'status' => '1', 'employee_id' => 'selim123', 'email' => 'shakil923@gmail.com', 'password' => bcrypt('Admin123@')],
        ];

        User::insert($users);
    }
}

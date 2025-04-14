<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            ['id' => 1, 'name' => 'Manager', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Supervisor', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Staff', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Assistant', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

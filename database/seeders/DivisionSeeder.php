<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::create([
            'name' => 'Human Resources'
        ]);

        Division::create([
            'name' => 'Finance'
        ]);

        Division::create([
            'name' => 'Information Technology'
        ]);

        Division::create([
            'name' => 'Operations'
        ]);

        Division::create([
            'name' => 'Marketing'
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            [
                'name' => 'Ahmed Ali',
                'level' => '4', 
                'intelligence_level_status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sara Ahmed',
                'level' => '5',
                'intelligence_level_status' => 'failed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mohamed Salah',
                'level' =>'6',
                'intelligence_level_status' => 'failed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
}
}

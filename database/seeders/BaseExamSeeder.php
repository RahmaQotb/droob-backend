<?php

namespace Database\Seeders;

use App\Models\BaseExam;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BaseExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BaseExam::create([
            "name"=>"white"
        ]);
        BaseExam::create([
            "name"=>"blue"
        ]);
    }
}

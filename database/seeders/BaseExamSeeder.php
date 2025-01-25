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
            "id"=>1,
            "name"=>"الجانب النمائي"
        ]);
        BaseExam::create([
            "id"=>2,
            "name"=>"الجانب الأكاديمي"
        ]);
        BaseExam::create([
            "id"=>3,
            "name"=>"الجانب الجسدي"
        ]);
        BaseExam::create([
            "id"=>4,
            "name"=>"الجانب الانفعالي"
        ]);
        BaseExam::create([
            "id"=>5,
            "name"=>"الجانب الأسري"
        ]);
        BaseExam::create([
            "id"=>6,
            "name"=>"التفاعل الاجتماعي"
        ]);
    }
}

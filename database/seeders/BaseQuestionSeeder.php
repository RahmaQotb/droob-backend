<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaseQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            // الجانب النمائي
            ['question' => 'ينسى ما يوجه له من تعليمات.', 'base_exam_id' => 1],
            ['question' => 'مستوى ذكائه متوسط فما فوق.', 'base_exam_id' => 1],
            ['question' => 'ينتبه لعدد محدود من المعلومات المقدمة إليه.', 'base_exam_id' => 1],
            ['question' => 'يتشتت انتباهه بسرعة.', 'base_exam_id' => 1],
            ['question' => 'لا يدرك ما يوجه إليه من تعليمات بصورة صحيحة.', 'base_exam_id' => 1],

            // الجانب الأكاديمي
            ['question' => 'يعاني من عدم القدرة على إدراك تسلسل الأشياء المقدمة إليه.', 'base_exam_id' => 2],
            ['question' => 'كثير شطب ما يقوم بكتابته.', 'base_exam_id' => 2],
            ['question' => 'خطه سيء.', 'base_exam_id' => 2],
            ['question' => 'لا ينخفض تحصيله في جميع المواد الدراسية.', 'base_exam_id' => 2],
            ['question' => 'يتمتع بالكفاءة في التعلم.', 'base_exam_id' => 2],
            ['question' => 'يحتاج إلى فنيات وإستراتيجيات في عملية التعلم.', 'base_exam_id' => 2],

            // الجانب الجسدي
            ['question' => 'لا يعاني من إعاقة بصرية.', 'base_exam_id' => 3],
            ['question' => 'يتمتع بصحة جيدة.', 'base_exam_id' => 3],
            ['question' => 'ليس لديه عجز سمعي.', 'base_exam_id' => 3],
            ['question' => 'يتمتع بسلامة الأجهزة البدنية وأعضاء الحركة.', 'base_exam_id' => 3],
            ['question' => 'لا يعاني من أمراض مزمنة.', 'base_exam_id' => 3],

            // الجانب الانفعالي
            ['question' => 'التلميذ لديه اضطرابات انفعالية شديدة.', 'base_exam_id' => 4],
            ['question' => 'لديه شعور بنقص الثقة بالنفس.', 'base_exam_id' => 4],
            ['question' => 'دائما يشعر بالإحساس بالفشل.', 'base_exam_id' => 4],
            ['question' => 'يشعر بأنه أقل من أقرانه.', 'base_exam_id' => 4],
            ['question' => 'لديه انخفاض في تقدير الذات.', 'base_exam_id' => 4],

            // الجانب الأسري
            ['question' => 'يعاني التلميذ من فقر شديد.', 'base_exam_id' => 5],
            ['question' => 'يعاني التلميذ من مشكلات أسرية حادة.', 'base_exam_id' => 5],
            ['question' => 'يتغيب الوالدان أو أحدهما بسبب الوفاة.', 'base_exam_id' => 5],
            ['question' => 'يتغيب الوالدان أو أحدهما بسبب السفر.', 'base_exam_id' => 5],
            ['question' => 'يعيش التلميذ حياة أسرية هادئة.', 'base_exam_id' => 5],

            // التفاعل الاجتماعي
            ['question' => 'لا يشارك أحدا أثناء تواجده داخل الفصل الدراسي.', 'base_exam_id' => 6],
            ['question' => 'يفضل العمل التعاوني مع أقرانه.', 'base_exam_id' => 6],
            ['question' => 'ينعزل عن الآخرين.', 'base_exam_id' => 6],
        ];

        // إدخال البيانات في الجدول
        DB::table('base_questions')->insert($questions);
    
    }
}

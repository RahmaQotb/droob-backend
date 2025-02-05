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
            ['question' => 'يتذكر ما يوجه له من تعليمات.', 'base_exam_id' => 1],
            ['question' => 'مستوى ذكائه متوسط فما فوق.', 'base_exam_id' => 1],
            ['question' => 'ينتبه لعدد كبير من المعلومات المقدمة إليه.', 'base_exam_id' => 1],
            ['question' => 'لا يتشتت انتباهه بسرعة.', 'base_exam_id' => 1],
            ['question' => ' يدرك ما يوجه إليه من تعليمات بصورة صحيحة.', 'base_exam_id' => 1],

            // الجانب الأكاديمي (مُكتمل الآن)
            ['question' => 'لا يعاني من عدم القدرة على إدراك تسلسل الأشياء المقدمة إليه.', 'base_exam_id' => 2],
            ['question' => 'ليس كثير الشطب لما يقوم بكتابته.', 'base_exam_id' => 2],
            ['question' => 'خطه جيد.', 'base_exam_id' => 2],
            ['question' => 'لا ينخفض تحصيله في جميع المواد الدراسية.', 'base_exam_id' => 2],
            ['question' => 'يتمتع بالكفاءة في التعلم.', 'base_exam_id' => 2],
            ['question' => 'لا يحتاج إلى فنيات واستراتيجيات في عملية التعلم.', 'base_exam_id' => 2],
            ['question' => 'ليس صعوبة في استخدام اللغة المنطوقة أو المقروءة.', 'base_exam_id' => 2],
            ['question' => 'ليس لديه صعوبة في فهم ما يقرأ.', 'base_exam_id' => 2],
            ['question' => 'ليس هناك تفاوت في مستواه التحصيلي.', 'base_exam_id' => 2],
            ['question' => 'يتمتع بفرص تعليمية مناسبة.', 'base_exam_id' => 2],
            ['question' => 'لا يعاني من حرمان ثقافي.', 'base_exam_id' => 2],
            ['question' => 'ليس هناك فرق واضح بين تحصيله الفعلي والمتوقع.', 'base_exam_id' => 2],
            ['question' => ' قادر على تحديد الاتجاهات المكانية (فوق - تحت) (يمين - يسار).', 'base_exam_id' => 2],
            ['question' => 'أداؤه ليس متغير من فترة لأخرى.', 'base_exam_id' => 2],
            ['question' => 'ليس لديه خلط واضح في تعرف الحروف الهجائية.', 'base_exam_id' => 2],
            ['question' => ' يفهم ما يقرأه بشكل كامل وسليم.', 'base_exam_id' => 2],
            ['question' => ' يستكمل واجباته المدرسية.', 'base_exam_id' => 2],
            ['question' => 'لديه مستوى قرائي سريع.', 'base_exam_id' => 2],
            ['question' => 'دائمًا يتذكر أشياءه وأدواته المدرسية.', 'base_exam_id' => 2],
            ['question' => ' لديه القدرة على التعبير عن نفسه كتابيًا أو شفهيًا.', 'base_exam_id' => 2],

            // الجانب الجسدي
            ['question' => 'لا يعاني من إعاقة بصرية.', 'base_exam_id' => 3],
            ['question' => 'يتمتع بصحة جيدة.', 'base_exam_id' => 3],
            ['question' => 'ليس لديه عجز سمعي.', 'base_exam_id' => 3],
            ['question' => 'يتمتع بسلامة الأجهزة البدنية وأعضاء الحركة.', 'base_exam_id' => 3],
            ['question' => 'لا يعاني من أمراض مزمنة.', 'base_exam_id' => 3],

            // الجانب الانفعالي (إضافة الأسئلة الناقصة)
            ['question' => 'نادرا ما يشعر بالتوتر والقلق.', 'base_exam_id' => 4],
            ['question' => 'لديه مفهوم ذات إيجابي نحو نفسه.', 'base_exam_id' => 4],
            ['question' => ' يحب التواصل مع الآخرين.', 'base_exam_id' => 4],
            ['question' => 'قليل التشاجر مع زملائه.', 'base_exam_id' => 4],
            ['question' => 'ليس لديه نقص الدافعية للتعلم.', 'base_exam_id' => 4],

            // الجانب الأسري
            ['question' => 'لا يعاني التلميذ من فقر شديد.', 'base_exam_id' => 5],
            ['question' => 'لا يعاني التلميذ من مشكلات أسرية حادة.', 'base_exam_id' => 5],
            ['question' => 'لا يتغيب الوالدان أو أحدهما بسبب الوفاة.', 'base_exam_id' => 5],
            ['question' => 'لا يتغيب الوالدان أو أحدهما بسبب السفر.', 'base_exam_id' => 5],
            ['question' => 'يعيش التلميذ حياة أسرية هادئة.', 'base_exam_id' => 5],

            // التفاعل الاجتماعي (إضافة الأسئلة الناقصة)
            ['question' => ' يشارك أحدًا أثناء تواجده داخل الفصل الدراسي.', 'base_exam_id' => 6],
            ['question' => 'يفضل العمل التعاوني مع أقرانه.', 'base_exam_id' => 6],
            ['question' => 'لا ينعزل عن الآخرين.', 'base_exam_id' => 6],
        ];

        // إدخال البيانات في الجدول
        DB::table('base_questions')->insert($questions);
    }
}

@extends('Dashboard.layouts.layouts')

@section('title')
إنشاء امتحان مبني على قطعة نصية
@endsection

@section('content')
@section('css')
    <link rel="stylesheet" href="{{ asset('Dashboard/assets/compiled/css/table-datatable.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #1e1e2f; /* Dark background */
            color: #f8f9fa; /* Light text */
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            background-color: #2d2d44; /* Dark card background */
            border: 1px solid #444;
        }
        .card-header {
            background-color: #4a90e2;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .question, .answer {
            background-color: #3d3d5a; /* Darker background for questions/answers */
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #555;
        }
        .add-question-btn, .add-answer-btn {
            margin-top: 10px;
        }
        .form-group label {
            font-weight: 600;
            color: #f8f9fa; /* Light text for labels */
        }
        .form-control {
            border-radius: 5px;
            background-color: #3d3d5a; /* Dark input background */
            color: #f8f9fa; /* Light text for inputs */
            border: 1px solid #555;
        }
        .form-control:focus {
            background-color: #4d4d6a; /* Slightly lighter on focus */
            border-color: #4a90e2;
            color: #f8f9fa;
        }
        .remove-question, .remove-answer {
            float: right;
            margin-top: -10px;
        }
        .passage-questions {
            margin-left: 20px;
            border-left: 2px solid #4a90e2;
            padding-left: 20px;
        }
        .btn-left {
            float: left;
            margin-right: 10px;
        }
        /* تعديل جديد لوضع زر إضافة إجابة جديدة */
        .add-answer-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-top: 10px;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('Dashboard/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('Dashboard/assets/static/js/pages/simple-datatables.js') }}"></script>
@endsection

<div class="page-heading">
    <h3>إنشاء امتحان مبني على قطعة نصية</h3>
</div>

@include('messages.errors')
@include('messages.success')

<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="fas fa-plus-circle"></i> إضافة امتحان مبني على قطعة نصية
            </h5>
        </div>
        <div class="card-body">
            <!-- نموذج إنشاء الامتحان -->
            <form action="{{ route('exams.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="passage_based"> <!-- نوع الامتحان -->

                <div class="form-group mb-4">
                    <label for="name"><i class="fas fa-book"></i> اسم الامتحان:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="form-group mb-4">
                    <label for="subject_id"><i class="fas fa-book-open"></i> المادة الدراسية:</label>
                    <select name="subject_id" id="subject_id" class="form-control" required>
                        <option value="">اختر المادة الدراسية</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- قسم القطعة النصية -->
                <div class="form-group mb-4">
                    <label for="passage_text"><i class="fas fa-pencil-alt"></i> نص القطعة النصية:</label>
                    <textarea name="passage_text" class="form-control" rows="5" required>{{ old('passage_text') }}</textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="passage_image"><i class="fas fa-image"></i> صورة القطعة النصية (اختياري):</label>
                    <input type="file" name="passage_image" class="form-control">
                </div>

                <!-- قسم الأسئلة الفرعية -->
                <div id="passage-questions-section">
                    <h5 class="mt-4 mb-3"><i class="fas fa-question-circle"></i> إضافة الأسئلة الفرعية</h5>
                    <div class="sub-question">
                        <button type="button" class="btn btn-danger btn-sm remove-sub-question btn-left"><i class="fas fa-trash"></i> حذف السؤال الفرعي</button>
                        <div class="form-group">
                            <label for="sub_question_text"><i class="fas fa-pencil-alt"></i> نص السؤال الفرعي:</label>
                            <input type="text" name="passage_questions[0][text]" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="sub_question_image"><i class="fas fa-image"></i> صورة السؤال الفرعي (اختياري):</label>
                            <input type="file" name="passage_questions[0][image]" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="sub_question_type"><i class="fas fa-list"></i> نوع السؤال الفرعي:</label>
                            <select name="passage_questions[0][type]" class="form-control" required>
                                <option value="mcq">اختيار من متعدد</option>
                                <option value="true_false">صح/خطأ</option>
                                <option value="ordering">ترتيب</option>
                            </select>
                        </div>
                        <div class="answers-section">
                            <h6><i class="fas fa-list-ol"></i> إضافة الإجابات</h6>
                            <div class="answer">
                                <div class="form-group">
                                    <label for="answer_text"><i class="fas fa-pencil-alt"></i> نص الإجابة:</label>
                                    <input type="text" name="passage_questions[0][answers][0][text]" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="answer_image"><i class="fas fa-image"></i> صورة الإجابة (اختياري):</label>
                                    <input type="file" name="passage_questions[0][answers][0][image]" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="is_correct"><i class="fas fa-check-circle"></i> هل الإجابة صحيحة؟</label>
                                    <select name="passage_questions[0][answers][0][is_correct]" class="form-control" required>
                                        <option value="0">خطأ</option>
                                        <option value="1">صح</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm remove-answer btn-left"><i class="fas fa-trash"></i> حذف الإجابة</button>
                            </div>
                        </div>
                        <!-- زر إضافة إجابة جديدة -->
                        <div class="add-answer-container">
                            <button type="button" class="btn btn-secondary btn-sm add-sub-answer btn-left"><i class="fas fa-plus"></i> إضافة إجابة جديدة</button>
                        </div>
                    </div>
                </div>

                <!-- زر إضافة سؤال فرعي جديد -->
                <button type="button" id="add-sub-question" class="btn btn-secondary mt-3 add-question-btn btn-left"><i class="fas fa-plus"></i> إضافة سؤال فرعي</button>

                <!-- زر إنشاء الامتحان -->
                <button type="submit" class="btn btn-success mt-4"><i class="fas fa-save"></i> إنشاء الامتحان</button>
            </form>
        </div>
    </div>
</section>

<!-- JavaScript لإدارة الأسئلة الفرعية والإجابات -->
<script>
    let subQuestionIndex = 1;
    let subAnswerIndex = 1;

    // دالة لتحديث حقول الإجابة بناءً على نوع السؤال
    function updateAnswerFields(questionDiv) {
        const questionType = questionDiv.querySelector('select[name$="[type]"]').value;
        const answersSection = questionDiv.querySelector('.answers-section');

        // مسح الحقول القديمة
        answersSection.innerHTML = '';

        if (questionType === 'ordering') {
            // حقول الترتيب
            answersSection.innerHTML = `
                <h6><i class="fas fa-list-ol"></i> إضافة الإجابات مع الترتيب</h6>
                <div class="answer">
                    <div class="form-group">
                        <label for="answer_text"><i class="fas fa-pencil-alt"></i> نص الإجابة:</label>
                        <input type="text" name="passage_questions[${subQuestionIndex - 1}][answers][0][text]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="answer_order"><i class="fas fa-sort-numeric-down"></i> الترتيب الصحيح:</label>
                        <input type="number" name="passage_questions[${subQuestionIndex - 1}][answers][0][order]" class="form-control" min="1" required>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-answer btn-left"><i class="fas fa-trash"></i> حذف الإجابة</button>
                </div>
            `;
        } else {
            // حقول الاختيار من متعدد أو صح/خطأ
            answersSection.innerHTML = `
                <h6><i class="fas fa-list-ol"></i> إضافة الإجابات</h6>
                <div class="answer">
                    <div class="form-group">
                        <label for="answer_text"><i class="fas fa-pencil-alt"></i> نص الإجابة:</label>
                        <input type="text" name="passage_questions[${subQuestionIndex - 1}][answers][0][text]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="answer_image"><i class="fas fa-image"></i> صورة الإجابة (اختياري):</label>
                        <input type="file" name="passage_questions[${subQuestionIndex - 1}][answers][0][image]" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="is_correct"><i class="fas fa-check-circle"></i> هل الإجابة صحيحة؟</label>
                        <select name="passage_questions[${subQuestionIndex - 1}][answers][0][is_correct]" class="form-control" required>
                            <option value="0">خطأ</option>
                            <option value="1">صح</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-answer btn-left"><i class="fas fa-trash"></i> حذف الإجابة</button>
                </div>
            `;
        }
    }

    // إضافة سؤال فرعي جديد
    document.getElementById('add-sub-question').addEventListener('click', function() {
        const passageQuestionsSection = document.getElementById('passage-questions-section');
        const newSubQuestion = document.createElement('div');
        newSubQuestion.classList.add('sub-question', 'mt-4');
        newSubQuestion.innerHTML = `
            <button type="button" class="btn btn-danger btn-sm remove-sub-question btn-left"><i class="fas fa-trash"></i> حذف السؤال الفرعي</button>
            <div class="form-group">
                <label for="sub_question_text"><i class="fas fa-pencil-alt"></i> نص السؤال الفرعي:</label>
                <input type="text" name="passage_questions[${subQuestionIndex}][text]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="sub_question_image"><i class="fas fa-image"></i> صورة السؤال الفرعي (اختياري):</label>
                <input type="file" name="passage_questions[${subQuestionIndex}][image]" class="form-control">
            </div>
            <div class="form-group">
                <label for="sub_question_type"><i class="fas fa-list"></i> نوع السؤال الفرعي:</label>
                <select name="passage_questions[${subQuestionIndex}][type]" class="form-control" required>
                    <option value="mcq">اختيار من متعدد</option>
                    <option value="true_false">صح/خطأ</option>
                    <option value="ordering">ترتيب</option>
                </select>
            </div>
            <div class="answers-section">
                <h6><i class="fas fa-list-ol"></i> إضافة الإجابات</h6>
            </div>
            <!-- زر إضافة إجابة جديدة -->
            <div class="add-answer-container">
                <button type="button" class="btn btn-secondary btn-sm add-sub-answer btn-left"><i class="fas fa-plus"></i> إضافة إجابة جديدة</button>
            </div>
        `;
        passageQuestionsSection.appendChild(newSubQuestion);
        subQuestionIndex++;
    });

    // إضافة إجابة جديدة للسؤال الفرعي
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('add-sub-answer')) {
            const subQuestionDiv = e.target.closest('.sub-question');
            const answersSection = subQuestionDiv.querySelector('.answers-section');
            const questionType = subQuestionDiv.querySelector('select[name$="[type]"]').value;

            const newAnswer = document.createElement('div');
            newAnswer.classList.add('answer', 'mt-3');

            if (questionType === 'ordering') {
                // حقول الترتيب
                newAnswer.innerHTML = `
                    <div class="form-group">
                        <label for="answer_text"><i class="fas fa-pencil-alt"></i> نص الإجابة:</label>
                        <input type="text" name="passage_questions[${subQuestionIndex - 1}][answers][${subAnswerIndex}][text]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="answer_order"><i class="fas fa-sort-numeric-down"></i> الترتيب الصحيح:</label>
                        <input type="number" name="passage_questions[${subQuestionIndex - 1}][answers][${subAnswerIndex}][order]" class="form-control" min="1" required>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-answer btn-left"><i class="fas fa-trash"></i> حذف الإجابة</button>
                `;
            } else {
                // حقول الاختيار من متعدد أو صح/خطأ
                newAnswer.innerHTML = `
                    <div class="form-group">
                        <label for="answer_text"><i class="fas fa-pencil-alt"></i> نص الإجابة:</label>
                        <input type="text" name="passage_questions[${subQuestionIndex - 1}][answers][${subAnswerIndex}][text]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="answer_image"><i class="fas fa-image"></i> صورة الإجابة (اختياري):</label>
                        <input type="file" name="passage_questions[${subQuestionIndex - 1}][answers][${subAnswerIndex}][image]" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="is_correct"><i class="fas fa-check-circle"></i> هل الإجابة صحيحة؟</label>
                        <select name="passage_questions[${subQuestionIndex - 1}][answers][${subAnswerIndex}][is_correct]" class="form-control" required>
                            <option value="0">خطأ</option>
                            <option value="1">صح</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-answer btn-left"><i class="fas fa-trash"></i> حذف الإجابة</button>
                `;
            }

            answersSection.appendChild(newAnswer);
            subAnswerIndex++;
        }
    });

    // حذف سؤال فرعي أو إجابة
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-sub-question')) {
            e.target.closest('.sub-question').remove();
        }
        if (e.target && e.target.classList.contains('remove-answer')) {
            e.target.closest('.answer').remove();
        }
    });

    // تحديث حقول الإجابة عند تغيير نوع السؤال
    document.addEventListener('change', function(e) {
        if (e.target && e.target.name.includes('[type]')) {
            const questionDiv = e.target.closest('.sub-question');
            updateAnswerFields(questionDiv);
        }
    });
</script>
@endsection
@extends('Dashboard.layouts.layouts')

@section('title')
إنشاء امتحان جديد
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
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('Dashboard/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('Dashboard/assets/static/js/pages/simple-datatables.js') }}"></script>
@endsection

<div class="page-heading">
    <h3>إنشاء امتحان جديد</h3>
</div>

@include('messages.errors')
@include('messages.success')

<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="fas fa-plus-circle"></i> إضافة امتحان جديد
            </h5>
        </div>
        <div class="card-body">
            <!-- نموذج إنشاء الامتحان -->
            <form action="{{ route('exams.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
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

                <!-- قسم إضافة الأسئلة -->
                <div id="questions-section">
                    <h5 class="mt-4 mb-3"><i class="fas fa-question-circle"></i> إضافة الأسئلة</h5>
                    <div class="question">
                        <button type="button" class="btn btn-danger btn-sm remove-question"><i class="fas fa-trash"></i> حذف السؤال</button>
                        <div class="form-group">
                            <label for="question_text"><i class="fas fa-pencil-alt"></i> نص السؤال:</label>
                            <input type="text" name="questions[0][text]" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="question_type"><i class="fas fa-list"></i> نوع السؤال:</label>
                            <select name="questions[0][type]" class="form-control question-type" required>
                                <option value="mcq">اختيار من متعدد</option>
                                <option value="true_false">صح/خطأ</option>
                                <option value="ordering">ترتيب</option>
                                <option value="passage">نص (Passage)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="question_image"><i class="fas fa-image"></i> صورة السؤال (اختياري):</label>
                            <input type="file" name="questions[0][image]" class="form-control">
                        </div>

                        <!-- قسم إضافة الإجابات (لأسئلة غير النصية) -->
                        <div class="answers-section" data-question-type="mcq">
                            <h6><i class="fas fa-list-ol"></i> إضافة الإجابات</h6>
                            <div class="answer">
                                <div class="form-group">
                                    <label for="answer_text"><i class="fas fa-pencil-alt"></i> نص الإجابة:</label>
                                    <input type="text" name="questions[0][answers][0][text]" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="answer_image"><i class="fas fa-image"></i> صورة الإجابة (اختياري):</label>
                                    <input type="file" name="questions[0][answers][0][image]" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="is_correct"><i class="fas fa-check-circle"></i> هل الإجابة صحيحة؟</label>
                                    <select name="questions[0][answers][0][is_correct]" class="form-control" required>
                                        <option value="0">خطأ</option>
                                        <option value="1">صح</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm remove-answer"><i class="fas fa-trash"></i> حذف الإجابة</button>
                            </div>
                        </div>

                        <!-- زر إضافة إجابة جديدة (لأسئلة غير النصية) -->
                        <button type="button" class="btn btn-secondary btn-sm add-answer add-answer-btn" data-question-type="mcq"><i class="fas fa-plus"></i> إضافة إجابة جديدة</button>

                        <!-- قسم إضافة الأسئلة الفرعية (للنص) -->
                        <div class="passage-questions" data-question-type="passage" style="display: none;">
                            <h6><i class="fas fa-question"></i> الأسئلة الفرعية للنص</h6>
                            <div class="sub-question">
                                <button type="button" class="btn btn-danger btn-sm remove-sub-question"><i class="fas fa-trash"></i> حذف السؤال الفرعي</button>
                                <div class="form-group">
                                    <label for="sub_question_text"><i class="fas fa-pencil-alt"></i> نص السؤال الفرعي:</label>
                                    <input type="text" name="questions[0][sub_questions][0][text]" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="sub_question_image"><i class="fas fa-image"></i> صورة السؤال الفرعي (اختياري):</label>
                                    <input type="file" name="questions[0][sub_questions][0][image]" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="sub_question_type"><i class="fas fa-list"></i> نوع السؤال الفرعي:</label>
                                    <select name="questions[0][sub_questions][0][type]" class="form-control" required>
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
                                            <input type="text" name="questions[0][sub_questions][0][answers][0][text]" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="answer_image"><i class="fas fa-image"></i> صورة الإجابة (اختياري):</label>
                                            <input type="file" name="questions[0][sub_questions][0][answers][0][image]" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="is_correct"><i class="fas fa-check-circle"></i> هل الإجابة صحيحة؟</label>
                                            <select name="questions[0][sub_questions][0][answers][0][is_correct]" class="form-control" required>
                                                <option value="0">خطأ</option>
                                                <option value="1">صح</option>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm remove-answer"><i class="fas fa-trash"></i> حذف الإجابة</button>
                                    </div>
                                </div>
                                <!-- زر إضافة إجابة جديدة (للأسئلة الفرعية) -->
                                <button type="button" class="btn btn-secondary btn-sm add-sub-answer"><i class="fas fa-plus"></i> إضافة إجابة جديدة</button>
                            </div>
                        </div>

                        <!-- زر إضافة سؤال فرعي جديد (للنص) -->
                        <button type="button" class="btn btn-secondary btn-sm add-sub-question" style="display: none;"><i class="fas fa-plus"></i> إضافة سؤال فرعي</button>
                    </div>
                </div>

                <!-- زر إضافة سؤال جديد -->
                <button type="button" id="add-question" class="btn btn-secondary mt-3 add-question-btn"><i class="fas fa-plus"></i> إضافة سؤال جديد</button>

                <!-- زر إنشاء الامتحان -->
                <button type="submit" class="btn btn-success mt-4"><i class="fas fa-save"></i> إنشاء الامتحان</button>
            </form>
        </div>
    </div>
</section>

<!-- JavaScript لإضافة أسئلة وإجابات جديدة -->
<script>
    let questionIndex = 1;
    let answerIndex = 1;
    let subQuestionIndex = 1;

    // إضافة سؤال جديد
    document.getElementById('add-question').addEventListener('click', function() {
        const questionsSection = document.getElementById('questions-section');
        const newQuestion = document.createElement('div');
        newQuestion.classList.add('question', 'mt-4');
        newQuestion.innerHTML = `
            <button type="button" class="btn btn-danger btn-sm remove-question"><i class="fas fa-trash"></i> حذف السؤال</button>
            <div class="form-group">
                <label for="question_text"><i class="fas fa-pencil-alt"></i> نص السؤال:</label>
                <input type="text" name="questions[${questionIndex}][text]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="question_type"><i class="fas fa-list"></i> نوع السؤال:</label>
                <select name="questions[${questionIndex}][type]" class="form-control question-type" required>
                    <option value="mcq">اختيار من متعدد</option>
                    <option value="true_false">صح/خطأ</option>
                    <option value="ordering">ترتيب</option>
                    <option value="passage">نص (Passage)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="question_image"><i class="fas fa-image"></i> صورة السؤال (اختياري):</label>
                <input type="file" name="questions[${questionIndex}][image]" class="form-control">
            </div>

            <!-- قسم إضافة الإجابات (لأسئلة غير النصية) -->
            <div class="answers-section" data-question-type="mcq">
                <h6><i class="fas fa-list-ol"></i> إضافة الإجابات</h6>
                <div class="answer">
                    <div class="form-group">
                        <label for="answer_text"><i class="fas fa-pencil-alt"></i> نص الإجابة:</label>
                        <input type="text" name="questions[${questionIndex}][answers][0][text]" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="answer_image"><i class="fas fa-image"></i> صورة الإجابة (اختياري):</label>
                        <input type="file" name="questions[${questionIndex}][answers][0][image]" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="is_correct"><i class="fas fa-check-circle"></i> هل الإجابة صحيحة؟</label>
                        <select name="questions[${questionIndex}][answers][0][is_correct]" class="form-control" required>
                            <option value="0">خطأ</option>
                            <option value="1">صح</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-answer"><i class="fas fa-trash"></i> حذف الإجابة</button>
                </div>
            </div>

            <!-- زر إضافة إجابة جديدة (لأسئلة غير النصية) -->
            <button type="button" class="btn btn-secondary btn-sm add-answer add-answer-btn" data-question-type="mcq"><i class="fas fa-plus"></i> إضافة إجابة جديدة</button>

            <!-- قسم إضافة الأسئلة الفرعية (للنص) -->
            <div class="passage-questions" data-question-type="passage" style="display: none;">
                <h6><i class="fas fa-question"></i> الأسئلة الفرعية للنص</h6>
                <div class="sub-question">
                    <button type="button" class="btn btn-danger btn-sm remove-sub-question"><i class="fas fa-trash"></i> حذف السؤال الفرعي</button>
                    <div class="form-group">
                        <label for="sub_question_text"><i class="fas fa-pencil-alt"></i> نص السؤال الفرعي:</label>
                        <input type="text" name="questions[${questionIndex}][sub_questions][0][text]" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="sub_question_image"><i class="fas fa-image"></i> صورة السؤال الفرعي (اختياري):</label>
                        <input type="file" name="questions[${questionIndex}][sub_questions][0][image]" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="sub_question_type"><i class="fas fa-list"></i> نوع السؤال الفرعي:</label>
                        <select name="questions[${questionIndex}][sub_questions][0][type]" class="form-control" required>
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
                                <input type="text" name="questions[${questionIndex}][sub_questions][0][answers][0][text]" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="answer_image"><i class="fas fa-image"></i> صورة الإجابة (اختياري):</label>
                                <input type="file" name="questions[${questionIndex}][sub_questions][0][answers][0][image]" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="is_correct"><i class="fas fa-check-circle"></i> هل الإجابة صحيحة؟</label>
                                <select name="questions[${questionIndex}][sub_questions][0][answers][0][is_correct]" class="form-control" required>
                                    <option value="0">خطأ</option>
                                    <option value="1">صح</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm remove-answer"><i class="fas fa-trash"></i> حذف الإجابة</button>
                        </div>
                    </div>
                    <!-- زر إضافة إجابة جديدة (للأسئلة الفرعية) -->
                    <button type="button" class="btn btn-secondary btn-sm add-sub-answer"><i class="fas fa-plus"></i> إضافة إجابة جديدة</button>
                </div>
            </div>

            <!-- زر إضافة سؤال فرعي جديد (للنص) -->
            <button type="button" class="btn btn-secondary btn-sm add-sub-question" style="display: none;"><i class="fas fa-plus"></i> إضافة سؤال فرعي</button>
        `;
        questionsSection.appendChild(newQuestion);
        questionIndex++;
    });

    // إضافة إجابة جديدة (لأسئلة غير النصية)
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('add-answer')) {
            const answersSection = e.target.previousElementSibling;
            const newAnswer = document.createElement('div');
            newAnswer.classList.add('answer', 'mt-3');
            newAnswer.innerHTML = `
                <div class="form-group">
                    <label for="answer_text"><i class="fas fa-pencil-alt"></i> نص الإجابة:</label>
                    <input type="text" name="questions[${questionIndex - 1}][answers][${answerIndex}][text]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="answer_image"><i class="fas fa-image"></i> صورة الإجابة (اختياري):</label>
                    <input type="file" name="questions[${questionIndex - 1}][answers][${answerIndex}][image]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="is_correct"><i class="fas fa-check-circle"></i> هل الإجابة صحيحة؟</label>
                    <select name="questions[${questionIndex - 1}][answers][${answerIndex}][is_correct]" class="form-control" required>
                        <option value="0">خطأ</option>
                        <option value="1">صح</option>
                    </select>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-answer"><i class="fas fa-trash"></i> حذف الإجابة</button>
            `;
            answersSection.appendChild(newAnswer);
            answerIndex++;
        }
    });

    // إضافة إجابة جديدة (للأسئلة الفرعية)
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('add-sub-answer')) {
            const answersSection = e.target.previousElementSibling;
            const newAnswer = document.createElement('div');
            newAnswer.classList.add('answer', 'mt-3');
            newAnswer.innerHTML = `
                <div class="form-group">
                    <label for="answer_text"><i class="fas fa-pencil-alt"></i> نص الإجابة:</label>
                    <input type="text" name="questions[${questionIndex - 1}][sub_questions][${subQuestionIndex}][answers][${answerIndex}][text]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="answer_image"><i class="fas fa-image"></i> صورة الإجابة (اختياري):</label>
                    <input type="file" name="questions[${questionIndex - 1}][sub_questions][${subQuestionIndex}][answers][${answerIndex}][image]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="is_correct"><i class="fas fa-check-circle"></i> هل الإجابة صحيحة؟</label>
                    <select name="questions[${questionIndex - 1}][sub_questions][${subQuestionIndex}][answers][${answerIndex}][is_correct]" class="form-control" required>
                        <option value="0">خطأ</option>
                        <option value="1">صح</option>
                    </select>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-answer"><i class="fas fa-trash"></i> حذف الإجابة</button>
            `;
            answersSection.appendChild(newAnswer);
            answerIndex++;
        }
    });

    // إضافة سؤال فرعي جديد
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('add-sub-question')) {
            const passageQuestionsSection = e.target.closest('.question').querySelector('.passage-questions');
            const newSubQuestion = document.createElement('div');
            newSubQuestion.classList.add('sub-question', 'mt-3');
            newSubQuestion.innerHTML = `
                <button type="button" class="btn btn-danger btn-sm remove-sub-question"><i class="fas fa-trash"></i> حذف السؤال الفرعي</button>
                <div class="form-group">
                    <label for="sub_question_text"><i class="fas fa-pencil-alt"></i> نص السؤال الفرعي:</label>
                    <input type="text" name="questions[${questionIndex - 1}][sub_questions][${subQuestionIndex}][text]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sub_question_image"><i class="fas fa-image"></i> صورة السؤال الفرعي (اختياري):</label>
                    <input type="file" name="questions[${questionIndex - 1}][sub_questions][${subQuestionIndex}][image]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sub_question_type"><i class="fas fa-list"></i> نوع السؤال الفرعي:</label>
                    <select name="questions[${questionIndex - 1}][sub_questions][${subQuestionIndex}][type]" class="form-control" required>
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
                            <input type="text" name="questions[${questionIndex - 1}][sub_questions][${subQuestionIndex}][answers][0][text]" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="answer_image"><i class="fas fa-image"></i> صورة الإجابة (اختياري):</label>
                            <input type="file" name="questions[${questionIndex - 1}][sub_questions][${subQuestionIndex}][answers][0][image]" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="is_correct"><i class="fas fa-check-circle"></i> هل الإجابة صحيحة؟</label>
                            <select name="questions[${questionIndex - 1}][sub_questions][${subQuestionIndex}][answers][0][is_correct]" class="form-control" required>
                                <option value="0">خطأ</option>
                                <option value="1">صح</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm remove-answer"><i class="fas fa-trash"></i> حذف الإجابة</button>
                    </div>
                </div>
                <!-- زر إضافة إجابة جديدة (للأسئلة الفرعية) -->
                <button type="button" class="btn btn-secondary btn-sm add-sub-answer"><i class="fas fa-plus"></i> إضافة إجابة جديدة</button>
            `;
            passageQuestionsSection.appendChild(newSubQuestion);
            subQuestionIndex++;
        }
    });

    // حذف سؤال أو إجابة
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-question')) {
            e.target.closest('.question').remove();
        }
        if (e.target && e.target.classList.contains('remove-answer')) {
            e.target.closest('.answer').remove();
        }
        if (e.target && e.target.classList.contains('remove-sub-question')) {
            e.target.closest('.sub-question').remove();
        }
    });

    // تغيير نوع السؤال
    document.addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('question-type')) {
            const questionDiv = e.target.closest('.question');
            const passageQuestionsSection = questionDiv.querySelector('.passage-questions');
            const answersSection = questionDiv.querySelector('.answers-section');
            const addAnswerButton = questionDiv.querySelector('.add-answer');
            const addSubQuestionButton = questionDiv.querySelector('.add-sub-question');

            if (e.target.value === 'passage') {
                passageQuestionsSection.style.display = 'block';
                answersSection.style.display = 'block'; // Show answers section for passage questions
                addAnswerButton.style.display = 'inline-block'; // Show "Add Answer" button
                addSubQuestionButton.style.display = 'inline-block'; // Show "Add Sub-Question" button
            } else {
                passageQuestionsSection.style.display = 'none';
                answersSection.style.display = 'block';
                addAnswerButton.style.display = 'inline-block';
                addSubQuestionButton.style.display = 'none';
            }
        }
    });
</script>
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Exam: {{ $exam->name }}</h1>
        <form action="{{ route('exam.correction', $exam->id) }}" method="POST">
            @csrf
            @foreach ($exam->questions as $question)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Question {{ $loop->iteration }} ({{ ucfirst($question->type) }})</h5>
                        <p>{{ $question->text }}</p>

                        @if ($question->type === 'mcq' || $question->type === 'true_false')
                            <!-- MCQ or True/False Questions -->
                            @foreach ($question->answers as $answer)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" id="answer{{ $answer->id }}">
                                    <label class="form-check-label" for="answer{{ $answer->id }}">{{ $answer->text }}</label>
                                </div>
                            @endforeach
                        @elseif ($question->type === 'ordering')
                            <!-- Ordering Questions -->
                            <div class="ordering-answers">
                                @foreach ($question->answers as $answer)
                                    <div class="form-group">
                                        <label for="order{{ $answer->id }}">{{ $answer->text }}</label>
                                        <select name="answers[{{ $question->id }}][{{ $answer->id }}]" class="form-control order-select" required>
                                            <option value="">اختر الترتيب</option>
                                            @for ($i = 1; $i <= $question->answers->count(); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($question->type === 'passage')
                            <!-- Passage Questions -->
                            @foreach ($question->subQuestions as $subQuestion)
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <h6>Subquestion {{ $loop->iteration }}</h6>
                                        <p>{{ $subQuestion->text }}</p>

                                        @if ($subQuestion->type === 'mcq' || $subQuestion->type === 'true_false')
                                            <!-- MCQ or True/False Subquestions -->
                                            @foreach ($subQuestion->answers as $answer)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="answers[{{ $subQuestion->id }}]" value="{{ $answer->id }}" id="subAnswer{{ $answer->id }}">
                                                    <label class="form-check-label" for="subAnswer{{ $answer->id }}">{{ $answer->text }}</label>
                                                </div>
                                            @endforeach
                                        @elseif ($subQuestion->type === 'ordering')
                                            <!-- Ordering Subquestions -->
                                            <div class="ordering-answers">
                                                @foreach ($subQuestion->answers as $answer)
                                                    <div class="form-group">
                                                        <label for="order{{ $answer->id }}">{{ $answer->text }}</label>
                                                        <select name="answers[{{ $subQuestion->id }}][{{ $answer->id }}]" class="form-control order-select" required>
                                                            <option value="">اختر الترتيب</option>
                                                            @for ($i = 1; $i <= $subQuestion->answers->count(); $i++)
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit Exam</button>
        </form>
    </div>

    <!-- JavaScript for Ordering Questions -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const orderingQuestions = document.querySelectorAll('.ordering-answers');

            orderingQuestions.forEach(orderingQuestion => {
                const selects = orderingQuestion.querySelectorAll('.order-select');

                selects.forEach(select => {
                    select.addEventListener('change', function () {
                        const selectedValue = this.value;

                        // Enable all options first
                        selects.forEach(otherSelect => {
                            Array.from(otherSelect.options).forEach(option => {
                                option.disabled = false;
                            });
                        });

                        // Disable the selected value in other dropdowns
                        selects.forEach(otherSelect => {
                            if (otherSelect !== this && otherSelect.value === selectedValue) {
                                otherSelect.value = ''; // Clear the duplicate selection
                            }
                            Array.from(otherSelect.options).forEach(option => {
                                if (option.value === selectedValue && otherSelect !== this) {
                                    option.disabled = true;
                                }
                            });
                        });
                    });
                });
            });
        });
    </script>
</body>
</html>
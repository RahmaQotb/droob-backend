<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Exam Result</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Exam: {{ $exam->name }}</h5>
                <p class="card-text">Your total score is: <strong>{{ $total_score }}</strong></p>
                <a href="{{ route('exam.form', $exam->id) }}" class="btn btn-primary">Try Again</a>
            </div>
        </div>
    </div>
</body>
</html>
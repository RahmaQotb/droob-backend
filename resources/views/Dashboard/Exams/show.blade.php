@extends('Dashboard.layouts.layouts')

@section('title')
تفاصيل الامتحان
@endsection

@section('content')
@section('css')
    <link rel="stylesheet" href="{{asset('Dashboard/assets/compiled/css/table-datatable.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('Dashboard/assets/extensions/simple-datatables/umd/simple-datatables.js')}}"></script>
    <script src="{{asset('Dashboard/assets/static/js/pages/simple-datatables.js')}}"></script>
@endsection

<div class="page-heading">
    <h3>تفاصيل الامتحان</h3>
</div>

@include('messages.errors')
@include('messages.success')

<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                تفاصيل الامتحان: {{ $exam->name }}
            </h5>
        </div>
        <div class="card-body">
            <!-- تفاصيل الامتحان -->
            <div class="mb-4">
                <h5>معلومات الامتحان</h5>
                <p><strong>اسم الامتحان:</strong> {{ $exam->name }}</p>
                <p><strong>المادة الدراسية:</strong> {{ $exam->subject->name }}</p>
                <p><strong>وقت الإنشاء:</strong> {{ $exam->created_at->format('Y-m-d H:i:s') }}</p>
            </div>

            <!-- الأسئلة -->
            <div class="mb-4">
                <h5>الأسئلة</h5>
                @foreach ($exam->questions as $question)
                    <div class="question mb-4 p-3 border rounded">
                        <p><strong>السؤال:</strong> {{ $question->text }}</p>
                        @if ($question->image)
                            <img src="{{ asset('storage/' . $question->image) }}" alt="صورة السؤال" class="img-fluid mb-3" style="max-width: 300px;">
                        @endif

                        <!-- الإجابات -->
                        <div class="answers ml-4">
                            <h6>الإجابات:</h6>
                            @foreach ($question->answers as $answer)
                                <div class="answer mb-2 p-2 border rounded">
                                    <p><strong>الإجابة:</strong> {{ $answer->text }}</p>
                                    @if ($answer->image)
                                        <img src="{{ asset('storage/' . $answer->image) }}" alt="صورة الإجابة" class="img-fluid mb-2" style="max-width: 200px;">
                                    @endif
                                    <p><strong>هل الإجابة صحيحة؟</strong> {{ $answer->is_correct ? 'نعم' : 'لا' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
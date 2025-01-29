@extends('Dashboard.layouts.layouts')

@section('title', 'تفاصيل الطالب')

@section('content')
@section('css')
    <link rel="stylesheet" href="{{ asset('Dashboard/assets/compiled/css/table-datatable.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('Dashboard/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('Dashboard/assets/static/js/pages/simple-datatables.js') }}"></script>
@endsection

<div class="page-heading">
    <h3>تفاصيل الطالب</h3>
</div>

@include('messages.errors')
@include('messages.success')

<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">تفاصيل الطالب: {{ $student->name }}</h5>
        </div>
        <div class="card-body">
            <!-- Student Information -->
            <div class="mb-4">
                <h5>معلومات الطالب</h5>
                <p><strong>اسم الطالب:</strong> {{ $student->name }}</p>
                <p><strong>رقم الطالب:</strong> {{ $student->id }}</p>
                <p><strong>تاريخ الإنشاء:</strong> {{ $student->created_at->format('Y-m-d H:i:s') }}</p>
            </div>

            <!-- Exams and Grades -->
            <div class="mb-4">
                <h5>الامتحانات والدرجات</h5>
                @if ($student->exams->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>اسم الامتحان</th>
                                <th>المادة الدراسية</th>
                                <th>الدرجة</th>
                                <th>تاريخ الامتحان</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($student->exams as $exam)
                                <tr>
                                    <td>{{ $exam->name }}</td>
                                    <td>{{ $exam->subject->name }}</td>
                                    <td>{{ $exam->pivot->degree?? 'غير محدد' }}</td> <!-- Access grade from the pivot table -->
                                    <td>{{ $exam->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>لا توجد امتحانات مسجلة لهذا الطالب.</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@extends('Dashboard.layouts.layouts')

@section('title')
إنشاء امتحان جديد
@endsection

@section('content')
@section('css')
    {{-- <link rel="stylesheet" href="{{asset('Dashboard/assets/extensions/simple-datatables/style.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('Dashboard/assets/compiled/css/table-datatable.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('Dashboard/assets/extensions/simple-datatables/umd/simple-datatables.js')}}"></script>
    <script src="{{asset('Dashboard/assets/static/js/pages/simple-datatables.js')}}"></script>
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
                إضافة امتحان جديد
            </h5>
        </div>
        <div class="card-body">
            <!-- نموذج إنشاء الامتحان -->
            <form action="{{ route('exams.store') }}" method="POST">
                @csrf <!-- حماية من هجمات CSRF -->

                <!-- حقل اسم الامتحان -->
                <div class="form-group">
                    <label for="name">اسم الامتحان:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <!-- حقل وصف الامتحان -->
                <div class="form-group">
                    <label for="description">وصف الامتحان:</label>
                    <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>

                <!-- حقل اختيار المادة الدراسية -->
                <div class="form-group">
                    <label for="subject_id">المادة الدراسية:</label>
                    <select name="subject_id" id="subject_id" class="form-control" required>
                        <option value="">اختر المادة الدراسية</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- زر الإرسال -->
                <div class="form-group">
                    <button type="submit" class="btn btn-success">إنشاء الامتحان</button>
                    <a href="{{ route('exams.index') }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
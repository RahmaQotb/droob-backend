@extends('Dashboard.layouts.layouts')

@section('title')
    تفاصيل الطالب
@endsection

@section('content')
    @include('messages.errors')
    @include('messages.success')

    <div class="page-heading">
        <h3>تفاصيل الطالب: {{$student->name}}</h3>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">{{$student->name}}</h2>
                <div style="display: flex; gap: 10px; margin-top: 5px; justify-content: flex-end">
                    {{-- <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">
                        التعديل
                    </a> --}}
                    <form action="{{ route('students.destroy', $student->id) }}" style="margin: 0;" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <p><strong>المستوى:</strong> {{$student->level}}</p>
                <p><strong>الدرجات:</strong></p>
                {{-- @foreach($grades as $grade)
                    <p><strong>{{ ucfirst($grade->exam_type) }} امتحان:</strong> {{$grade->score}} / 100</p>
                @endforeach  --}}
            </div>
        </div>
    </section>
@endsection

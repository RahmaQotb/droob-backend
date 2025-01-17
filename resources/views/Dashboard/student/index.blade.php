@extends('Dashboard.layouts.layouts')

@section('title')
الطلاب
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
    <h3>الطلاب</h3>
</div> 
@include('messages.errors')
@include('messages.success')

<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                كل الطلاب
            </h5>
        </div>
        {{-- <div style="display: flex; gap: 10px; margin-top: 5px; margin-left: 50px;  justify-content: flex-end">
            <a href="{{route('students.create')}}" class="btn  btn-success" rel="noopener noreferrer">
                إضافة طالب
            </a>
        </div> --}}
        <div class="card-body">
<table class="table table-striped" id="table1">
    <thead>
        <tr>
            <th>رقم الطالب</th>
            <th>الأسم</th>
            <th>حالة الطالب</th>
            <th>تم الاضافة في</th>
            <th colspan="2"></th>

        </tr>
    </thead>
    <tbody>
        @forelse ($students as $student)
        <tr>
            <td>{{$student->id}}</td>
            <td>{{$student->name}}</td>
            <td>
                {{$student->intelligence_level_status ?? 'الطالب لا يحتاج لاختبار ذكاء' }}
            </td>
            <td>
                {{$student->created_at}}
            </td>
            <td>
                <a href="{{route('students.show',$student->id)}}" class="btn btn-sm btn-outline-success" rel="noopener noreferrer">
                    عرض التفاصيل
                </a>
            </td>
            {{-- <td>
                <a href="{{route('students.edit',$student->id)}}" class="btn btn-sm btn-outline-primary" rel="noopener noreferrer">
                    التعديل
                </a>
            </td> --}}
            <td>
                <form action="{{route('students.destroy',$student->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">لا يوجد طلاب</td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
</div>

</section>
@endsection
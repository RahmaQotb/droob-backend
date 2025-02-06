@extends('Dashboard.layouts.layouts')

@section('title')
الامتحانات
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
    <h3>الامتحانات</h3>
</div> 
@include('messages.errors')
@include('messages.success')

<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                كل الإمتحانات
            </h5>
        </div>
        <div style="display: flex; gap: 10px; margin-top: 5px; margin-left: 50px;  justify-content: flex-end">
            <a href="{{route('exams.create')}}" class="btn  btn-success" rel="noopener noreferrer">
                إضافة إمتحان
            </a>
        </div>
        <div class="card-body">
<table class="table table-striped" id="table1">
    <thead>
        <tr>
            <th>رقم الإمتحان</th>
            <th>اسم المادة</th>
            <th>وقت إضافة الإمتحان</th>
            <th colspan="3"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($exams as $exam)
        <tr>
            <td>{{$exam->id}}</td>
            <td>{{$exam->subject->name}}</td>
            <td>
                {{$exam->created_at}}
            </td>
            <td>
                <a href="{{route('exams.show',$exam->id)}}" class="btn btn-sm btn-outline-success" rel="noopener noreferrer">
                    عرض التفاصيل
                </a>
            </td>
            {{-- <td>
                <a href="{{route('exams.edit',$exam->id)}}" class="btn btn-sm btn-outline-primary" rel="noopener noreferrer">
                    التعديل
                </a>
            </td> --}}
            <td>
                <form action="{{route('exams.destroy',$exam->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">لا يوجد إمتحانات</td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
</div>

</section>
@endsection
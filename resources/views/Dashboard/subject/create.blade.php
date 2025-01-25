@extends('Dashboard.layouts.layouts')

@section('title')
    أضف مادة
@endsection
@section('content')
<div class="page-heading">
    <h3>المواد</h3>
</div> 

@include('messages.errors')
@include('messages.success')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">أضف مادة</h4>
        </div>
        <form action="{{route('subjects.store')}}" method="post">
            @csrf
        <div class="card-body">
            <div class="row">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">الأسم</label>
                        <input type="text" autocomplete="off" class="form-control" name="name" id="name" placeholder="">
                    </div>

                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">الوصف</label>
                        <input type="text" autocomplete="off" class="form-control" name="desc" id="desc" placeholder="">
                    </div>
             
                    
                </div>
            </div>
        <div class="d-flex mt-2 justify-content-center">
            <button class="btn btn-outline-primary">إضافة</button>
        </div>
    </form>
        </div>
    </div>
</section>
@endsection
@extends('Dashboard.layouts.layouts')

@section('title')
    المواد
@endsection
@section('content')
<div class="page-heading">
    <h3>تعديل مادة</h3>
</div> 

@include('messages.errors')
@include('messages.success')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{$subject->name}}</h4>
        </div>
        <form action="{{route('subjects.update',$subject->id)}}" method="post">
            @csrf
            @method('put')
        <div class="card-body">
            <div class="row">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">الإسم</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{$subject->name}}" placeholder="">
                    </div>

              
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">الوصف</label>
                        <input type="text" class="form-control" value="{{$subject->description}}" name="desc" id="desc" placeholder="">
                    </div>
                    
                    
                </div>
            </div>
        <div class="d-flex mt-2 justify-content-center">
            <button class="btn btn-outline-success">التعديل</button>
        </div>
    </form>
        </div>
    </div>
</section>
@endsection
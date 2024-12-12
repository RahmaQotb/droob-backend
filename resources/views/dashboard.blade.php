@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <h2>Welcome, {{ auth()->user()->name }}</h2> --}}
    
    <p>This is your dashboard. You are logged in!</p>

    <form action="{{ url('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
@endsection

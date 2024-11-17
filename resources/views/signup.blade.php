@extends('layout')
@section('title', 'Signup')
@section('content')
<div class="container">
    <div class="mt-5">
        @if($errors->any())
        <div class="col-12">
            @foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
            {{$error}}</div>
            @endforeach
            </div>
        @endif

        @if(session('error'))   
        <div class="alert alert-danger" role="alert">
            {{session('error')}}</div>
        @endif

        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{session('success')}}</div>
        @endif

    </div>
<form action="{{route('signup.post')}}" method="POST" class="ms-auto me-auto mt-auto" style="width: 500px;">
    @csrf
  <div class="mb-3">
    <label class="form-label">Full Name</label>
    <input type="text" class="form-control" name="name">
    
  </div>
  <div class="mb-3">
    <label class="form-label">Email address</label>
    <input type="email" class="form-control" name="email">
    
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" class="form-control" name="password">

  </div>
    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" class="form-control" name="confirm_password">
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

@endsection
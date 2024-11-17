@extends('layout')
@section('title', 'Signup')
@section('content')
<div class="container">
<form class="ms-auto me-auto mt-auto" style="width: 500px;">
  <div class="mb-3">
    <label class="form-label">Full Name</label>
    <input type="text" class="form-control" name="fullname">
    
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
        <input type="password" class="form-control" name="confirm password">
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

@endsection
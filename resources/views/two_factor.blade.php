@extends('layout')
@section('title', 'Login')
@section('content')
<div class="container">
<div class="login-title mt-4">
                                <h2 class="text-center text-dark">Two Factor Authentication</h2>
                 </div>
                            <form method="POST" action="{{ route('two_factor.post') }}">
                                @csrf
                                <p>{{ __('Please enter your one-time password to complete your login.') }}</p>
                                <div class="mb-4">
                                    <div class="input-group custom" style="margin-bottom:0px;">
                                        <input type="password" name="one_time_password" class="form-control form-control-lg" placeholder="**********" />
                                        <div class="input-group-append custom">
                                            <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                        </div>
                                    </div>
                                    @error('one_time_password')
                                        <div class="form-control-feedback text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="row mt-4 mb-4">
                                    <div class="col-sm-12">
                                        <div class="input-group mb-0">
                                            <input class="btn btn-danger btn-lg btn-block" type="submit" value="Verify">
                                        </div>
                                        
                                    </div>
                                </div>
                                </form>


</div>
@endsection
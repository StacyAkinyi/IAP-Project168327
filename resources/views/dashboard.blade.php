@extends('layout')
@section('title', 'Dashboard')
@section('content')

@auth
  {{auth()->user()->name}}
  @endauth


@endsection
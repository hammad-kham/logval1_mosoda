@extends('layouts.guest')

@section('content')
    <div class="hero bg-white overflow-hidden">
        <div class="hero-inner">
            <div class="content content-full text-center">
                <h1 class="font-w700 mb-2">
                    Welcome to {{ env('APP_NAME', 'Homely') }} Portal
                </h1>
                <a class="btn btn-primary px-4 py-2 m-1 text-uppercase font-size-sm" href="{{url('/dashboard')}}">
                    Proceed To Login
                    <i class="fa fa-fw fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
@endsection

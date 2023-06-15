@extends('template.layout')


@section('main')
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shop in style</h1>
        </div>
    </div>
</header>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">HomePage</div>

                <div class="card-body">
                    @auth
                        <p>{{ Auth::user()->name }}</p>
                    @else
                        <p>Welcome!</p>
                        <p>Login 
                            <a href="{{ route('login') }}">Here</a>
                        </p>
                        <p>Register 
                            <a href="{{ route('register') }}">Here</a>
                        </p>
                    @endauth    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

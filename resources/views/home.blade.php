@extends('template.layout')


@section('main')
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

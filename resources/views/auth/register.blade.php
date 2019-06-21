@extends('layouts.main')
@section('title','Signup')
@section('content')
    <!-- Main Content -->
    <div class="hk-pg-wrapper hk-auth-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 pa-0">
                    <div class="auth-form-wrap pt-xl-0 pt-70">
                        <div class="auth-form w-xl-30 w-lg-55 w-sm-75 w-100">
                            <a class="auth-brand text-center d-block mb-20" href="#">
                                <img width="50%" class="img-responsive" src="{{asset('dist/img/logo.png')}}"
                                     alt="brand"/>
                            </a>
                            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}
                                <h1 class="display-4 mb-10 text-center">Sign up</h1>
                                <p class="mb-30 text-center">Create your account and get access to awisk HRM.</p>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <input id="name" type="text" placeholder="Name" class="form-control" name="name"
                                           value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <small>{{ $errors->first('name') }}</small>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input id="email" placeholder="Email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('email') }}</small>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input id="password" placeholder="Password" type="password" class="form-control"
                                           name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('password') }}</small>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input id="password-confirm" placeholder="Confirm Password" type="password"
                                               class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-block" type="submit">Register</button>
                                <div class="option-sep">or</div>
                                <p class="text-center">Already have an account ? <a href="{{route('login')}}">Sign
                                        In</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Content -->

@endsection

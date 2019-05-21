@extends('layouts.main')
@section('title','Login')
@section('content')
    <!-- Main Content -->
    <div class="hk-pg-wrapper hk-auth-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 pa-0">
                    <div class="auth-form-wrap pt-xl-0 pt-70">
                        <div class="auth-form w-xl-30 w-lg-55 w-sm-75 w-100">
                            <a class="auth-brand text-center d-block mb-20" href="{{route('page.dashboard')}}">
                                <img width="50%" class="img-responsive img-thumbnail" src="{{asset('dist/img/logo.png')}}" alt="brand"/>
                            </a>
                            <form method="POST" action="{{ route('login') }}">
                                {{csrf_field()}}
                                <h1 class="display-4 text-center mb-10">Awisk Time Sheet</h1>
                                <p class="text-center mb-30">Sign in to mark and view your attendance.</p>
                                <div class="form-group {{ $errors->has('email') ? ' is-invalid' : '' }}">
                                    <input id="email" name="email" class="form-control" placeholder="Email" type="email"
                                           required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('email') }}</small>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('password') ? ' is-invalid' : '' }}">
                                    <div class="input-group">
                                        <input name="password" class="form-control" placeholder="Password"
                                               type="password" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('password') }}</small>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="custom-control custom-checkbox mb-25">
                                    <input name="remember" class="custom-control-input" id="remember"
                                           type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label font-14" for="remember">Keep me logged
                                        in</label>
                                </div>
                                <div class="form-group">
                                <button class="btn btn-outline-primary btn-block" type="submit">Login</button>
                                    <div class="option-sep">or</div>
                                <p class="text-center">Dont have an account yet ? <strong>contact your
                                        supervisor.</strong></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Content -->
@endsection

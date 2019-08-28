@extends('admin.layouts.admin')

@section('content')
    <div class="main-page login-page ">
        <h2 class="title1">{{ __('Login Admin') }}</h2>
        <div class="widget-shadow">
            <div class="login-body">
                <form  action="{{ route('admin.auth.loginAdmin') }}" method="post">
                    @csrf
                    <input id="email" type="email" class="user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <input id="password" type="password" class="lock @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <div class="forgot-grid">
                        <label class="checkbox">
                            <input  type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <i></i>Remember me
                        </label>
                        @if (Route::has('password.request'))
                            <div class="forgot">
                                <a href="{{ route('password.request') }}">forgot password?</a>
                            </div>
                        @endif
                        <div class="clearfix"> </div>
                    </div>
                    <input type="submit" name="Sign In" value="{{ __('Login') }}">
                    <div class="registration">
                        Don't have an account ?
                        <a class="" href="signup.html">
                            Create an account
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

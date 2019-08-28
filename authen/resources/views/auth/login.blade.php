@extends('frontend.layouts.fashion')

@section('content')
    <div class="login">
        <div class="main-agileits">
            <div class="form-w3agile">
                <h3>Login</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="key">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <input id="email" type="text" placeholder="Email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        <div class="clearfix"></div>
                    </div>
                    <div class="key">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        <input id="password" placeholder="Password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        <div class="clearfix"></div>
                    </div>

                    <div class="key1" style="margin: 10px">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            {{ __('Remember Me') }}
                        <div class="clearfix"></div>
                    </div>
                    <input type="submit" value="Login">
                </form>
            </div>
            <div class="forg">
                @if (Route::has('password.request'))
                    <a class="forg-left"  href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif

                    @guest
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="forg-right">Register</a>
                        @endif
                    @endguest
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

@endsection

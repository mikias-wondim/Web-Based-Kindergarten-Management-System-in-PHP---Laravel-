@extends('layouts.unauth')

@section('content')
    <div class="center" >
        <div class="popup-content" style="
                    background: url({{ asset('image/login-background.png') }} );
                    background-position: center;
                    background-size: cover;
                    background-repeat: no-repeat;">
            <div class="logo-img center">
                <img src="{{ asset('image/logo-colorful.png') }}" alt="logo" class="login-img">
            </div>
            <h2>Login</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                @error('unique_name')
                <span class="center" role="alert"><strong style="color: red; text-align: center">{{ $message }}</strong>
                </span>
                @enderror

                <label for="unique_name">Username:</label>
                <input type="text" id="unique_name" name="unique_name" class="@error('unique_name') is-invalid @enderror"
                       value="{{ old('unique_name') }}" required autofocus>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="@error('password') is-invalid @enderror"
                       required autofocus>
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
                @enderror



                <div class="center">
                    <a href="/" class="btn dark-btn text-light">Cancel</a>
                    <button type="submit" class="btn primary-btn text-light">Login</button>
                </div>
            </form>
            @if (Route::has('password.request'))
                <a class="orange" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
            <p>Have no account? <a href="#"><span class="orange">Admission</span></a></p>
        </div>
    </div>
@endsection

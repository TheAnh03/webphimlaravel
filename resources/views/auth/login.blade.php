@extends('layouts.login_layout')

@section('content_login')
@if (session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif

@if ($errors->has('email'))
<div class="alert alert-danger">
    {{ $errors->first('email') }}
</div>
@endif


    <div id="logreg-forms">
        <form class="form-signin" method="POST" action="{{ route('login') }}">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Đăng nhập</h1>
            <div class="social-login">
                <button class="btn facebook-btn social-btn" type="button">
                    <a href="" style="color: #fff"><i class="fab fa-facebook-f"></i>  
                        Đăng nhập với Facebook</a></button>
                <button class="btn google-btn social-btn" type="button"><a href="{{ route('login.google')}}" style="color: #fff"> <i class="fab fa-google"></i>
                    Đăng nhập với Google</a> </button>
            </div>
            <p style="text-align:center"> OR </p>
            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Email address" required=""
                autofocus="">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror


            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required="" autocomplete="current-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
        
            <button class="btn btn-success btn-block" type="submit"><i class="fas fa-sign-in-alt"></i>
                {{ __('Đăng nhập') }}</button>
                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}" id="forgot_pswd">
                    {{ __('Quên mật khẩu?') }}
                </a>
            @endif            
        
            <hr>
           
            
                <a href="{{ route('register') }}" class="btn btn-primary btn-block"><i class="fas fa-user-plus"></i> Đăng ký tài khoản mới</a>
                
        </form>

       
        <br>

    </div>
@endsection

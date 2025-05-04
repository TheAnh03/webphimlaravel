@extends('layouts.login_layout')

@section('content_login')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
{{-- 
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                      

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Gửi yêu cầu đặt lại mật khẩu!') }}
                                </button>
                            </div>
                        </div>
                    </form> --}}



                <form method="POST" action="{{ route('password.email') }}" class="form-reset">
                    @csrf
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Nhập Email đã đăng ký') }}</label>

                             <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                                <div class="row">
                            <div class="col-md-6 " style="float: left; margin-top:20px;">
                                <a href="{{route('login')}}" id="cancel_reset"><i class="fas fa-angle-left"></i> Quay lại trang đăng nhập</a>
                                
                            </div>
                            <div class="col-md-6 " style="float: right; margin-top:20px;">
                               
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Gửi yêu cầu đặt lại mật khẩu!') }}
                                </button>
                            </div>
                        </div>
                </form>

                        




                </div>
            </div>
        </div>
    </div>
</div>
@endsection

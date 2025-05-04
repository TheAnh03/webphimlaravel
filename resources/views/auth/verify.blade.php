@extends('layouts.login_layout')

@section('content_login')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Xác minh Email của bạn') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Một liên kết xác minh mới đã được gửi tới địa chỉ email của bạn.') }}
                        </div>
                    @endif
                        <br>
                    {{ __('Trước khi tiếp tục đăng nhập, vui lòng xác minh email liên kết. Lưu ý, có thể mail được lưu trong thư mục spam.') }}
                    <br>
                    {{ __('Nếu bạn không nhận được email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('nhấp vào đây để gửi lại yêu cầu xác minh') }}</button>.
                    </form>
                </div>
                <div class="card-footer">
                    <p>Hoặc tiếp tục truy cập <a href="/">Trang chủ</a> (hạn chế chức năng!!!)</p>
                    <p style="color: rgba(255, 0, 0, 0.637)">Lưu ý tài khoản chưa xác minh sẽ tự động bị xóa sau 15 ngày!</p>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

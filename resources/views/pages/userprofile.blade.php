@extends('layout')
@section('content')
    <div class="row container" id="wrapper">

        <div class="halim-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="yoast_breadcrumb hidden-xs"><span><span><span class="breadcrumb_last"
                                        aria-current="page"></span></span></span></div>
                    </div>
                </div>
            </div>
            <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                <div class="ajax"></div>
            </div>
        </div>
        <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">

            <section id="log-reg">
                <div class="section-bar">
                    <h3 style="display:flex;  justify-content: center; color:rgb(233, 217, 76)"> THÔNG TIN TÀI KHOẢN</h3>

                </div>
                <div class="row">

                    <div class="col-md-3" style="margin-bottom:20px;">
                        <div class="profile-sidebar">
                            <div class="profile-userpic">
                                <img src="{{ asset('uploads/logo/' . $user->avatar) }}" class="img-responsive"
                                    alt="">
                            </div>
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name">Tên : {{ $user->name }} </div>
                                <div class="profile-usertitle-vip">
                                    <p>Tham gia: {{ $user->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="col-md-9" style="margin-bottom:20px;">
                        <div class="col-xs-12 col-md-12 pdr0">
                            <div class="tab-login update-info" id="tab-login">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="bor-form">
                                    <form name="SignInForm" id="SignInForm" method="post"
                                        class="form-login form-horizontal" enctype="multipart/form-data"
                                        action="{{ route('update_profile') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="email">Email</label>
                                            <div class="col-sm-9">
                                                <input name="User[email]" type="email" id="email"
                                                    value="{{ $user->email }}" class="form-control lg-email"
                                                    placeholder="Email đăng nhập" disabled="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="username">Tài khoản</label>
                                            <div class="col-sm-9">
                                                <input name="User[username]" type="text" id="username"
                                                    value="{{ $user->name }}" class="form-control lg-name"
                                                    placeholder="Tài khoản / Username" disabled="">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="email">Mật khẩu</label>
                                            <div class="col-sm-9">
                                                <input name="password" type="password" id="password" value=""
                                                    class="form-control lg-pass" placeholder="Để trống nếu không muốn đổi">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="email">Avatar</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="fileToUpload" id="fileToUpload">
                                                (Ảnh nhỏ hơn 5MB, nếu ảnh lớn hơn 5MB sẽ được chọn mặc định)
                                            </div>
                                        </div>
                                        <div class="form-group" style="padding-top: 6px;">
                                            <label class="control-label col-sm-3"></label>
                                            <div class="col-sm-9">
                                                <input type="submit" name="submit" class="btn btn-primary"
                                                    value="Cập nhật">
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </section>
        </main>
        @include('pages.include.sidebar');
    </div>
@endsection

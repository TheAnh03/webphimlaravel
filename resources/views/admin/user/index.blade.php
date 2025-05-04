@extends('layouts.app')

@section('content')
    <div class="">Danh sách nguời dùng</div>

    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên đăng nhập</th>
                    <th scope="col">Email</th>
                    <th scope="col">Ngày đăng ký</th>
                    <th scope="col">Phân quyền</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Xóa</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($list_user as $key => $user)
                    <tr id="{{ $user->id }}">
                        <th scope="row">{{ $key }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
               
                        <td>{{ $user->created_at }}</td>
                        <td>
                            @if ($user->hasRole('admin'))
                                Admin
                            @else
                                User
                            @endif
                        </td>
                        <td>
                            @if ($user->hasVerifiedEmail())
                                Đã xác minh
                            @else
                                Chưa xác minh
                            @endif
                        </td>
                      
                        <td>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['user.destroy', $user->id],
                                'onsubmit' => 'return confirm("Xóa tài khoản này ?")',
                            ]) !!}
                            <button class="fa fa-trash btn " style="color: #d9534f"></button>
                            {!! Form::close() !!}
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('user.create') }}" class="btn btn-success">Thêm user</a>


    </div>
@endsection

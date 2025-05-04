@extends('layouts.app')
@section('content')
<h1>Thông tin người dùng</h1>




<div class="container-fluid">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Ảnh đại diện</th>
                <th scope="col">Tên đăng nhập</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Ngày đăng ký</th>
                <th scope="col">Chức vụ</th>
                <th scope="col">Chỉnh sửa</th>
               
            </tr>
        </thead>
        <tbody >
            
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>
                        <img src="{{ asset('uploads/logo/' . $user->avatar) }}" class="img-responsive"
                                    alt="">
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->password }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        @foreach($user->getRoleNames() as $role)
                        {{ $role }}
                        @endforeach
                    </td>
                    <td>
                        <a href="" class="fa fa-cog btn "></a>
                    </td>
                   

                </tr>
      
        </tbody>
    </table>
    


</div>







@endsection



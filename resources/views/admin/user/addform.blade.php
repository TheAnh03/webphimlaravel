@extends('layouts.app')

@section('content')
    
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
        <div class="container">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

          
                {!! Form::open(['route' => 'user.store', 'method' => 'POST']) !!}
         
            <div class="form-group">
                {!! Form::label('name', 'Tên người dùng:', []) !!}
                {!! Form::text('name',  '', [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập vào dữ liệu',
                    'id' => 'slug','required' => 'required'
                    
                ]) !!}
            </div>
        
            <div class="form-group">
                {!! Form::label('email', 'Email:', []) !!}
                {!! Form::text('email', '', [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập vào dữ liệu',
                    'id' => 'title',
                    'required' => 'required'
                ]) !!}
            </div>
              
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password', ['class' => 'form-control','placeholder' => 'Nhập vào dữ liệu', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('password') }}</small>
                </div>
            <div class="form-group">
                {!! Form::label('role', 'Phân quyền:', []) !!}
                {!! Form::select(
                    'role',
                    [
                        '0' => 'user',
                        '1' => 'admin',
                    ],
                    '0', 
                    ['id' => 'inputname', 'class' => 'form-control'],
                ) !!}
            </div>
            <div class="form-group">
         
                {!! Form::submit('Thêm người dùng', ['class' => 'btn btn-success ']) !!}
          
            
            </div>
            {!! Form::close() !!}
        </div>
    
@endsection

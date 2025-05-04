@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
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

        {!! Form::open([
            'route' => ['decoration.update', $info->id],
            'method' => 'PUT',
            'enctype' => 'multipart/form-data',
        ]) !!}

        <div class="form-group">
            {!! Form::label('title', 'Tên Website:', []) !!}
            {!! Form::text('title', isset($info) ? $info->title : '', [
                'class' => 'form-control',
                'placeholder' => 'Nhập vào dữ liệu',
                'id' => 'slug',
                'onkeyup' => 'ChangeToSlug()',
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Mô tả:', []) !!}
            {!! Form::textarea('description', isset($info) ? $info->description : '', [
                'class' => 'form-control',
                'placeholder' => 'Nhập vào dữ liệu',
                'id' => 'title',
                'style' => 'resize:none',
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('image', 'Logo', []) !!}
            {!! Form::file('image', ['class' => 'form-control-file']) !!}

            @if ($info)
                <br>
                <img width="30%" src="{{ asset('uploads/logo/' . $info->logo) }}">
            @endif
        </div>


        {!! Form::submit('Cập nhật thông tin website', ['class' => 'btn btn-success ']) !!}

        {!! Form::close() !!}
    </div>
@endsection

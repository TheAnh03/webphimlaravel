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

        @if (!isset($genre))
            {!! Form::open(['route' => 'genre.store', 'method' => 'POST']) !!}
        @else
            {!! Form::open(['route' => ['genre.update', $genre->id], 'method' => 'PUT']) !!}
        @endif
        <div class="form-group">
            {!! Form::label('title', 'Tên thể loại:', []) !!}
            {!! Form::text('title', isset($genre) ? $genre->title : '', [
                'class' => 'form-control',
                'placeholder' => 'Nhập vào dữ liệu',
                'id' => 'slug',
                'onkeyup' => 'ChangeToSlug()',
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('slug', 'Slug', []) !!}
            {!! Form::text('slug', isset($genre) ? $genre->slug : '', [
                'class' => 'form-control',
                'placeholder' => 'Nhập vào dữ liệu',
                'id' => 'convert_slug',
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('description', 'Mô tả:', []) !!}
            {!! Form::textarea('description', isset($genre) ? $genre->description : '', [
                'class' => 'form-control',
                'placeholder' => 'Nhập vào dữ liệu',
                'id' => 'title',
                'style' => 'resize:none',
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('status', 'Trạng thái:', []) !!}
            {!! Form::select('status', ['1' => 'Hiển thị', '0' => 'Không hiển thị'], isset($genre) ? $genre->status : '', [
                'id' => 'inputname',
                'class' => 'form-control',
            ]) !!}
        </div>
        @if (!isset($genre))
            {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-success ']) !!}
        @else
            {!! Form::submit('Cập nhật', ['class' => 'btn btn-success ']) !!}
        @endif
        {!! Form::close() !!}
    </div>
@endsection

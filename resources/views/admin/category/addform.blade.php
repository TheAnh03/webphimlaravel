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

            @if (!isset($category))
                {!! Form::open(['route' => 'category.store', 'method' => 'POST']) !!}
            @else
                {!! Form::open(['route' => ['category.update', $category->id], 'method' => 'PUT']) !!}
            @endif
            <div class="form-group">
                {!! Form::label('title', 'Tên danh mục:', []) !!}
                {!! Form::text('title', isset($category) ? $category->title : '', [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập vào dữ liệu',
                    'id' => 'slug',
                    'onkeyup' => 'ChangeToSlug()',
                ]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('slug', 'Slug', []) !!}
                {!! Form::text('slug', isset($category) ? $category->slug : '', [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập vào dữ liệu',
                    'id' => 'convert_slug',
                ]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Mô tả:', []) !!}
                {!! Form::textarea('description', isset($category) ? $category->description : '', [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập vào dữ liệu',
                    'id' => 'title',
                    'style' => 'resize:none',
                ]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('status', 'Trạng thái:', []) !!}
                {!! Form::select(
                    'status',
                    ['1' => 'Hiển thị', '0' => 'Không hiển thị'],
                    isset($category) ? $category->status : '',
                    ['id' => 'inputname', 'class' => 'form-control'],
                ) !!}
            </div>
            <div class="form-group">
            @if (!isset($category))
                {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-success ']) !!}
            @else
                {!! Form::submit('Cập nhật', ['class' => 'btn btn-success ']) !!}
            @endif
            </div>
            {!! Form::close() !!}
        </div>
    
@endsection

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

                        @if (!isset($country))
                            {!! Form::open(['route' => 'country.store', 'method' => 'POST']) !!}
                        @else
                            {!! Form::open(['route' => ['country.update', $country->id], 'method' => 'PUT']) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Tên quốc gia:', []) !!}
                            {!! Form::text('title', isset($country) ? $country->title : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhập vào dữ liệu',
                                'id' => 'slug',
                                'onkeyup' => 'ChangeToSlug()',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug:', []) !!}
                            {!! Form::text('slug', isset($country) ? $country->slug : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhập vào dữ liệu',
                                'id' => 'convert_slug',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Mô tả:', []) !!}
                            {!! Form::textarea('description', isset($country) ? $country->description : '', [
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
                                isset($country) ? $country->status : '',
                                ['id' => 'inputname', 'class' => 'form-control'],
                            ) !!}
                        </div>
                        @if (!isset($country))
                            {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-success ']) !!}
                        @else
                            {!! Form::submit('Cập nhật', ['class' => 'btn btn-success ']) !!}
                        @endif
                        {!! Form::close() !!}
                    </div>
              
@endsection

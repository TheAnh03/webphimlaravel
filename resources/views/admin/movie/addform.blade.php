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
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Quản lý phim</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (!isset($movie))
                            {!! Form::open(['route' => 'movie.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        @else
                            {!! Form::open(['route' => ['movie.update', $movie->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Tên phim', []) !!}
                            {!! Form::text('title', isset($movie) ? $movie->title : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhập vào dữ liệu',
                                'id' => 'slug',
                                'onkeyup' => 'ChangeToSlug()',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name_eng', 'Original name', []) !!}
                            {!! Form::text('name_eng', isset($movie) ? $movie->name_eng : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhập vào dữ liệu',
                                'id' => 'slug',
                                'onkeyup' => 'ChangeToSlug()',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($movie) ? $movie->slug : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhập vào dữ liệu',
                                'id' => 'convert_slug',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Mô tả', []) !!}
                            {!! Form::textarea('description', isset($movie) ? $movie->description : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhập vào dữ liệu',
                                'id' => 'title',
                                'style' => 'resize:none',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tags', 'Tags', []) !!}
                            {!! Form::textarea('tags', isset($movie) ? $movie->tags : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhập vào dữ liệu',
                                'id' => 'title',
                                'style' => 'resize:none',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('trailer', 'Trailer-URL', []) !!}
                            {!! Form::textarea('trailer', isset($movie) ? $movie->trailer : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhập vào dữ liệu',
                                'id' => 'title',
                                'style' => 'resize:none',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('duration', 'Thời lượng', []) !!}
                            {!! Form::text('duration', isset($movie) ? $movie->duration : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhập vào dữ liệu',
                                'id' => 'title',
                                'style' => 'resize:none',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('episode', 'Tổng số tập', []) !!}
                            {!! Form::text('episode', isset($movie) ? $movie->episode : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhập vào dữ liệu',
                                'id' => 'title',
                                'style' => 'resize:none',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('season', 'Season', []) !!}
                            {!! Form::text('season', isset($movie) ? $movie->season : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhập vào dữ liệu',
                                'id' => 'title',
                                'style' => 'resize:none',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('category', 'Danh mục', []) !!}
                            {!! Form::select('category_id', $category, isset($movie) ? $movie->category_id : '', [
                                'id' => 'inputname',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('genre', 'Thể loại', []) !!}</br>
                            @foreach ($list_genre as $item)
                                @if (isset($movie))
                                    {!! Form::checkbox('genre[]', $item->id, isset($movie_genre) && $movie_genre->contains($item->id) ? true : false ) !!}
                                @else
                                    {!! Form::checkbox('genre[]', $item->id, '') !!}
                                @endif
                                {!! Form::label('genre', $item->title) !!}
                            @endforeach



                            {{-- {!! Form::select('genre_id', $genre , isset($movie) ? $movie->genre_id : '' , ['id' => 'inputname', 'class' => 'form-control']) !!} --}}
                        </div>


                        <div class="form-group">
                            {!! Form::label('country', 'Quốc gia', []) !!}
                            {!! Form::select('country_id', $country, isset($movie) ? $movie->country_id : '', [
                                'id' => 'inputname',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('year', 'Năm phát hành', []) !!}
                            {!! Form::selectYear('year', '2000', '2025', isset($movie) ? $movie->year : '', [
                                'id' => 'inputname',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('image', 'Poster phim', []) !!}
                            {!! Form::file('image', ['class' => 'form-control-file']) !!}

                            @if ($movie)
                                <br>
                                <img width="30%" src="{{ asset('uploads/movies/' . $movie->image) }}">
                            @endif
                        </div>

                        <div class="form-group">
                            {!! Form::label('status', 'Trạng thái', []) !!}
                            {!! Form::select('status', ['1' => 'Hoàn tất', '0' => 'Phim sắp chiếu'], isset($movie) ? $movie->status : '', [
                                'id' => 'inputname',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('isHot', 'Đề xuất', []) !!}
                            {!! Form::select('isHot', ['1' => 'Đề xuất', '0' => 'Không đề xuất'], isset($movie) ? $movie->isHot : '', [
                                'id' => 'inputname',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('resolution', 'Chất lượng', []) !!}
                            {!! Form::select(
                                'resolution',
                                ['0' => 'Đang cập nhật', '1' => 'Full HD', '2' => 'HD', '3' => 'CAM'],
                                isset($movie) ? $movie->resolution : '',
                                ['id' => 'inputname', 'class' => 'form-control'],
                            ) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('subtitle', 'Ngôn ngữ', []) !!}
                            {!! Form::select('subtitle', ['1' => 'Thuyết minh', '0' => 'Phụ đề'], isset($movie) ? $movie->subtitle : '', [
                                'id' => 'inputname',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        @if (!isset($movie))
                            {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-success ']) !!}
                        @else
                            {!! Form::submit('Cập nhật', ['class' => 'btn btn-success ']) !!}
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

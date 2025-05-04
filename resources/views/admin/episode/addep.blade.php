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
                    <div class="card-header">Thêm tập phim</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {!! Form::open(['route' => 'episode.store', 'method' => 'POST']) !!}

                        @if (isset($movie))
                            <div class="form-group mb-3">
                                {!! Form::label('movie', 'Phim đã chọn') !!}
                                <input type="text" class="form-control" value="{{ $movie->title }}" readonly>
                                <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                            </div>

                            <div class="form-group mb-3">
                                {!! Form::label('ep', 'Tập phim') !!}
                                <select name="ep" id="ep" class="form-control">
                                    @for ($i = 1; $i <= $movie->episode; $i++)
                                        @php
                                            $existing = $movie->episodes->contains('episode', $i);
                                        @endphp
                                        <option value="{{ $i }}" {{ $existing ? 'disabled' : '' }}>
                                            Tập {{ $i }} {{ $existing ? '(đã có)' : '' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                {!! Form::label('link', 'Link phim') !!}
                                {!! Form::text('link', '', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Nhập link tập phim...'
                                ]) !!}
                            </div>
                        @endif

                        {{-- Nút submit --}}
                        <div class="form-group">
                            {!! Form::submit('Thêm tập phim', ['class' => 'btn btn-success']) !!}
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

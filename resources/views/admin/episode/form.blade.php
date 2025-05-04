@extends('layouts.app')

@section('content')
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Quản lý tập phim</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif



                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên phim</th>
                                    <th>Ảnh phim</th>
                                    <th>Tập</th>
                                    <th>Link</th>
                                    <th scope="col">Update</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($episodes as $key => $episode)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $episode->movie->title ?? 'N/A' }}</td>
                                        <td><img width="100%" src="{{ asset('uploads/movies/' . $episode->movie->image) }}"></td>
                                        <td>Tập {{ $episode->episode }}</td>
                                        <td style="max-width: 300px; word-wrap: break-word;">{{ $episode->link }}</td>
                                        <td>
                                            <a href="{{ route('episode.edit', $episode->id) }}"
                                                class="bi bi-arrow-clockwise btn btn-primary"></a>

                                        </td>
                                        <td>
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['episode.destroy', $episode->id],
                                                'onsubmit' => 'return confirm("Xóa tập phim hiện tại?")',
                                            ]) !!}
                                            <button class="bi bi-trash3-fill btn btn-danger"></button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($episodes->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">Chưa có tập phim nào</td>
                                    </tr>
                                @endif
                            </tbody>

                        </table>
                        <a href="{{ route('episode.create') }}" class="btn btn-success">Thêm tập phim</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

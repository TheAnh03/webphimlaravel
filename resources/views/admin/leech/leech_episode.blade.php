@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="container-fluid mt-4">
        <h4 class="mb-4">Danh sách tập phim</h4>

        <form action="{{ route('episode_leech_store') }}" method="POST">
            @csrf
            <input type="hidden" name="movie_id" value="{{ $movie_id }}">

            <table class="table">
                <thead>
                    <tr>
                        <th>Tập</th>
                        <th>Link embed</th>
                        <th>Link m3u8</th>
                        <th>Chọn</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($item[0]['server_data'] ?? [] as $ep)
                        <tr>
                            <td>
                                {{ $ep['name'] }}
                                <input type="hidden" name="episodes[{{ $loop->index }}][episode]"
                                    value="{{ $loop->index + 1 }}">
                            </td>

                            <td>
                                <input type="text" name="episodes[{{ $loop->index }}][link_embed]" class="form-control"
                                    value="{{ $ep['link_embed'] }}" readonly>
                            </td>

                            <td>
                                <input type="text" name="episodes[{{ $loop->index }}][link_m3u8]" class="form-control"
                                    value="{{ $ep['link_m3u8'] }}" readonly>
                            </td>

                            <td>
                                <input type="checkbox" name="episodes[{{ $loop->index }}][selected]" value="on"
                                    checked>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <button type="submit" class="btn btn-success">Lưu tập phim</button>

            <a href="{{ route('episodes.deleteAll', ['movie_id' => $movie_id]) }}" class="btn btn-danger"
                onclick="return confirm('Bạn có chắc muốn xóa tất cả các tập phim?')">
                Xóa tất cả tập
            </a>
        </form>
    </div>
@endsection

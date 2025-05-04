@extends('layouts.app')


@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

    <!-- Modal movie  -->
    <div class="modal fade" id="movieDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><span id="content_title"></span></h4>
                </div>
                <div class="modal-body" id="content_detail">

                </div>
                <div class="modal-footer" style=" display: flex; justify-content:space-between">
                    <div>
                        <span id="movie_content_id"></span>
                    </div>
                    <div>
                        <form id="deleteForm" method="POST" action="" onsubmit="return confirm('Xóa phim hiện tại?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa Phim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal episode  -->
    {{-- <div class="modal fade" id="episodeDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><span id="ep_content_title"></span></h4>
                </div>
                <div class="modal-body" id="ep_content_detail">

                </div>
                <div class="modal-footer" style=" display: flex; justify-content:space-between">
                    <div>
                        <span id="movie_content_id"></span>
                    </div>
                    <div>
                        {{-- <form id="deleteForm" method="POST" action="" onsubmit="return confirm('Xóa phim hiện tại?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa Phim</button>
                        </form> --}}
                    {{-- </div>
                </div>
            </div>
        </div>
    </div> --}} 







    <div class="container-fluid" style="margin-top: 20px">
        <a href="{{ route('movie.create') }}" class="btn btn-success">Thêm phim mới</a>
    </div>
    <div class="container-fluid">

        <div class="table-responsive">
            <table class="table table-hover" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên phim </th>
                        <th scope="col">Poster</th>
                        <th scope="col">Số tập</th>
                        <th scope="col">Thời lượng</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Thể loại</th>
                        <th scope="col">Quốc gia</th>
                        <th scope="col">Chất lượng</th>
                        <th scope="col">Ngôn ngữ</th>
                        <th scope="col">Năm phát hành</th>
                        <th scope="col">Tags</th>
                        <th scope="col">Trailer-URL</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Đề xuất</th>
                        <th scope="col">Lượt xem</th>
                        <th scope="col">Quản lý</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $key => $movie)
                        <tr>
                            <th scope="row">{{ $key }}</th>
                            <td>{{ $movie->title }}</td>

                            <td><img width="60%" src="{{ asset('uploads/movies/' . $movie->image) }}"></td>
                            <td>{{ $movie->episode }} tập</br>
                                <a class="btn btn-warning" href="{{ route('manage-episodes', [$movie->id]) }}">Quản lý</a>
                              
                            </td>

                            <td>{{ $movie->duration }}</td>
                            <td>{{ $movie->slug }}</td>
                            <td>{{ $movie->category->title }}</td>
                            <td>
                                @foreach ($movie->movie_genre as $item)
                                    <span class="badge badge-dark">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            <td>{{ $movie->country->title }}</td>

                            <td>
                                @if ($movie->resolution == 1)
                                    Full HD
                                @elseif($movie->resolution == 2)
                                    HD
                                @elseif($movie->resolution == 3)
                                    CAM
                                @else
                                    Đang cập nhật
                                @endif
                            </td>
                            <td>
                                @if ($movie->subtitle)
                                    Thuyết minh
                                @else
                                    Phụ đề
                                @endif
                            </td>

                            <td>{{ $movie->year }}</td>
                            <td>
                                @if ($movie->tags != null)
                                    {{ substr($movie->tags, 0, 50) }}
                                @else
                                    Chưa cập nhật
                                @endif
                            </td>
                            <td>
                                @if ($movie->trailer != null)
                                    {{ substr($movie->trailer, 0, 100) }}
                                @else
                                    Chưa cập nhật
                                @endif
                            </td>


                         
                            <td>
                                @if ($movie->status)
                                    Hoàn tất
                                @else
                                    Sắp chiếu
                                @endif
                            </td>
                            <td>
                                @if ($movie->isHot)
                                    Có đề xuất
                                @else
                                    Không đề xuất
                                @endif
                            </td>
                            <td>{{ $movie->views()->count()}}</td>
                            <td>
                                <button type="button" data-movie_id="{{ $movie->id }}"
                                    data-movie_slug="{{ $movie->slug }}" class="btn btn-primary btn-lg movie_detail"
                                    data-toggle="modal" data-target="#movieDetailModal">
                                    Quản lý phim
                                </button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>




    </div>
@endsection

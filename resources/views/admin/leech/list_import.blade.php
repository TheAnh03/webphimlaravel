@extends('layouts.app')

@section('content')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<div class="container-fluid" style="margin-top: 20px">
    
<div class="table-responsive">


<table class="table table-hover" id="myTable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tên phim</th>
            <th scope="col">Số tập</th>
            <th scope="col">Poster</th>
            <th scope="col">Slug</th>
           
            <th scope="col">Năm phát hành</th>
            <th scope="col">Quản lý</th>
        </tr>
    </thead>
    <tbody >

        @foreach ($list_import as $key => $item)
            <tr >
                <th scope="row">{{ $key + 1 }}</th>
                <td>{{ $item->title }}</td>
                <td>{{ $item->episode }}
                    <br>
                    <a href="{{route('leech_episodes',$item->slug)}}" class="btn btn-sm btn-warning">quản lý</a>
                </td>
                <td><img width="60%" src="{{ asset('uploads/movies/' . $item->image) }}"></td>
                <td>{{ $item->slug }}</td>
                <td>{{ $item->year }}</td>
                <td>
                    <button type="button" data-movie_id="{{ $item->id }}"
                        data-movie_slug="{{ $item->slug }}" class="btn btn-primary btn-lg movie_detail"
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

@endsection
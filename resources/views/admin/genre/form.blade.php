@extends('layouts.app')

@section('content')
    <div class="">Danh sách thể loại</div>

    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên thể loại</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Chỉnh sửa</th>
                    <th scope="col">Xóa</th>
                </tr>
            </thead>
            <tbody class="sortable" data-route="{{ route('resorting_genre') }}">
                @foreach ($list as $key => $genre)
                    <tr id="{{ $genre->id }}">
                        <th scope="row">{{ $key }}</th>
                        <td>{{ $genre->title }}</td>
                        <td>{{ $genre->description }}</td>
                        <td>{{ $genre->slug }}</td>
                        <td>
                            @if ($genre->status)
                                Hiển thị
                            @else
                                Không hiển thị
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('genre.edit', $genre->id) }}" class="fa fa-pencil btn "></a>
                        </td>
                        <td>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['genre.destroy', $genre->id],
                                'onsubmit' => 'return confirm("Xóa thể loại hiện tại?")',
                            ]) !!}
                            <button class="fa fa-trash btn " style="color: rgba(247, 90, 90, 0.856)"></button>
                            {!! Form::close() !!}
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('genre.create') }}" class="btn btn-success">Thêm thể loại</a>


    </div>
@endsection

@extends('layouts.app')

@section('content')

    <div class="">Danh sách danh mục</div>

    <div class="container-fluid">

{{-- 
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
     --}}

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        {{-- 
            @if (session()->has('flash_notification'))
            @foreach (session('flash_notification') as $message)
                toastr["{{ $message['level'] }}"]("{!! $message['message'] !!}", "{!! $message['title'] ?? '' !!}");
            @endforeach
            @endif --}}


        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên danh mục</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Chỉnh sửa</th>
                    <th scope="col">Xóa</th>
                </tr>
            </thead>
            <tbody class="sortable" data-route="{{ route('resorting_category') }}">

                @foreach ($list as $key => $cate)
                    <tr id="{{ $cate->id }}">
                        <th scope="row">{{ $key }}</th>
                        <td>{{ $cate->title }}</td>
                        <td>{{ $cate->description }}</td>
                        <td>{{ $cate->slug }}</td>
                        <td>
                            @if ($cate->status)
                                Hiển thị
                            @else
                                Không hiển thị
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('category.edit', $cate->id) }}" class="fa fa-pencil btn "></a>
                        </td>
                        <td>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['category.destroy', $cate->id],
                                'onsubmit' => 'return confirm("Xóa danh mục hiện tại?")',
                            ]) !!}
                            <button class="fa fa-trash btn " style="color: rgba(247, 90, 90, 0.856)"></button>
                            {!! Form::close() !!}
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('category.create') }}" class="btn btn-success">Thêm danh mục</a>

    </div>

@endsection

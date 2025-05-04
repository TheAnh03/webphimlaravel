@extends('layouts.app')

@section('content')
    
                    <div class="">Danh sách quốc gia</div>

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
                                    <th scope="col">Tên quốc gia</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Chỉnh sửa</th>
                                    <th scope="col">Xóa</th>
                                </tr>
                            </thead>
                            <tbody class="sortable" data-route="{{ route('resorting_country') }}">
                                @foreach ($list as $key => $coun)
                                    <tr id="{{ $coun->id }}">
                                        <th scope="row">{{ $key }}</th>
                                        <td>{{ $coun->title }}</td>
                                        <td>{{ $coun->description }}</td>
                                        <td>{{ $coun->slug }}</td>
                                        <td>
                                            @if ($coun->status)
                                                Hiển thị
                                            @else
                                                Không hiển thị
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('country.edit', $coun->id) }}"
                                                class="fa fa-pencil btn "></a>
                                        </td>
                                        <td>
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['country.destroy', $coun->id],
                                                'onsubmit' => 'return confirm("Xóa quốc gia hiện tại?")',
                                            ]) !!}
                                            <button class="fa fa-trash btn" style="color: rgba(247, 90, 90, 0.856)"></button>
                                            {!! Form::close() !!}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('country.create') }}" class="btn btn-success">Thêm quốc gia</a>
                    </div>

@endsection

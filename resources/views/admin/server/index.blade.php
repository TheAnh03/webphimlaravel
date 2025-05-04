@extends('layouts.app')

@section('content')
    <div class="">Danh sách server</div>

    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif



    <!-- Modal create -->
    <div class="modal fade" id="serverModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><span id="server_title">Thêm server</span></h4>
                </div>
                <div class="modal-body" id="">
                    {!! Form::open([
                        'route' => 'server.store',
                        'method' => 'POST',
                    ]) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Tên server:', []) !!}
                    {!! Form::text('name', '', [
                        'class' => 'form-control',
                        'placeholder' => 'Nhập vào dữ liệu',
                        'required'=>'required'
                        
                    ]) !!}
                </div>
                  
                </div>
                <div class="modal-footer" style=" display: flex; justify-content:space-between">
                    <div>
                        <span id=""></span>
                    </div>
                    <div>
                        {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-success ']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    










        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên server</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">Ngày chỉnh sửa</th>
                    <th scope="col">Chỉnh sửa</th>
                    <th scope="col">Xóa</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($list as $key => $server)
                    <tr id="{{ $server->id }}">
                        <th scope="row">{{ $key }}</th>
                        <td>{{ $server->name }}</td>
                        <td>{{ $server->created_at }}</td>
                    
                        
                        <td>
                            @if ($server->updated_at)
                                {{$server->updated_at}}
                            @else
                                Không hiển thị
                            @endif
                        </td>
                        <td>
                            <button type="button" 
                            class=" btn btn-primary update_server"
                            data-server_id="{{ $server->id }}"
                            data-server_name="{{ $server->name }}"
                            data-toggle="modal" data-target="#serverModal_update"><i class="fa fa-pencil"></i>
                            
                        </button>
                        </td>
                        <td>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => [
                                    'server.destroy',
                                    $server->id,
                                ],
                                'onsubmit' => 'return confirm("Xóa server hiện tại?")',
                            ]) !!}
                            <button class="fa fa-trash btn btn-danger" ></button>
                            {!! Form::close() !!}
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- <a href="{{ route('server.create') }}" class="btn btn-success">Thêm server</a> --}}
        <button type="button" 
            class="btn btn-warning add_server"
            data-toggle="modal" data-target="#serverModal">
            Thêm server
        </button>
    </div>



<!-- Modal update -->
<div class="modal fade" id="serverModal_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="server_title">Chỉnh sửa server</span></h4>
            </div>
            <div class="modal-body" id="">
                {!! Form::open(['id' => 'update_server_form', 'method' => 'PUT']) !!}
                {!! Form::hidden('server_id', null, ['id' => 'server_id']) !!}

            <div class="form-group">
                {!! Form::label('name', 'Tên server:', []) !!}
                {!! Form::text('name', isset($server) ? $server->name : '', [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập vào dữ liệu',
                    'required'=>'required'
                    
                ]) !!} 
            </div>
              
            </div>
            <div class="modal-footer" style=" display: flex; justify-content:space-between">
                <div>
                    <span id=""></span>
                </div>
                <div>
                    {!! Form::submit('Cập nhật dữ liệu', ['class' => 'btn btn-success ']) !!}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('scripts')

    <script>
$(document).ready(function() {
    $('.update_server').on('click', function () {
        const serverId = $(this).data('server_id');
        const serverName = $(this).data('server_name');

        const url = `/server/${serverId}`; 
        $('#update_server_form').attr('action', url);

        
        $('#update_server_form input[name="name"]').val(serverName);
        $('#server_id').val(serverId);
    });
});
</script>


@endsection
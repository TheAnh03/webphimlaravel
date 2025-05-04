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

    <div class="container">

        <h4>Quản lý tập phim</h4>


        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif


        {!! Form::open(['route' => 'list_episodes_store', 'method' => 'POST', 'id' => 'episode-form']) !!}


        {{-- Chọn phim --}}
        <div class="form-group mb-3">
            {!! Form::label('movie', 'Chọn phim') !!}


            {!! Form::select('movie_id', $list_movie, null, [
                'class' => 'form-control select-movie',
                'placeholder' => '-- Chọn phim --',
            ]) !!}

        </div>
        {{-- Chọn server --}}
        <div class="form-group mb-3">
            {!! Form::label('server', 'Chọn server phim') !!}


            {!! Form::select('server_id', $list_server, null, [
                'class' => 'form-control select-server',
                'placeholder' => '-- Chọn server phim --',
            ]) !!}

        </div>


        <h4>Danh sách tập</h4>
        <button type="button" id="load-episodes-btn" class="btn btn-primary mb-3">
            Tải danh sách tập
        </button>

        {{-- ajax  --}}
        <div id="episode-inputs"></div>


        <div class="form-group" id="btn-create" style="margin-top: 20px; display:none">
            <button type="submit" class="btn btn-success">Thêm mới</button>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $('#load-episodes-btn').on('click', function() {
            let movie_id = $('.select-movie').val();
            let server_id = $('.select-server').val();

            if (!movie_id || !server_id) {
                alert('Vui lòng chọn đầy đủ phim và server!');
                return;
            }

            $.ajax({
                url: '{{ route('episodes-check') }}',
                method: 'GET',
                data: {
                    movie_id: movie_id,
                    server_id: server_id
                },
                success: function(data) {
                    let so_tap = data.episode ?? 1;
                    let da_co = data.da_co ?? [];
                    let html = '';

                    for (let i = 1; i <= so_tap; i++) {
                        let episode_data = da_co.find(ep => ep.episode == i); // tìm dữ liệu tập 
                        let isExisting = !!episode_data;
                        let inputId = `episode-link-${i}`;

                        html += `
                        <div class="form-group mb-3 row align-items-center">
                            <div class="col-md-2">
                                <label style="float:right">
                                    Tập ${i}${isExisting ? ' (đã tồn tại)' : ''}:
                                </label>
                            </div>
                            <div class="col-md-8">
                                <input type="url" id="${inputId}" name="episodes[${i}][link]"
                                    class="form-control"
                                    placeholder="Link phim Tập ${i}"
                                    value="${isExisting ? episode_data.link : ''}"
                                    ${isExisting ? 'readonly' : ''}
                                    data-id="${episode_data ? episode_data.id : ''}">
                            </div>
                            <div class="col-md-2">
                                ${isExisting ? `
                                        <button type="button" class="btn btn-warning btn-sm edit-btn" data-episode="${i}"> <i class="fa fa-pencil" aria-hidden="true"></i> </button>
                                        <button type="button" class="btn btn-success btn-sm save-btn" style="display: none;" data-episode="${i}"> <i class="fa fa-check" aria-hidden="true"></i> </button>
                                        <button type="button" class="btn btn-danger btn-sm delete-episode-btn"
                                        data-id="${episode_data.id}" data-episode="${i}"> <i class="fa fa-trash-o" aria-hidden="true"></i> </button>` : ''}
                            </div>
                        </div>
                    `;
                    }

                    $('#episode-inputs').html(html);
                    $('#btn-create').show();
                },

                error: function() {
                    alert('Có lỗi xảy ra khi lấy tập phim!');
                }
            });
        });
    </script>


{{-- xóa tập --}}
    <script>
        $(document).on('click', '.delete-episode-btn', function() {
            let episodeId = $(this).data('id');
            let episodeNumber = $(this).data('episode');

            if (confirm(`Xác nhận xóa tập ${episodeNumber}?`)) {
                $.ajax({
                    url: `/episode/${episodeId}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(res) {
                        alert('Đã xóa tập thành công!');

                        $('#load-episodes-btn').click(); // reload lại danh sách tập
                    },
                    error: function() {
                        alert('Lỗi khi xóa tập!');
                    }
                });
            }
        });
    </script>
    {{-- sửa tập --}}
    <script>
        $(document).on('click', '.edit-btn', function() {
            const episode = $(this).data('episode');
            const input = $(`#episode-link-${episode}`);
            input.removeAttr('readonly');
            $(this).css('display', 'none'); // ẩn nút sửa
            $(`.save-btn[data-episode="${episode}"]`).css('display', 'inline-block'); // hiện nút lưu
        });

        $(document).on('click', '.save-btn', function() {
            const episode = $(this).data('episode');
            const input = $(`#episode-link-${episode}`);
            const newLink = input.val();
            const episodeId = input.data('id');

            if (!newLink) {
                alert('Link không được để trống!');
                return;
            }

            $.ajax({
                url: `/episode/${episodeId}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    link: newLink
                },
                success: function() {
                    alert('Đã cập nhật link tập thành công!');
                    input.prop('readonly', true);
                    $(`.save-btn[data-episode="${episode}"]`).css('display', 'none');
                    $(`.edit-btn[data-episode="${episode}"]`).css('display', 'inline-block');
                },
                error: function() {
                    alert('Có lỗi khi cập nhật tập!');
                }
            });
        });
    </script>
    {{-- thêm tập --}}
    <script>
        $('form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('list_episodes_store') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    alert(res.message);

                    if (res.status === 'success') {
                        $('#load-episodes-btn').click();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let message = 'Lỗi dữ liệu:\n';
                        for (const key in errors) {
                            message += `- ${errors[key][0]}\n`;
                        }
                        alert(message);
                    } else {
                        alert('Đã xảy ra lỗi không xác định khi gửi dữ liệu.');
                    }
                }
            });
        });
    </script>
@endsection

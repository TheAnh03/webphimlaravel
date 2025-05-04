@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="container-fluid" style="margin-top: 20px">
        <div class="table-responsive">
            <table id="movies-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Tên phim</th>
                        <th scope="col">Poster</th>
                        <th scope="col">Slug</th>
                        <th scope="col">ID</th>
                        <th scope="col">Năm phát hành</th>
                        <th scope="col">Quản lý</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal chi tiết phim -->
    <div class="modal fade" id="chitietphim" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><span id="content_title"></span></h4>
                </div>
                <div class="modal-body" id="content_detail"></div>
                <div class="modal-footer d-flex justify-content-between">
                    <div><span id="movie_content_id"></span></div>
                    <div>
                        <form id="addform" method="POST" action="">
                            @csrf
                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('Xác nhận thêm phim vào cơ sở dữ liệu?')">
                                Thêm Phim
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#movies-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('leech-movie') }}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'full_thumb_url',
                        name: 'thumb_url',
                        render: function(data) {
                            return `<img src="${data}" width="60" height="90"/>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: '_id',
                        name: 'ID'
                    },
                    {
                        data: 'year',
                        name: 'Nam'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <button type="button"
                                data-movie_slug="${row.slug}"
                                data-slug="${row.slug}"
                                class="btn btn-primary btn-sm leech_detail"
                                data-toggle="modal"
                                data-target="#chitietphim">
                                Chi tiết phim
                            </button>
                        `;
                        }
                    }
                ]
            });

            //  modal chi tiết
            $('#chitietphim').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const slug = button.data('slug');
                const form = $('#addform');
                const action = "{{ route('import_leech_movie', ['slug' => '__slug__']) }}".replace(
                    '__slug__', slug);
                form.attr('action', action);


                $.ajax({
                    url: '{{ route('get_leech_detail') }}',
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        slug: slug
                    },
                    success: function(data) {
                        $('#content_title').html(data.content_title);
                        $('#content_detail').html(data.content_detail);
                    },
                    error: function() {
                        alert('Đã xảy ra lỗi khi lấy chi tiết phim!');
                    }
                });
            });
        });
    </script>
@endsection

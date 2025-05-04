@extends('layout')
@section('content')
<div class="row container" id="wrapper">
       
        <div class="halim-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="yoast_breadcrumb hidden-xs"><span><span><span class="breadcrumb_last"
                                        aria-current="page"></span></span></span></div>
                    </div>
                </div>
            </div>
            <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                <div class="ajax"></div>
            </div>
        </div>
        <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
            <section>
                <div class="section-bar clearfix">
                    @if (!empty($error))
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <p>{{ $error }} </p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" style="color:rgb(0, 0, 0)">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    <h3 style="color: #0084ff"><span>Lọc phim</span></h3>
                    <style type="text/css">
                        .stylish_filter {
                            border: 0;
                            background-color: #12171b;
                            color: #fff;
            
                        }
                    </style>
                    <form action="{{ route('filter') }}" method="GET">
                        <div class="row">
            
                            <div class="form-group col-md-3">
                                <select name="category" id="" class="form-control stylish_filter">
                                    <option value="">----Danh mục----</option>
                                    @foreach ($category_view as $key => $item)
                                        <option {{(isset($_GET['category']) && $_GET['category']==$item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <select name="genre" id="" class="form-control stylish_filter">
                                    <option value="">---Thể loại---</option>
                                    @foreach ($genre_view as $key => $item)
                                        <option {{(isset($_GET['genre']) && $_GET['genre']==$item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <select name="country" id="" class="form-control stylish_filter">
                                    <option value="">---Quốc gia---</option>
                                    @foreach ($country_view as $key => $item)
                                        <option {{(isset($_GET['country']) && $_GET['country']==$item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
            
                            <div class="form-group col-md-2">
                                <select name="year" id="" class="form-control stylish_filter">
                                    <option value="">---Năm---</option>
                                    @for ($year = 2000; $year <= 2025; $year++)
                                        <option {{(isset($_GET['year']) && $_GET['year']==$year) ? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
            
                            <div class="form-group col-md-3 ">
                                <select name="order" class="form-control stylish_filter">
                                    <option value="">---Xắp xếp---</option>
                                    <option value="dateupload">theo ngày đăng</option>
                                    <option value="year">theo năm sản xuất</option>
                                    <option value="title">theo tên phim</option>
                                    <option value="view">theo lượt xem</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-1 col-md-offset-7">
                                <input type="submit" value="Tìm kiếm" class="btn box-shadow" id="get-bookmark">
                            </div>
                        </div>
                    </form>
            
                </div>
                <div class="section-bar clearfix">
                    <h1 class="section-title"><span>Kết quả</span></h1>
                </div>
                <div class="halim_box">
                    @if ($list && $list->count() > 0)
                        @foreach ($list as $key => $mov)
                            <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-27021">
                                <div class="halim-item">
                                    <a class="halim-thumb" href="{{ route('movie', $mov->slug) }}"
                                        title="{{ $mov->title }}">
                                        <figure><img class="lazy img-responsive"
                                                src="{{ asset('uploads/movies/' . $mov->image) }}"
                                                title="{{ $mov->title }}"></figure>
                                        <span class="status">
                                            @if ($mov->resolution == 1)
                                                Full HD
                                            @elseif($mov->resolution == 2)
                                                HD
                                            @elseif($mov->resolution == 3)
                                                CAM
                                            @else
                                                Đang cập nhật
                                            @endif
                                        </span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                            @if ($mov->subtitle)
                                                Thuyết minh
                                            @else
                                                Phụ đề
                                            @endif
                                        </span>
                                        <div class="icon_overlay"></div>
                                        <div class="halim-post-title-box">
                                            <div class="halim-post-title ">
                                                <p class="entry-title">{{ $mov->title }}</p>
                                                <p class="original_title">{{ $mov->name_eng }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    

                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                    {!! $list->links('pagination::bootstrap-4') !!}
                </div>
                @else
                        <p>Không tìm thấy kết quả nào.</p>
                    @endif
            </section>
        </main>
        @include('pages.include.sidebar');
    </div>
@endsection




@extends('layout')
@section('content')
<div class="row container" id="wrapper">
    <div class="halim-panel-filter">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6">
                    <div class="yoast_breadcrumb hidden-xs"><span><span>Tài khoản : <span class="breadcrumb_last" aria-current="page"> {{auth()->user()->name}}</span></span></span></div>
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
                <h1 class="section-title"><span>Danh sách theo dõi</span></h1>
            </div>
            <div class="halim_box">
                @if ($favoriteMovies->count() > 0)
                @foreach($favoriteMovies as $key => $mov)
                <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-27021">
                    <div class="halim-item">
                        <a class="halim-thumb" href="{{route('movie',$mov->slug)}}" title="{{$mov->title}}">
                            <figure><img class="lazy img-responsive" src="{{ asset('uploads/movies/' . $mov->image) }}" title="{{$mov->title}}"></figure>
                            <span class="status">
                                @if($mov->resolution==1)
                                        Full HD
                                @elseif($mov->resolution==2)
                                        HD
                                @elseif($mov->resolution==3)
                                        CAM
                                @else
                                        Đang cập nhật
                                @endif     
                            </span>
                            <span class="episode " style="background-color:#b15f5f81; border-radius: 3px; margin: 6px 6px; !important;">
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['removeFavorite',  $mov->id],
                                'onsubmit' => 'return confirm("Bỏ theo dõi phim ?")',
                            ]) !!}
                            <button class="fa fa-times " style="color: #fff ;background: none;
                                    border: none;"></button>
                            {!! Form::close() !!}
                            </span>

                            <div class="icon_overlay"></div>
                            <div class="halim-post-title-box">
                                <div class="halim-post-title ">
                                    <p class="entry-title">{{$mov->title}}</p>
                                    <p class="original_title">{{$mov->name_eng}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
                @endforeach
                @else
                    <p>Chưa có phim nào trong danh sách.</p>
                @endif
                
            </div>
            <div class="clearfix"></div>
            <div class="text-center">
                {{-- <ul class='page-numbers'>
                    <li><span aria-current="page" class="page-numbers current">1</span></li>
                    <li><a class="page-numbers" href="">2</a></li>
                    <li><a class="page-numbers" href="">3</a></li>
                    <li><span class="page-numbers dots">&hellip;</span></li>
                    <li><a class="page-numbers" href="">55</a></li>
                    <li><a class="next page-numbers" href=""><i class="hl-down-open rotate-right"></i></a></li>
                </ul> --}}
                {!! $favoriteMovies->links("pagination::bootstrap-4") !!}
            </div>
        </section>
    </main>
    @include('pages.include.sidebar');
</div>

@endsection
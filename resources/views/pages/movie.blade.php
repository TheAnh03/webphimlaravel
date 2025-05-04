@extends('layout')
@section('content')
<div class="row container" id="wrapper">
    <div class="halim-panel-filter">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6">
                    <div class="yoast_breadcrumb hidden-xs"><span><span><a href="{{route('category',$movie->category->slug)}}">{{ $movie->category->title }}</a> » <span><a href="{{route('country',$movie->country->slug)}}">{{ $movie->country->title }}</a> » <span class="breadcrumb_last" aria-current="page">{{$movie->title}}</span></span></span></span></div>
                </div>
            </div>
        </div>
        <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
            <div class="ajax"></div>
        </div>
    </div>
    <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
        <section id="content" class="test">
            <div class="clearfix wrap-content">

                <div class="halim-movie-wrapper">
                    <div class="title-block">
                        <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="38424">
                            <div class="halim-pulse-ring"></div>
                        </div>
                        <div class="title-wrapper" style="font-weight: bold;">
                            Bookmark
                        </div>
                    </div>
                    <div class="movie_info col-xs-12">
                        <div class="movie-poster col-md-3">

                            <img class="movie-thumb" src="{{ asset('uploads/movies/' . $movie->image) }}" alt="{{$movie->title}}">
                            @if(($movie->status ?? 0) == 1 && ($eps ?? 0) > 0 && isset($first_ep))

                            <div class="bwa-content">
                                <div class="loader"></div>
                                <a href="{{url('xem-phim/'.$movie->slug.'/ep-'.$first_ep->episode.'/ser-'.$first_ep->server_id)}}" class="bwac-btn">
                                    <i class="fa fa-play"></i>
                                </a>
                            </div>
                            @else
                            
                            <a href="#watch_trailer" class="btn btn-primary watch_trailer" style="display: block;"><i class="fa fa-play"></i>Xem trailer</a>
                            @endif


                                {{-- addtofavorite --}}
                                <style>
                                    .addfavorite{
                                        display: block;
                                        top: 5%;
                                        position: absolute;   
                                    }
                                    .addfavorite .btn{
                                        width: 100%;
                                        color: #fff;
                                        opacity:0.8;
                                        transition: .3s all;
                                    }
                                    .addfavorite .btn:hover{
                                        opacity: 1;
                                        
                                    }
                                </style>
                                <div class="addfavorite col-md-12">
                                   
                                     @if(Auth::check())
                                        @if (Auth::user()->favorites()->where('movie_id', $movie->id)->exists())
                                            {{-- Đã theo dõi, hiển thị nút bỏ theo dõi --}}
                                            <form action="{{ route('removeFavorite', $movie->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Bỏ theo dõi">
                                                    <i class="fa fa-heart"></i> Đã theo dõi
                                                </button>
                                            </form>
                                        @else
                                            {{-- Chưa theo dõi, hiển thị nút thêm vào yêu thích --}}
                                            <form action="{{ route('addToFavorite', $movie->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success" title="Thêm vào yêu thích">
                                                    <i class="fa fa-heart-o"></i> Thêm vào yêu thích
                                                </button>
                                            </form>
                                        @endif
                                    
                                    @else

                                    <form action="{{ route('addToFavorite', $movie->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="button" class="btn btn-success" title="Vui lòng đăng nhập để thực hiện hành động này" onclick="alert('Vui lòng đăng nhập để thực hiện hành động này!')">
                                            <i class="fa fa-heart-o"></i> Thêm vào yêu thích
                                        </button>
                                    </form>
                                
                                    @endif
                                    
                                </div>


                        </div>
                        
                        <div class="film-poster col-md-9">
                            <h1 class="movie-title title-1" style="display:block;line-height:35px;margin-bottom: -14px;color: #ffed4d;text-transform: uppercase;font-size: 18px;">{{$movie->title}}</h1>
                            <h2 class="movie-title title-2" style="font-size: 12px;">{{$movie->name_eng}} ({{$movie->year}})</h2>
                            <ul class="list-info-group">
                                <li class="list-info-group-item"><span>Trạng Thái</span> : <span class="quality">
                                @if($movie->status==1)
                                    @if($movie->resolution==1)
                                        Full HD
                                    @elseif($movie->resolution==2)
                                            HD
                                    @elseif($movie->resolution==3)
                                            CAM
                                    @else
                                            Đang cập nhật
                                    @endif
                                    
                                    @else
                                        Trailer
                                    @endif
                                @if($movie->status==1)
                                    </span><span class="episode">
                                    @if($movie->subtitle)
                                    Thuyết minh
                                    @else
                                    Phụ đề
                                    @endif    
                                </span></li>
                                {{-- <li class="list-info-group-item"><span>Điểm IMDb</span> : <span class="imdb">7.2</span></li> --}}
                                <li class="list-info-group-item"><span>Season</span> : {{ $movie->season ?? 'Đang cập nhật' }} </li>
                                <li class="list-info-group-item"><span>Thời lượng</span> : {{$movie->duration}}</li>
                                <li class="list-info-group-item"><span>Số tập</span> : {{$eps}}/{{$movie->episode}}</li>
                                @else
                                <li class="list-info-group-item"><span>Season</span> : Đang cập nhật</li>
                                <li class="list-info-group-item"><span>Thời lượng</span> : Đang cập nhật</li>
                                <li class="list-info-group-item"><span>Số tập</span> : Đang cập nhật</li>

                                @endif
                                
                                <li class="list-info-group-item"><span>Danh mục</span> : <a href="{{route('category',$movie->category->slug)}}" rel="tag">{{$movie->category->title}}</a></li>
                                <li class="list-info-group-item"><span>Thể loại</span> :  
                                    @foreach($movie->movie_genre as $gen)
                                    <a href="{{ route('genre', $gen->slug) }}" rel="tag">{{ $gen->title }}</a>
                                    @if(!$loop->last), @endif
                                    @endforeach
                            </li>
                                <li class="list-info-group-item"><span>Quốc gia</span> : <a href="{{route('country',$movie->country->slug)}}" rel="tag">{{$movie->country->title}}</a></li>
                                <li class="list-info-group-item"><span>Đánh giá</span> : 
                                    @if($movie->ratings()->whereNotNull('ratepoint')->count() > 0)
                                    <span><i class="bi bi-star-fill" style="color: #ffed4dec"></i></span>
                                    <span>{{ $movie->average_rating }} </span> 
                                    <span>({{ $movie->rating_count }} đánh giá)</span></li>
                                    @else
                                    <i>chưa có đánh giá cho phim này</i>
                                    @endif
                                {{-- <li class="list-info-group-item"><span>Đạo diễn</span> : <a class="director" rel="nofollow" href="https://phimhay.co/dao-dien/cate-shortland" title="Cate Shortland">Cate Shortland</a></li>
                                <li class="list-info-group-item last-item" style="-overflow: hidden;-display: -webkit-box;-webkit-line-clamp: 1;-webkit-box-flex: 1;-webkit-box-orient: vertical;"><span>Diễn viên</span> : <a href="" rel="nofollow" title="C.C. Smiff">C.C. Smiff</a>, <a href="" rel="nofollow" title="David Harbour">David Harbour</a>, <a href="" rel="nofollow" title="Erin Jameson">Erin Jameson</a>, <a href="" rel="nofollow" title="Ever Anderson">Ever Anderson</a>, <a href="" rel="nofollow" title="Florence Pugh">Florence Pugh</a>, <a href="" rel="nofollow" title="Lewis Young">Lewis Young</a>, <a href="" rel="nofollow" title="Liani Samuel">Liani Samuel</a>, <a href="" rel="nofollow" title="Michelle Lee">Michelle Lee</a>, <a href="" rel="nofollow" title="Nanna Blondell">Nanna Blondell</a>, <a href="" rel="nofollow" title="O-T Fagbenle">O-T Fagbenle</a></li> --}}
                            </ul>
                            
                            
                        </div>
                    </div>
                    
                   
                </div>
                <div class="clearfix"></div>
                {{-- description --}}
                <div class="section-bar clearfix">
                    <h2 class="section-title"><span style="color:#ffed4d">Nội dung phim</span></h2>
                </div>
                <div class="entry-content htmlwrap clearfix">
                    <div class="video-item halim-entry-box">
                        <article id="post-38424" class="item-content">
                            Phim <a href="{{route('movie',$movie->slug)}}">{{$movie->title}}</a> - <a href="{{url('nam/'.$movie->year)}}">{{$movie->year}}</a> - <a href="{{route('country',$movie->country->slug)}}">{{$movie->country->title}}</a>:
                            <h5>Mô tả:</h5>
                            <p>{{$movie->description}}</p>
                            <h5>Từ Khoá Tìm Kiếm:</h5>
                            @if($movie->tags!=NUll)
                            @php
                                $tags = array();
                                $tags = explode(',', $movie->tags);
                            @endphp
                            @foreach($tags as $key => $tag)
                            <ul>
                                <li><a href="{{url('tags/'.$tag)}}">{{$tag}}</a></li>
                            </ul>

                            @endforeach
                            @else
                                {{$movie->title}}
                            @endif
                            
                        </article>
                    </div>
                </div>
                {{-- trailer --}}
                <div class="section-bar clearfix">
                    <h2 class="section-title" id="watch_trailer"><span style="color:#ffed4d">Trailer phim</span></h2>
                </div>
                <div class="entry-content htmlwrap clearfix" >
                    <div class="video-item halim-entry-box" >
                        <article class="" >
                            <iframe width="100%" height="500" src="https://www.youtube.com/embed/{{$movie->trailer}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            
                        </article>
                    </div>
                </div>
            </div>
        </section>



        <section class="related-movies">
            <div id="halim_related_movies-2xx" class="wrap-slider">
                <div class="section-bar clearfix">
                    <h3 class="section-title"><span>CÓ THỂ BẠN MUỐN XEM</span></h3>
                </div>
                <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
                    @foreach($movie_related->take(10) as $key => $hot)
                    <article class="thumb grid-item post-38498">
                        <div class="halim-item">
                            <a class="halim-thumb" href="{{route('movie',$hot->slug)}}" title="{{$hot->title}}">
                                <figure><img class="lazy img-responsive"
                                        src="{{ asset('uploads/movies/' . $hot->image) }}"
                                        alt="{{$hot->title}}" title="{{$hot->title}}"></figure>
                                <span class="status">
                                    @if($hot->resolution==1)
                                            Full HD
                                    @elseif($hot->resolution==2)
                                            HD
                                    @elseif($hot->resolution==3)
                                            CAM
                                    @else
                                            Đang cập nhật
                                    @endif    
                                </span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                    @if($hot->subtitle)
                                        Thuyết minh
                                    @else
                                        Phụ đề
                                    @endif
                                </span>
                                <div class="icon_overlay"></div>
                                <div class="halim-post-title-box">
                                    <div class="halim-post-title ">
                                        <p class="entry-title">{{$hot->title}}</p>
                                        <p class="original_title">{{$hot->name_eng}}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </article>
                    @endforeach

                </div>
                
            </div>
        </section>
    </main>
    @include('pages.include.sidebar');
</div>
<script type='text/javascript'>
    $(".watch_trailer").click(function(e){
        e.preventDefault();
        var aid = $(this).attr("href");
        $('html,body').animate({scrollTop: $(aid).offset().top},'slow');
    });
</script>
@endsection
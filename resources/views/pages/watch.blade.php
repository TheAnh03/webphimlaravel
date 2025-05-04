@extends('layout')
@section('content')
    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="yoast_breadcrumb hidden-xs"><span><span><a
                                        href="{{ route('category', $movie->category->slug) }}">{{ $movie->category->title }}</a>
                                    » <span><a
                                            href="{{ route('country', $movie->country->slug) }}">{{ $movie->country->title }}</a>
                                        » <span class="breadcrumb_last"
                                            aria-current="page">{{ $movie->title }}</span></span></span></span></div>
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
                    <style>
                        .iframe_phim {
                            width: 100%;
                            height: 500px;
                            position: relative;
                            overflow: hidden;
                            padding-top: 56.25%;
                            /* Tỷ lệ 16:9 responsive */
                        }

                        .iframe_phim iframe {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            border: 0;
                        }
                       
                    </style>


                @if(Str::endsWith($episode->link, '.m3u8'))
                <video id="plyr-player" controls style="width: 100%; height: auto;"></video>
            @else
                <div class="iframe_phim">
                    <iframe src="{{ $episode->link }}" title="Video player"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </div>
            @endif
            


{{-- share  --}}

                    
<div class="button-watch">
    <ul class="halim-social-plugin col-xs-4 hidden-xs">
        
    </ul>
    <ul class="col-xs-12 col-md-8">
        
        <div id="autonext" class="btn-cs autonext">
            <!-- Facebook Share -->
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('watch', ['slug' => $movie->slug, 'ep' => $episode->episode, 'server' => $episode->server_id])) }}" target="_blank">
                <i class="fa fa-facebook"></i> Facebook
            </a>
        </div>
    
        <div id="autonext" class="hidden-xs">
            <!-- Twitter Share -->
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('watch', ['slug' => $movie->slug, 'ep' => $episode->episode, 'server' => $episode->server_id])) }}&text=Check out this movie!&hashtags=movies,watch" target="_blank">
                <i class="fa fa-twitter"></i> Twitter
            </a>
        </div>
        <div id="autonext" class="hidden-xs">
            <!-- Twitter Share -->
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('watch', ['slug' => $movie->slug, 'ep' => $episode->episode, 'server' => $episode->server_id])) }}" target="_blank">
                <i class="fa fa-linkedin-square"></i> LinkedIn
            </a>            
        </div>
        <div id="autonext" class="hidden-xs">
            <!-- Twitter Share -->
            <a href="https://api.whatsapp.com/send?text={{ urlencode(route('watch', ['slug' => $movie->slug, 'ep' => $episode->episode, 'server' => $episode->server_id])) }}" target="_blank">
                <i class="bi bi-whatsapp"></i> WhatsApp
            </a>                       
        </div>
        
        <div class="luotxem"><i class="fa fa-heart"></i>
            <span>{{$movie->usersWhoFavorited->count()}}</span> người quan tâm
        </div>
        <div class="luotxem"><i class="fa fa-eye"></i>
            <span>{{$movie->views->count()}}</span> lượt xem
        </div>
    </ul>
    
</div>



                    <div class="collapse" id="moretool">
                        <ul class="nav nav-pills x-nav-justified">
                            <li class="fb-like" data-href="" data-layout="button_count" data-action="like"
                                data-size="small" data-show-faces="true" data-share="true"></li>
                            <div class="fb-save" data-uri="" data-size="small"></div>
                        </ul>
                    </div>

                    <div class="clearfix"></div>
                    <div class="clearfix"></div>
                    <div class="title-block">
                        <a href="javascript:;" data-toggle="tooltip" title="Add to bookmark">
                            <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="37976">
                                <div class="halim-pulse-ring"></div>
                            </div>
                        </a>
                        <div class="title-wrapper-xem full">
                            <h1 class="entry-title"><a href="#" title="{{ $movie->title }}"
                                    class="tl">{{ $movie->title }}</a></h1>
                        </div>
                    </div>
                    <div class="entry-content htmlwrap clearfix collapse" id="expand-post-content">
                        <article id="post-37976" class="item-content post-37976"></article>
                    </div>
                    <div class="clearfix"></div>
                    <div class="text-center">
                        <div id="halim-ajax-list-server"></div>
                    </div>
                    <div id="halim-list-server">
                        <ul class="nav nav-tabs" role="tablist">
                            @if ($movie->resolution == 1)
                                <li role="presentation" class="active server-1">
                                    <a href="#server-0" aria-controls="server-0" role="tab" data-toggle="tab"><i
                                            class="hl-server"></i> Full HD</a>
                                </li>
                            @elseif($movie->resolution == 2)
                                <li role="presentation" class="active server-1">
                                    <a href="#server-0" aria-controls="server-0" role="tab" data-toggle="tab"><i
                                            class="hl-server"></i> HD</a>
                                </li>
                            @elseif($movie->resolution == 3)
                                <li role="presentation" class="active server-1">
                                    <a href="#server-0" aria-controls="server-0" role="tab" data-toggle="tab"><i
                                            class="hl-server"></i> CAM</a>
                                </li>
                            @else
                                <li role="presentation" class="active server-1">
                                    <a href="#server-0" aria-controls="server-0" role="tab" data-toggle="tab"><i
                                            class="hl-server"></i> Đang cập nhật</a>
                                </li>
                            @endif

                        </ul>
                   

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active server-1" id="server-0">
                                <div class="halim-server">
                                    <ul class="halim-list-eps">
                                        @foreach ($episodes_by_server as $sid => $episodes)
                                        <div class="mb-3">
                                            <h5>Nguồn phát: {{ $episodes->first()->server->name ?? 'dự phòng' }}</h5>
                                            @foreach ($episodes as $episodeItem)
                                                <a href="{{ url('xem-phim/'.$movie->slug.'/ep-'.$episodeItem->episode.'/ser-'.$sid) }}" >
                                                   <li class="halim-episode"><span
                                                    class="halim-btn halim-btn-2 {{ $episodeItem->episode == $tapphim && $sid == $server_id ? 'active' : ' ' }} halim-info-1-2 box-shadow"
                                                    data-post-id="37976" data-server="1" data-episode="1"
                                                    data-position="" data-embed="0"
                                                    data-title="Xem phim {{ $movie->title }} - Tập {{ $episodeItem->episode }} - {{ $movie->name_eng }} - vietsub + Thuyết Minh"
                                                    data-h1="{{ $movie->title }} - tập {{ $episodeItem->episode }}">{{ $episodeItem->episode }}</span>
                                                    </li>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endforeach
          

                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>


                        
                    </div>
                    <div class="clearfix"></div>

                    {{-- rating --}}
                    <style>
                        .rating {
                            direction: rtl;
                            display: flex;
                            justify-content: flex-start;
                        }

                        .rating input {
                            display: none;
                        }

                        .rating .star-label {
                            color: #ddd;
                            font-size: 2rem;
                            cursor: pointer;
                            transition: color 0.3s ease;
                        }

                        .rating input:checked~.star-label,
                        .rating .star-label:hover,
                        .rating .star-label:hover~.star-label {
                            color: #ffbc00;
                        }

                        .rating input:checked~.star-label {
                            color: #ffbc00;
                        }

                        .comment {
                            border-bottom: 1px solid #eee;
                            margin-bottom: 1rem;
                            padding-bottom: 1rem;
                        }

                        .comment .stars {
                            margin-bottom: 0.5rem;
                        }

                        .comment .stars .fa-star {
                            color: #ddd;
                        }

                        .comment .stars .fa-star.checked {
                            color: #ffbc00;
                        }
                    </style>



                    <div class="htmlwrap clearfix">
                        <div class="comments-section">
                            <div class="section-bar clearfix">
                                <h3 class="section-title"><span>Bình luận</span></h3>
                            </div>

                            @foreach ($movie->ratings as $rating)
                                <div class="comment">
                                    <img src="{{ asset('uploads/logo/' . $rating->user->avatar) }}" alt="Avatar"
                                        class="rounded-circle"
                                        style="width: 50px; height: 50px; object-fit: cover; margin-right: 8px; border-radius:50%">
                                    <strong>{{ $rating->user->name }}</strong>
                                    <div class="stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star {{ $i <= $rating->ratepoint ? 'checked' : '' }}"></i>
                                        @endfor
                                    </div>
                                    @auth
                                        @if (auth()->id() == $rating->user_id)
                                            <form action="{{ route('comment.destroy', $rating->id) }}" method="POST"
                                                style="margin-top: 5px;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" style="float: right; "
                                                    onclick="return confirm('Xoá bình luận này?')">Xoá đánh giá</button>
                                            </form>
                                        @endif
                                    @endauth
                                    <p>{{ $rating->comment }}</p>
                                    <small>{{ $rating->created_at->diffForHumans() }}</small>


                                </div>
                            @endforeach
                        </div>
                        <div class="section-bar clearfix">
                            <h3 class=""><span>Đăng bình luận</span></h3>
                        </div>

                        @if (auth()->check())
                            <form action="{{ route('rating.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="movie_id" value="{{ $movie->id }}">

                                <div class="form-group">
                                    <label for="comment">Bình luận</label>
                                    <textarea name="comment" class="form-control" rows="3" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Đánh giá</label>
                                    <div class="rating">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="ratepoint"
                                                value="{{ $i }}" class="star-input">
                                            <label for="star{{ $i }}" class="star-label">
                                                <i class="fa fa-star"></i>
                                            </label>
                                        @endfor
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Gửi</button>
                            </form>
                        @else
                            <p><a href="{{ route('login') }}">Đăng nhập</a> để bình luận và đánh giá.</p>
                        @endif



                    </div>
            </section>
            <section class="related-movies">
                <div id="halim_related_movies-2xx" class="wrap-slider">
                    <div class="section-bar clearfix">
                        <h3 class="section-title"><span>CÓ THỂ BẠN MUỐN XEM</span></h3>
                    </div>
                    <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
                        @foreach ($movie_related->take(10) as $key => $hot)
                            <article class="thumb grid-item post-38498">
                                <div class="halim-item">
                                    <a class="halim-thumb" href="{{ route('movie', $hot->slug) }}"
                                        title="{{ $hot->title }}">
                                        <figure><img class="lazy img-responsive"
                                                src="{{ asset('uploads/movies/' . $hot->image) }}"
                                                alt="{{ $hot->title }}" title="{{ $hot->title }}"></figure>
                                        <span class="status">
                                            @if ($hot->resolution == 1)
                                                Full HD
                                            @elseif($hot->resolution == 2)
                                                HD
                                            @elseif($hot->resolution == 3)
                                                CAM
                                            @else
                                                Đang cập nhật
                                            @endif
                                        </span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                            @if ($hot->subtitle)
                                                Thuyết minh
                                            @else
                                                Phụ đề
                                            @endif
                                        </span>
                                        <div class="icon_overlay"></div>
                                        <div class="halim-post-title-box">
                                            <div class="halim-post-title ">
                                                <p class="entry-title">{{ $hot->title }}</p>
                                                <p class="original_title">{{ $hot->name_eng }}</p>
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
        @include('pages.include.sidebar')
    </div>
@endsection
@section('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(Str::endsWith($episode->link, '.m3u8'))
        const video = document.getElementById('videoPlayer');
        const videoSrc = '{{ $episode->link }}';

        if (Hls.isSupported()) {
            const hls = new Hls();
            hls.loadSource(videoSrc);
            hls.attachMedia(video);
            hls.on(Hls.Events.MANIFEST_PARSED, function () {
                video.play();
            });
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            // Safari support
            video.src = videoSrc;
            video.addEventListener('loadedmetadata', function () {
                video.play();
            });
        }
    @endif
});
</script> --}}



<!-- Plyr CSS -->
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />

<!-- Plyr JS -->
<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>

<!-- hls.js -->
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        @if(Str::endsWith($episode->link, '.m3u8'))
            const video = document.getElementById('plyr-player');
            const source = '{{ $episode->link }}';
    
            if (Hls.isSupported()) {
                const hls = new Hls();
                hls.loadSource(source);
                hls.attachMedia(video);
                hls.on(Hls.Events.MANIFEST_PARSED, function () {
                    const player = new Plyr(video, {
                        controls: [
                            'play-large', 'play', 'progress', 'current-time',
                            'mute', 'volume', 'settings', 'fullscreen'
                        ],
                        settings: ['quality', 'speed', 'loop']
                    });
                });
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                video.src = source;
                const player = new Plyr(video);
            }
        @endif
    });
    </script>
    












@endsection
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta name="theme-color" content="#234556">
    <meta http-equiv="Content-Language" content="vi" />
    <meta content="VN" name="geo.region" />
    <meta name="DC.language" scheme="utf-8" content="vi" />
    <meta name="language" content="Việt Nam">


    <link rel="shortcut icon" href="{{ asset('uploads/logo/' . $info->logo) }}" type="image/x-icon" />
    <meta name="revisit-after" content="1 days" />
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
    <title>{{ $info->title }}</title>
    <meta name="description"
        content="Phim hay 2021 - Xem phim hay nhất, xem phim online miễn phí, phim hot , phim nhanh" />
    <link rel="canonical" href="">
    <link rel="next" href="" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:title" content="Phim hay 2020 - Xem phim hay nhất" />
    <meta property="og:description"
        content="Phim hay 2020 - Xem phim hay nhất, phim hay trung quốc, hàn quốc, việt nam, mỹ, hong kong , chiếu rạp" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="Phim hay 2021- Xem phim hay nhất" />
    <meta property="og:image" content="" />
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="55" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel='dns-prefetch' href='//s.w.org' />

    <link rel='stylesheet' id='bootstrap-css' href="{{ asset('css/bootstrap.min.css') }}?ver=5.7.2" media='all' />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel='stylesheet' id='style-css' href="{{ asset('css/style.css') }}?ver=5.7.2" media='all' />
    <link rel='stylesheet' id='wp-block-library-css' href="{{ asset('css/style.min.css') }}?ver=5.7.2" media='all' />
    <script type='text/javascript' src="{{ asset('js/jquery.min.js') }}?ver=5.7.2" id='halim-jquery-js'></script>
    <style type="text/css" id="wp-custom-css">
        .textwidget p a img {
            width: 100%;
        }
    </style>
    <style>
        #header .site-logo {
            max-width: 100%;
            height: 100px;
        }
    </style>
</head>

<body class="home blog halimthemes halimmovies" data-masonry="">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <header id="header">
        <div class="container">
            <div class="row" id="headwrap">
                <div class="col-md-3 col-sm-6 slogan">
                    <a class="logo" href="" title="phim hay ">
                        <img class="site-logo" src="{{ asset('uploads/logo/' . $info->logo) }}">
                    </a>
                </div>
                <div class="col-md-5 col-sm-6 halim-search-form hidden-xs">
                    <div class="header-nav">
                        <form action="{{ route('search') }}" method="GET" style="width: 100%;">
                            <div class="input-group" style="margin-top: 20px">
                                <input id="search" type="text" name="search" class="form-control"
                                    placeholder="Tìm kiếm..." autocomplete="off" required style="flex: 1; ">

                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary "
                                        style="padding: 8px 12px; background-color:#17242e; color:#fff">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                        <ul class="list-group search-result-dropdown" id="result" style="display: none"></ul>
                    </div>
                </div>

                <style>
                    .head-dpdn {
                        position: absolute;
                        top: 40px;
                        right: 30%;
                        z-index: 2000;
                        list-style: none;
                        width: 80%;
                    }

                    .head-dpdn .dropdown-menu {
                        z-index: 1050;
                        position: relative;
                        top: 50px;
                    }
                </style>

                <div class="profile_details col-md-4 col-sm-3" style="display:flex; justify-content:end">
                    @if (Auth::check())
                        <ul class="nofitications-dropdown">
                            <li class="dropdown head-dpdn">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false" style="color:#ffffff"><i class="fa fa-bell"></i>
                                    <sup>{{ $notifications->where('is_read', false)->count() }}</sup></a>
                                {{-- <ul class="dropdown-menu" style="width: 100%">
                                <li>
                                    <div class="notification_header">
                                        <h5>Bạn có ... thông báo</h5>
                                    </div>
                                </li>
                                <li class="" >
                                    <a href="#">
                                        <div class="row">
                                            <img src="https://fagopet.vn/storage/39/rz/39rz64dkbjiu365ovy4kdnfol26z_ban-cho-canh-8.webp" alt="" style="width: auto; height:90px" />
                                        
                                        <span style="float:right; padding-right:60px">
                                            <p>Đã có tập phim mới </p>
                                            <p><span>1 hour ago</span></p>
                                        </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a>
                                </li>
                               
                                <li>
                                    <div class="notification_bottom" style="display:flex; justify-content:center">
                                        <a href="#" >Xóa tất cả</a>
                                    </div>
                                </li>
                            </ul> --}}


                                <ul class="dropdown-menu" style="max-height: 300px; overflow-y: auto; width: 100%">
                                    <li>
                                        <div class="notification_header">
                                            <h5 style="padding-left: 20px">Bạn có {{ $notifications->where('is_read', false)->count() }} thông báo
                                            </h5>
                                        </div>
                                    </li>
                                    @foreach ($notifications as $noti)
                                        @if ($noti->movie && $noti->movie->image)
                                            <li>
                                                <a href="{{ route('notification.read', $noti->id) }}"
                                                    style="text-decoration: none; color: inherit;">
                                                    <div style="display: flex; align-items: center; ">
                                                        <img src="{{ asset('uploads/movies/' . $noti->movie->image) }}"
                                                            style="width: 90px; height: 90px; object-fit: cover; border-radius: 6px; margin-right: 10px;" />

                                                        <div style="flex: 1;">
                                                            <p style="margin: 0; font-weight: bold;">
                                                                {{ $noti->message }}</p>
                                                            <p style="margin: 0; font-size: 12px; color: #888;">
                                                                {{ $noti->created_at->diffForHumans() }}</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach

                                    <li>
                                        <div class="notification_bottom" style="text-align: center">
                                            <form action="{{ route('notification.clear') }}" method="POST">
                                                @csrf
                                                <button class="btn btn-link">Xóa tất cả</button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>




                            </li>
                        </ul>

                        <ul class="header-nav col-md-8" style="margin-top: 20px;">

                            <li class="nav-item dropdown profile_details_drop"
                                style="list-style: none; z-index: 1040">


                                <span>
                                    <img src="{{ asset('uploads/logo/' . auth()->user()->avatar) }}" alt="Avatar"
                                        class="rounded-circle"
                                        style="width: 50px; height: 50px; object-fit: cover; margin-right: 8px; border-radius:50%">

                                </span>

                                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center"
                                    style="width: 0%" data-toggle="dropdown" aria-expanded="false"><span> <i
                                            class="bi bi-caret-down-fill ml-2"></i></span></a>


                                <ul class="dropdown-menu dropdown-menu-right">
                                    @role('admin')
                                        <li>
                                            <a class="dropdown-item" href="/home">
                                                <i class="fa fa-dashboard"></i> Admin dashboard
                                            </a>
                                        </li>
                                    @endrole

                                    @if (!auth()->user()->hasVerifiedEmail())
                                        <li>
                                            <p>
                                                <span class="text-warning"><i class="fa fa-exclamation-circle"></i>Tài
                                                    khoản chưa xác minh</span>
                                            <p>
                                        </li>
                                    @endif

                                    <li>
                                        <a class="dropdown-item" href="{{ route('show_profile') }}">
                                            <i class="fa fa-user"></i> Thông tin tài khoản
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('favoritelist') }}">
                                            <i class="fa fa-suitcase"></i> Danh sách theo dõi
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('user.history') }}">
                                            <i class="fa fa-history"></i> Lịch sử
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="dropdown-item"
                                                style="border: none; background: none; padding: 8px 20px;">
                                                <i class="fa fa-sign-out"></i> Đăng xuất
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary d-flex align-items-center" style="margin-top:20px">
                                    <i class="fa fa-sign-in-alt"></i> <span class="ml-2">Đăng nhập</span>
                                </a>
                    @endif
                    </li>
                    </ul>

                </div>



            </div>
        </div>
    </header>
    <div class="navbar-container">
        <div class="container">
            <nav class="navbar halim-navbar main-navigation" role="navigation" data-dropdown-hover="1">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse"
                        data-target="#halim" aria-expanded="false">
                        <span class="sr-only">Menu</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <button type="button" class="navbar-toggle collapsed pull-right " data-toggle="collapse"
                        data-target="#search-form" aria-expanded="false">
                        <span class="hl-search" aria-hidden="true"></span>
                    </button>

                    {{-- <button type="button" class="navbar-toggle collapsed pull-right get-locphim-on-mobile">
                        <a href="{{url('pages.filter')}}" id="expand-ajax-filter" style="color: #ffed4d;"><i
                                class="fas fa-filter">Lọc Phim </i></a>
                    </button> --}}
                </div>
                <div class="collapse navbar-collapse" id="halim">
                    <div class="menu-menu_1-container">
                        <ul id="menu-menu_1" class="nav navbar-nav navbar-left">
                            <li class="current-menu-item active"><a title="Trang Chủ"
                                    href="{{ route('homepage') }}">Trang Chủ</a></li>
                            <li class="mega dropdown">
                                <a title="Thể Loại" href="#" data-toggle="dropdown" class="dropdown-toggle"
                                    aria-haspopup="true">Thể Loại <span class="caret"></span></a>
                                <ul role="menu" class=" dropdown-menu">
                                    @foreach ($genre_view as $key => $genre)
                                        <li><a title="{{ $genre->title }}"
                                                href="{{ route('genre', $genre->slug) }}">{{ $genre->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="mega dropdown">
                                <a title="Quốc Gia" href="#" data-toggle="dropdown" class="dropdown-toggle"
                                    aria-haspopup="true">Quốc Gia <span class="caret"></span></a>
                                <ul role="menu" class=" dropdown-menu">
                                    @foreach ($country_view as $key => $coun)
                                        <li><a title="{{ $coun->title }}"
                                                href="{{ route('country', $coun->slug) }}">{{ $coun->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="mega dropdown">
                                <a title="Năm" href="#" data-toggle="dropdown" class="dropdown-toggle"
                                    aria-haspopup="true">Năm<span class="caret"></span></a>
                                <ul role="menu" class=" dropdown-menu">
                                    @for ($year = 2000; $year <= 2025; $year++)
                                        <li>
                                            <a title="{{ $year }}"
                                                href="{{ url('nam/' . $year) }}">{{ $year }}</a>
                                        </li>
                                    @endfor
                                </ul>
                            </li>

                            @foreach ($category_view as $key => $cate)
                                <li class="mega"><a title="{{ $cate->title }}"
                                        href="{{ route('category', $cate->slug) }}">{{ $cate->title }}</a></li>
                            @endforeach



                        </ul>
                    </div>
                    <ul class="nav navbar-nav navbar-left" style="background:#000;">
                        <li><a href="{{ url('/filter') }}" style="color: #ffed4d;">Lọc Phim</a></li>
                    </ul>
                </div>
            </nav>
            <div class="collapse navbar-collapse" id="search-form">
                <div id="mobile-search-form" class="halim-search-form"></div>
            </div>
            <div class="collapse navbar-collapse" id="user-info">
                <div id="mobile-user-login"></div>
            </div>
        </div>
    </div>
    </div>

    <div class="container">
        <div class="row fullwith-slider"></div>
    </div>
    <div class="container">
        @yield('content');
    </div>
    <div class="clearfix"></div>
    <footer id="footer" class="clearfix">
        <div class="container footer-columns">
            <div class="row container">
                <div class="widget about col-xs-12 col-sm-4 col-md-4">
                    <div class="footer-logo">
                        <img class="site-logo" src="{{ asset('uploads/logo/' . $info->logo) }}">
                    </div>
                    {{-- Liên hệ QC: <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                        data-cfemail="e5958d8c888d849ccb868aa58288848c89cb868a88">[email&#160;protected]</a> --}}
                </div>
                <div class="widget about col-xs-12 col-sm-4 col-md-8">
                    <div class="">
                        <p>
                            {{ $info->description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div id='easy-top'></div>
    <script type='text/javascript' src='{{ asset('js/bootstrap.min.js') }}?ver=5.7.2' id='bootstrap-js'></script>

    <script type='text/javascript' src='{{ asset('js/owl.carousel.min.js') }}?ver=5.7.2' id='carousel-js'></script>
    
    <script type='text/javascript' src='{{ asset('js/halimtheme-core.min.js') }}?ver=1626273138' id='halim-init-js'></script>
    
    <script type='text/javascript'>
        $(document).ready(function($) {
            var owl = $('#halim_related_movies-2');
            owl.owlCarousel({
                loop: true,
                margin: 4,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                nav: true,
                navText: ['<i class="bi bi-chevron-double-left" style=""></i>',
                    '<i class="bi bi-chevron-double-right"></i>'
                ],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    480: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    1024: {
                        items: 4
                    },
                    1200: {
                        items: 5
                    }


                }
            })
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#search').keyup(function() {
                $('#result').html('');
                var search = $('#search').val();

                if (search != '') {
                    var expression = new RegExp(search, "i");
                    $.getJSON('/json/movie.json', function(data) {
                        $.each(data, function(key, value) {
                            if ((value.title && value.title.search(expression) != -1) ||
                                (value.tags && value.tags.search(expression) != -1)) {

                                $('#result').css('display', 'block');
                                $('#result').append(`
                                <li class="list-group-item d-flex align-items-center" style="cursor: pointer;">
                                    <img src="/uploads/movies/${value.image}" alt="${value.title}" style="width: 50px; height: 60px; object-fit: cover; border-radius: 4px; margin-right: 10px;">
                                    <span style="color: #fff;">${value.title}</span>
                                </li>
                            `);
                            }
                        });
                    });
                } else {
                    $('#result').css('display', 'none');
                }
            });

            $('#result').on('click', 'li', function() {
                var selectedTitle = $(this).text();
                $('#search').val($.trim(selectedTitle));
                $('#result').html('').hide();
            });
        });
    </script>






    <style>
        #overlay_mb {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 99999;
            cursor: pointer
        }

        #overlay_mb .overlay_mb_content {
            position: relative;
            height: 100%
        }

        .overlay_mb_block {
            display: inline-block;
            position: relative
        }

        #overlay_mb .overlay_mb_content .overlay_mb_wrapper {
            width: 600px;
            height: auto;
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            text-align: center
        }

        #overlay_mb .overlay_mb_content .cls_ov {
            color: #fff;
            text-align: center;
            cursor: pointer;
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 999999;
            font-size: 14px;
            padding: 4px 10px;
            border: 1px solid #aeaeae;
            background-color: rgba(0, 0, 0, 0.7)
        }

        #overlay_mb img {
            position: relative;
            z-index: 999
        }

        @media only screen and (max-width: 768px) {
            #overlay_mb .overlay_mb_content .overlay_mb_wrapper {
                width: 400px;
                top: 3%;
                transform: translate(-50%, 3%)
            }
        }

        @media only screen and (max-width: 400px) {
            #overlay_mb .overlay_mb_content .overlay_mb_wrapper {
                width: 310px;
                top: 3%;
                transform: translate(-50%, 3%)
            }
        }
    </style>

    <style>
        #overlay_pc {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 99999;
            cursor: pointer;
        }

        #overlay_pc .overlay_pc_content {
            position: relative;
            height: 100%;
        }

        .overlay_pc_block {
            display: inline-block;
            position: relative;
        }

        #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
            width: 600px;
            height: auto;
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        #overlay_pc .overlay_pc_content .cls_ov {
            color: #fff;
            text-align: center;
            cursor: pointer;
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 999999;
            font-size: 14px;
            padding: 4px 10px;
            border: 1px solid #aeaeae;
            background-color: rgba(0, 0, 0, 0.7);
        }

        #overlay_pc img {
            position: relative;
            z-index: 999;
        }

        @media only screen and (max-width: 768px) {
            #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
                width: 400px;
                top: 3%;
                transform: translate(-50%, 3%);
            }
        }

        @media only screen and (max-width: 400px) {
            #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
                width: 310px;
                top: 3%;
                transform: translate(-50%, 3%);
            }
        }
    </style>

    <style>
        .float-ck {
            position: fixed;
            bottom: 0px;
            z-index: 9
        }

        * html .float-ck

        /* IE6 position fixed Bottom */
            {
            position: absolute;
            bottom: auto;
            top: expression(eval (document.documentElement.scrollTop+document.docum entElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop, 10)||0)-(parseInt(this.currentStyle.marginBottom, 10)||0)));
        }

        #hide_float_left a {
            background: #0098D2;
            padding: 5px 15px 5px 15px;
            color: #FFF;
            font-weight: 700;
            float: left;
        }

        #hide_float_left_m a {
            background: #0098D2;
            padding: 5px 15px 5px 15px;
            color: #FFF;
            font-weight: 700;
        }

        span.bannermobi2 img {
            height: 70px;
            width: 300px;
        }

        #hide_float_right a {
            background: #01AEF0;
            padding: 5px 5px 1px 5px;
            color: #FFF;
            float: left;
        }

        .movie_season_list a {
            display: inline-block;
            color: #fff;
            background: #22222200;
            padding: 6px 10px;
            margin: 0 4px;
            min-width: 60px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #fff;
            border-radius: 4px;

            white-space: nowrap;
        }

        .movie_season_list .season_item a.active {
            background: #fdfeff00;
            color: #ffe200;
            border-color: #ffffff;
            font-weight: 600;
        }
    </style>
    <style>
        .position-relative {
            position: relative;
        }

        .search-result-dropdown {
            position: absolute;
            top: 100%;
            width: 100%;
            left: 0;
            right: 0;
            list-style-type: none;
            padding-left: 0;
            z-index: 1000;
            max-height: 300px;
            overflow-y: auto;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .search-result-dropdown li {
            background: rgba(26, 23, 23, 0.062);
            backdrop-filter: blur(5px);
            cursor: pointer;
            padding: 10px;
            transition: background 0.2s;
        }

        .search-result-dropdown li:hover {
            background-color: rgba(255, 255, 255, 0.5);
            font-weight: bold;
        }
    </style>

    @yield('scripts')
</body>

</html>

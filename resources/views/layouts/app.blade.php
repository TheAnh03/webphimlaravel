<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>

<head>
    <title>
        ADMIN WEB PHIM
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="ADMIN WEB PHIM" />
    <script type="application/x-javascript">
      addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);

                      function hideURLbar() { window.scrollTo(0, 1); }
    </script>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('backend/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- font-awesome icons CSS -->
    <link href="{{ asset('backend/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- //font-awesome icons CSS-->
    <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    {{-- //datatable CSS --}}
    <!-- side nav css file -->
    <link href="{{ asset('backend/css/SidebarNav.min.css') }}" media="all" rel="stylesheet" type="text/css" />
    <!-- //side nav css file -->
    {{-- jquery --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

    <!--webfonts-->
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext"
        rel="stylesheet" />
    <!--//webfonts-->

    <!-- Metis Menu -->
    <script src="{{ asset('backend/js/custom.js') }}"></script>
    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet" />
    <!--//Metis Menu -->
    <style>
    
        .sortable tr {
            cursor: move;
        }

       
        .ui-state-highlight {
            background: #f0f0f0;
            height: 50px;
            border: 2px dashed #ccc;
        }

       
        table.table tbody tr:hover {
            background-color: #f9f9f9;
        }

     
        button.btn,
        a.btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
        }

        .sortable tr {
            transition: all 0.2s ease;
        }
    </style>




</head>

<body class="cbp-spmenu-push">
    @if (Auth::check())
        <div class="main-content">
            <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
                <!--left-fixed -navigation-->
                <aside class="sidebar-left">
                    <nav class="navbar navbar-inverse">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target=".collapse" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <h1>
                                <a class="navbar-brand" href="{{ url('/home') }}"><span class="fa fa-database"></span>
                                    Home<span class="dashboard_text">Amin dashboard</span></a>
                            </h1>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="sidebar-menu">
                                <li class="header">MAIN NAVIGATION</li>
                                <li class="treeview">
                                    <a href="{{ url('/home') }}">
                                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                                    </a>
                                </li>
                                @php
                                    $segment = Request::segment(1);
                                @endphp
                                <li class="treeview {{ $segment == 'movie' ? 'active' : '' }}">
                                    <a href="#">
                                        <i class="fa fa-film"></i>
                                        <span>Quản lý phim</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="{{ route('movie.index') }}"><i class="fa fa-angle-right"></i> Danh
                                                sách phim</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('movie.create') }}"><i class="fa fa-angle-right"></i>
                                                Thêm phim</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="treeview {{ $segment == 'leech' ? 'active' : '' }}">
                                    <a href="#">
                                        <i class="fa fa-cloud-upload"></i>
                                        <span>Leech Phim</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        
                                        <li>
                                            <a href="{{route('leech-movie')}}"><i class="fa fa-angle-right"></i>
                                                Leech phim</a>
                                        </li>
                                        <li>
                                            <a href="{{route('get_list_import')}}"><i class="fa fa-angle-right"></i>
                                                Phim đã thêm</a>
                                        </li>
                                    </ul>
                                </li>
                               
                                <li class="treeview {{ $segment == 'server' || $segment == 'episode' ? 'active' : '' }}">
                                    <a href="#">
                                        <i class="fa fa-hdd-o"></i>
                                        <span>Quản lý server</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="{{ route('server.index') }}"><i class="fa fa-angle-right"></i>
                                                Danh sách server</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('episode.create') }}"><i class="fa fa-angle-right"></i>
                                                Quản lý tập phim</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="treeview {{ $segment == 'category' ? 'active' : '' }}">
                                    <a href="#">
                                        <i class="fa fa-folder-open"></i>
                                        <span>Quản lý danh mục</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="{{ route('category.index') }}"><i class="fa fa-angle-right"></i>
                                                Danh sách danh mục</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('category.create') }}"><i class="fa fa-angle-right"></i>
                                                Thêm danh mục</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="treeview {{ $segment == 'genre' ? 'active' : '' }}">
                                    <a href="#">
                                        <i class="fa fa-hashtag"></i>
                                        <span>Quản lý thể loại</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="{{ route('genre.index') }}"><i class="fa fa-angle-right"></i> Danh
                                                sách thể loại</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('genre.create') }}"><i class="fa fa-angle-right"></i>
                                                Thêm thể loại</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="treeview {{ $segment == 'country' ? 'active' : '' }}">
                                    <a href="#">
                                        <i class="fa fa-globe"></i>
                                        <span>Quản lý quốc gia</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="{{ route('country.index') }}"><i class="fa fa-angle-right"></i>
                                                Danh sách quốc gia</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('country.create') }}"><i class="fa fa-angle-right"></i>
                                                Thêm quốc gia</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="treeview {{ $segment == 'user' || $segment == 'stats' ? 'active' : '' }}">
                                    <a href="#">
                                        <i class="fa fa-users"></i>
                                        <span>Quản lý người dùng</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="{{ route('user.index') }}"><i class="fa fa-angle-right"></i> Danh
                                                sách người dùng</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.stats') }}"><i class="fa fa-angle-right"></i>
                                                Thống kê</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="treeview">
                                    <a href="{{ route('decoration.index') }}">
                                        <i class="fa fa-info-circle"></i>
                                        <span>Thông tin website</span>
                                    </a>
                                </li>



                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->
                    </nav>
                </aside>
            </div>
            <!--left-fixed -navigation-->
            <!-- header-starts -->
            <div class="sticky-header header-section">
                <div class="header-left">
                    <!--toggle button start-->
                    <button id="showLeftPush"><i class="fa fa-bars"></i></button>
                    <!--toggle button end-->
                    <div class="profile_details_left">
                        <!--notifications of menu start -->
                        <ul class="nofitications-dropdown">
                            <li class="dropdown head-dpdn">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false"><i class="fa fa-envelope"></i><span
                                        class="badge">3</span></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <div class="notification_header">
                                            <h3>You have 3 new messages</h3>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="user_img">
                                                <img src="images/1.jpg" alt="" />
                                            </div>
                                            <div class="notification_desc">
                                                <p>Lorem ipsum dolor amet</p>
                                                <p><span>1 hour ago</span></p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    </li>
                                    <li class="odd">
                                        <a href="#">
                                            <div class="user_img">
                                                <img src="images/4.jpg" alt="" />
                                            </div>
                                            <div class="notification_desc">
                                                <p>Lorem ipsum dolor amet</p>
                                                <p><span>1 hour ago</span></p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="user_img">
                                                <img src="images/3.jpg" alt="" />
                                            </div>
                                            <div class="notification_desc">
                                                <p>Lorem ipsum dolor amet</p>
                                                <p><span>1 hour ago</span></p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="user_img">
                                                <img src="images/2.jpg" alt="" />
                                            </div>
                                            <div class="notification_desc">
                                                <p>Lorem ipsum dolor amet</p>
                                                <p><span>1 hour ago</span></p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="notification_bottom">
                                            <a href="#">See all messages</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            
                            {{-- <li class="dropdown head-dpdn">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false"><i class="fa fa-bell"></i><span
                                        class="badge blue">4</span></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <div class="notification_header">
                                            <h3>You have 3 new notification</h3>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="user_img">
                                                <img src="images/4.jpg" alt="" />
                                            </div>
                                            <div class="notification_desc">
                                                <p>Lorem ipsum dolor amet</p>
                                                <p><span>1 hour ago</span></p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    </li>
                                    <li class="odd">
                                        <a href="#">
                                            <div class="user_img">
                                                <img src="images/1.jpg" alt="" />
                                            </div>
                                            <div class="notification_desc">
                                                <p>Lorem ipsum dolor amet</p>
                                                <p><span>1 hour ago</span></p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="user_img">
                                                <img src="images/3.jpg" alt="" />
                                            </div>
                                            <div class="notification_desc">
                                                <p>Lorem ipsum dolor amet</p>
                                                <p><span>1 hour ago</span></p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="user_img">
                                                <img src="images/2.jpg" alt="" />
                                            </div>
                                            <div class="notification_desc">
                                                <p>Lorem ipsum dolor amet</p>
                                                <p><span>1 hour ago</span></p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="notification_bottom">
                                            <a href="#">See all notifications</a>
                                        </div>
                                    </li>
                                </ul>
                            </li> --}}

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <!--notification menu end -->
                    <div class="clearfix"></div>
                </div>
                <div class="header-right">
                    <!--search-box-->
                    {{-- <div class="search-box">
            <form class="input">
              <input
                class="sb-search-input input__field--madoka"
                placeholder="Search..."
                type="search"
                id="input-31"
              />
              <label class="input__label" for="input-31">
                <svg
                  class="graphic"
                  width="100%"
                  height="100%"
                  viewBox="0 0 404 77"
                  preserveAspectRatio="none"
                >
                  <path d="m0,0l404,0l0,77l-404,0l0,-77z" />
                </svg>
              </label>
            </form>
          </div> --}}
                    <!--//end-search-box-->
                    <div class="profile_details">
                        <ul>
                            <li class="dropdown profile_details_drop ">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <div class="profile_img">
                                        <span class="prfil-img"><img src="images/2.jpg" alt="" />
                                        </span>
                                        <div class="user-name">
                                            <p>{{ auth()->user()->name }}</p>
                                            <span>Administrator</span>
                                        </div>
                                        <i class="fa fa-angle-down lnr"></i>
                                        <i class="fa fa-angle-up lnr"></i>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu drp-mnu">
                                    <li>
                                        <a href="/"><i class="fa fa-eye"></i> Tới trang giao diện</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/profile') }}"><i class="fa fa-user"></i> My Account</a>
                                    </li>
                                    {{-- <li>
                                        <a href="#"><i class="fa fa-suitcase"></i> Profile</a>
                                    </li> --}}
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
                            </li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- //header-ends -->
            <!-- main content start-->
            <div id="page-wrapper">
                <div class="main-page">
                    <div class="col_3">
                        <div class="col-md-3 widget widget1">
                            <div class="r3_counter_box">
                                <i class="pull-left fa fa-film icon-rounded"></i>
                                <a href="{{ route('movie.index') }}">
                                    <div class="stats">
                                        <h5><strong>{{ $movie_total }}</strong></h5>
                                        <span>Phim</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 widget widget1">
                            <div class="r3_counter_box">
                                <i class="pull-left fa fa-folder-open user1 icon-rounded"></i>
                                <a href="{{ route('category.index') }}">
                                    <div class="stats">
                                        <h5><strong>{{ $category_total }}</strong></h5>
                                        <span>Danh mục</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 widget widget1">
                            <div class="r3_counter_box">
                                <i class="pull-left fa fa-hashtag user2 icon-rounded"></i>
                                <a href="{{ route('genre.index') }}">
                                    <div class="stats">
                                        <h5><strong>{{ $genre_total }}</strong></h5>
                                        <span>Thể loại</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 widget widget1">
                            <div class="r3_counter_box">
                                <i class="pull-left fa fa-globe dollar1 icon-rounded"></i>
                                <a href="{{ route('country.index') }}">
                                    <div class="stats">
                                        <h5><strong>{{ $country_total }}</strong></h5>
                                        <span>Quốc gia</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 widget">
                            <div class="r3_counter_box">
                                <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
                                <a href="{{ route('user.index') }}">
                                <div class="stats">
                                    <h5><strong>{{ $user_total }}</strong></h5>
                                    <span>Thành viên</span>
                                </div>
                            </a>
                            </div>
                        </div>

                    </div>
                    {{-- content --}}
                    <div class="col-md-12">

                        @yield('content')

                    </div>


                </div>
            @else
                @yield('content_login');
    @endif

    <div class="clearfix"></div>
    </div>
    <!--footer-->

    <!--//footer-->
    </div>

    <!-- js-->
    {{-- <script src="{{ asset('backend/js/jquery-1.11.1.min.js') }}"></script> --}}
    {{-- jquery ui --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    {{-- datatable JS --}}
    <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
    {{-- function sortable --}}

    <script>
        $(function() {
            $(".sortable").sortable({
                placeholder: "ui-state-highlight",
                revert: true,
                update: function(event, ui) {
                    var array_id = [];
                    $(this).children('tr').each(function() {
                        array_id.push($(this).attr('id'));
                    });

                    var url = $(this).data('route'); // lấy route động từ data-route

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        method: "POST",
                        data: {
                            array_id: array_id
                        },
                        success: function(data) {
                            alert('Sắp xếp thành công');
                        }
                    });
                }
            });
        });
    </script>





    <!-- Classie -->
    <!-- for toggle left push menu script -->
    <script src="{{ asset('backend/js/classie.js') }}"></script>
    <script>
        var menuLeft = document.getElementById('cbp-spmenu-s1'),
            showLeftPush = document.getElementById('showLeftPush'),
            body = document.body;

        showLeftPush.onclick = function() {
            classie.toggle(this, 'active');
            classie.toggle(body, 'cbp-spmenu-push-toright');
            classie.toggle(menuLeft, 'cbp-spmenu-open');
            disableOther('showLeftPush');
        };

        function disableOther(button) {
            if (button !== 'showLeftPush') {
                classie.toggle(showLeftPush, 'disabled');
            }
        }
    </script>
    <!-- //Classie -->
    <!-- //for toggle left push menu script -->
    <!--scrolling js-->
    {{-- <script src="{{ asset('backend/js/jquery.nicescroll.js') }}"></script> --}}
    <script src="{{ asset('backend/js/scripts.js') }}"></script>
    <!--//scrolling js-->
    <!-- side nav js -->
    <script src="{{ asset('backend/js/SidebarNav.min.js') }}" type="text/javascript"></script>
    <script>
        $('.sidebar-menu').SidebarNav();
    </script>
    <!-- //side nav js -->
    <!-- for index page weekly sales java script -->
    {{-- <script src="{{asset('backend/js/SimpleChart.js')}}"></script> --}}

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('backend/js/bootstrap.js') }}"></script>
    <!-- //Bootstrap Core JavaScript -->
    {{-- script for change slug --}}
    <script type="text/javascript">
        function ChangeToSlug() {

            var slug;

            //Lấy text từ thẻ input title 
            slug = document.getElementById("slug").value;
            slug = slug.toLowerCase();
            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            document.getElementById('convert_slug').value = slug;
        }
    </script>
    {{-- script for modal movie --}}
    <script>
        $(document).ready(function() {
            $('#myTable').on('click', '.movie_detail', function() {
                var slug = $(this).data('movie_slug');
                var movieId = $(this).data('movie_id');
                var editUrl = '{{ route('movie.edit', ['movie' => '__movieId__']) }}'.replace(
                    '__movieId__', movieId);
                $('#movie_content_id').html('<a href="' + editUrl +
                    '" class=" btn btn-primary">Chỉnh sửa</a>');
                var deleteUrl = '{{ route('movie.destroy', ['movie' => '__movieId__']) }}'.replace(
                    '__movieId__', movieId);
                $('#deleteForm').attr('action', deleteUrl);


                $.ajax({
                    url: '{{ route('get_movie_detail') }}',
                    method: "POST",
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        slug: slug
                    },
                    success: function(data) {
                        $('#content_title').html(data.content_title);
                        $('#content_detail').html(data.content_detail);
                        // $('#movieDetailModal').modal('show'); //  Show cái modal lên
                    },
                    error: function(xhr) {
                        alert('Không tìm thấy phim!');
                    }
                })
            });
        });
    </script>
    {{-- script for modal episode --}}
    <script>
        $(document).ready(function() {
            $('.episode_detail').click(function() {
                // var slug = $(this).data('movie_slug');
                var movieId = $(this).data('movie_id');
                // var editUrl = '{{ route('movie.edit', ['movie' => '__movieId__']) }}'.replace(
                //     '__movieId__', movieId);
                // $('#movie_content_id').html('<a href="' + editUrl +
                //     '" class=" btn btn-primary">Chỉnh sửa</a>');
                // var deleteUrl = '{{ route('movie.destroy', ['movie' => '__movieId__']) }}'.replace(
                //     '__movieId__', movieId);
                // $('#deleteForm').attr('action', deleteUrl);


                $.ajax({
                    url: '{{ route('get_episodes_detail') }}',
                    method: "POST",
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: movieId
                    },
                    success: function(data) {
                        $('#ep_content_title').html(data.ep_content_title);
                        $('#ep_content_detail').html(data.ep_content_detail);
                        
                    },
                    error: function(xhr) {
                        alert('Không tìm thấy phim!');
                    }
                })
            });
        });
    </script>

{{-- <script>
    $(document).on('click', '.update_server', function () {
        var server_id = $(this).data('server_id');
        var server_name = $(this).data('server_name');

        $('#serverModal_update input[name="name"]').val(server_name);

        
        var actionUrl = '{{ route("server.update", ":id") }}'.replace(':id', server_id);
        $('#update_server_form').attr('action', actionUrl);
    });
</script> --}}




@yield('scripts')

</body>

</html>

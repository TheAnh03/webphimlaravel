<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4" style="float: right;">
    {{-- sidebar trailer --}}
    <div id="halim_tab_popular_videos-widget-7" class="widget halim_tab_popular_videos-widget">
        <div class="section-bar clearfix">
            <div class="section-title">
                <span>Phim sắp chiếu</span>
            </div>
        </div>
        <section class="tab-content">
            <div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
                <div class="halim-ajax-popular-post-loading hidden"></div>
                <div id="halim-ajax-popular-post" class="popular-post">
                    @foreach ($mov_sidebar as $key => $mov)
                    <div class="item post-37176">
                        <a href="{{route('movie',$mov->slug)}}" title="{{$mov->title}}">
                            <div class="item-link">
                                <img src="{{ asset('uploads/movies/' . $mov->image) }}"
                                    class="lazy post-thumb" 
                                    title="{{$mov->title}}" />
                                <span class="is_trailer">
                                            Trailer                                   
                                </span>
                            </div>
                            <p class="title">{{$mov->title}}</p>
                        </a> 
                        <div class="favorite" style="color: #c9c6c6;">
                            <div class="" style="color: #9d9d9d;">
                                
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                {{ $mov->usersWhoFavorited->count() }} lượt quan tâm 
                            
                            </div>

                         
                        </div>
                    </div>
                    @endforeach 
                </div>
            </div>
        </section>
        <div class="clearfix"></div>
    </div>







    {{-- sidebar top view --}}
    <div id="halim_tab_popular_videos-widget-7" class="widget halim_tab_popular_videos-widget">
        <div class="section-bar clearfix">
            <div class="section-title">
                <span>Top Views</span>
            </div>
        </div>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item active ">
                <a class="nav-link  active" id="pill day" data-toggle="pill" href="#ngay" role="tab"
                    aria-controls="ngay" aria-selected="true">Top ngày</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pill week" data-toggle="pill" href="#tuan" role="tab"
                    aria-controls="tuan" aria-selected="false">Top tuần</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pill month" data-toggle="pill" href="#thang" role="tab"
                    aria-controls="thang" aria-selected="false">Top tháng</a>
            </li>
        </ul>


    <div class="tab-content" id="pills-tabContent">
            {{-- top day --}}
            <div class="tab-pane active" id="ngay" role="tabpanel" aria-labelledby="pill day">
                <div id="halim-ajax-popular-post" class="popular-post">
                    @foreach ($topToday as $key => $mov)
                        <div class="item post-37176">
                            <a href="{{ route('movie', $mov->slug) }}" title="{{ $mov->title }}">
                                <div class="item-link">
                                    <img src="{{ asset('uploads/movies/' . $mov->image) }}" class="lazy post-thumb"
                                        title="{{ $mov->title }}" />
                                    <span class="is_trailer">
                                        @if ($mov->resolution == 1)
                                            Full HD
                                        @elseif($mov->resolution == 2)
                                            HD
                                        @elseif($mov->resolution == 3)
                                            CAM
                                        @else
                                            Đang cập nhật
                                        @endif
                                    </span>
                                </div>
                                <p class="title">{{ $mov->title }}</p>
                            </a>
                            <div class="viewsCount" style="color: #c9c6c6;">
                                <div class="viewsCount" style="color: #9d9d9d;">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    {{ $mov->views_count }} lượt xem <br><br>
                                    <i class="bi bi-star-fill text-warning"></i> {{ $mov->average_rating }}
                                    ({{ $mov->rating_count }} đánh giá)
                                </div>

                               
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                {{-- top week  --}}

        <div class="tab-pane fade" id="tuan" role="tabpanel" aria-labelledby="pill week">

            <div id="halim-ajax-popular-post" class="popular-post">
                @foreach ($topWeek as $key => $mov)
                    <div class="item post-37176">
                        <a href="{{ route('movie', $mov->slug) }}" title="{{ $mov->title }}">
                            <div class="item-link">
                                <img src="{{ asset('uploads/movies/' . $mov->image) }}" class="lazy post-thumb"
                                    title="{{ $mov->title }}" />
                                <span class="is_trailer">
                                    @if ($mov->resolution == 1)
                                        Full HD
                                    @elseif($mov->resolution == 2)
                                        HD
                                    @elseif($mov->resolution == 3)
                                        CAM
                                    @else
                                        Đang cập nhật
                                    @endif
                                </span>
                            </div>
                            <p class="title">{{ $mov->title }}</p>
                        </a>
                        <div class="viewsCount" style="color: #9d9d9d;">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                            {{ $mov->views_count }} lượt xem <br><br>
                            <i class="bi bi-star-fill text-warning"></i> {{ $mov->average_rating }}
                            ({{ $mov->rating_count }} đánh giá)
                        </div>
                      
                    </div>
                @endforeach
            </div>
            {{-- top month --}}

        </div>
        <div class="tab-pane fade" id="thang" role="tabpanel" aria-labelledby="pill month">

            <div id="halim-ajax-popular-post" class="popular-post">
                @foreach ($topMonth as $key => $mov)
                    <div class="item post-37176">
                        <a href="{{ route('movie', $mov->slug) }}" title="{{ $mov->title }}">
                            <div class="item-link">
                                <img src="{{ asset('uploads/movies/' . $mov->image) }}" class="lazy post-thumb"
                                    title="{{ $mov->title }}" />
                                <span class="is_trailer">
                                    @if ($mov->resolution == 1)
                                        Full HD
                                    @elseif($mov->resolution == 2)
                                        HD
                                    @elseif($mov->resolution == 3)
                                        CAM
                                    @else
                                        Đang cập nhật
                                    @endif
                                </span>
                            </div>
                            <p class="title">{{ $mov->title }}</p>
                        </a>
                        <div class="viewsCount" style="color: #9d9d9d;">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                            {{ $mov->views_count }} lượt xem <br><br>
                            <i class="bi bi-star-fill text-warning"></i> {{ $mov->average_rating }}
                            ({{ $mov->rating_count }} đánh giá)
                        </div>
                     
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <div class="clearfix"></div>
    </div>
</aside>












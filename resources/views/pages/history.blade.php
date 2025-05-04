@extends('layout')
@section('content')
<div class="row container" id="wrapper">
    <div class="halim-panel-filter">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6">
                   
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
                <h1 class="section-title"><span>Lịch sử phim vừa xem </span></h1>
            </div>
            <div class="card" style="background:rgba(255, 0, 0, 0.63); border-radius: 5px; margin:20px " >
                <h5 style="padding: 20px; color:#fff">Lưu ý: Đây là lịch sử xem lưu trên tài khoản của bạn, không phải lịch sử xem trên thiết bị.</h5>
            </div>
            <div >
                
                @if ($history->count() > 0)
                    <form action="{{ route('history.clear') }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa toàn bộ lịch sử xem?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Xóa toàn bộ lịch sử đã xem </button>
                    </form>
                @endif
            </div>
            

            <div class="halim_box">
                @if ($history->count() > 0)
                @foreach($history as $key => $mov)
                <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-27021">
                    <div class="halim-item">
                        <a class="halim-thumb" href="{{route('movie',$mov->movie->slug)}}" title="{{$mov->movie->title}}">
                            <figure><img class="lazy img-responsive" src="{{ asset('uploads/movies/' . $mov->movie->image) }}" title="{{$mov->movie->title}}"></figure>
                            <span class="status">
                                @if($mov->movie->resolution==1)
                                        Full HD
                                @elseif($mov->movie->resolution==2)
                                        HD
                                @elseif($mov->movie->resolution==3)
                                        CAM
                                @else
                                        Đang cập nhật
                                @endif     
                            </span>
                            <span class="episode " style="background-color:#b15f5f81; border-radius: 3px; margin: 6px 6px; !important;">


                                <form action="{{ route('history.destroy', $mov->id) }}" method="POST" onsubmit="return confirm('Xóa khỏi lịch sử xem?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="fa fa-times " style="color: #fff ;background: none;
                                        border: none;"></button>
                                </form>
                                </span>
                            <div class="icon_overlay"></div>
                            <div class="halim-post-title-box">
                                <div class="halim-post-title ">
                                    <p class="entry-title">{{$mov->movie->title}}</p>
                                    <p class="original_title">{{$mov->movie->name_eng}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
                @endforeach
                @else
                    <p>Chưa có phim nào trong danh sách này.</p>
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
                {!! $history->links("pagination::bootstrap-4") !!}
            </div>
        </section>
    </main>
    @include('pages.include.sidebar')
</div>
@endsection
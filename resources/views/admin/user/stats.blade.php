@extends('layouts.app')

@section('content')
<div class="">Thống kê truy cập</div>
    <div class="container-fluid">
        

        <div class="row">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h4>Tổng số người truy cập</h4>
                        <p>{{ $totalVisitors }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h4>Tổng số người đăng ký</h4>
                        <p>{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h4>Tổng số lượt xem</h4>
                        <p>{{ $totalViews }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h4>Tổng số bình luận</h4>
                        <p>{{ $totalComments }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h4>Tổng số lượt yêu thích</h4>
                        <p>{{ $totalFavorites }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <form method="GET" action="{{ route('admin.stats') }}" class="row mb-4">
        <div class="col-md-3">
            <label>Từ ngày:</label>
            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-md-3">
            <label>Đến ngày:</label>
            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
        </div>
        <div class="col-md-3 " style="margin-top:25px">
            <button type="submit" class="btn btn-primary">Thống kê</button>
        </div>
    </form>


    <canvas id="statsChart" height="100"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statsChart').getContext('2d');
    const fromDate = '{{ $formattedFrom }}';
    const toDate = '{{ $formattedTo }}';
    const titleText = `Thống kê từ ${fromDate} đến ${toDate}`;

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dates) !!},
            datasets: [
                {
                    label: 'Lượt truy cập',
                    data: {!! json_encode($visitorsData) !!},
                    borderColor: 'rgba(54, 162, 235, 1)',
                    fill: false
                },
                {
                    label: 'Lượt xem',
                    data: {!! json_encode($viewsData) !!},
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: false
                },
                {
                    label: 'Đánh giá',
                    data: {!! json_encode($ratingsData) !!},
                    borderColor: 'rgba(255, 206, 86, 1)',
                    fill: false
                },
                {
                    label: 'Yêu thích',
                    data: {!! json_encode($favoritesData) !!},
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: false
                },
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: titleText
                }
            }
        }
    });
</script>

    














@endsection

@extends('LayoutAdmin')
@section('content')
    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- main title -->
                <div class="col-12">
                    <div class="main__title">
                        <h2>Tổng Quan</h2>
                    </div>
                </div>
                <!-- end main title -->
            </div>

            <div class="row row--grid">
                <!-- stats -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stats">
                        <span>Đơn hàng tháng này</span>
                        <p>{{ $orderCount }}</p>
                        <img src="{{ asset('BackEnd/img/graph-bar.svg') }}" alt="">
                    </div>
                </div>
                <!-- end stats -->
                <style>
                    .stats svg {
                        width: 36px;
                        height: auto;
                        position: absolute;
                        bottom: 20px;
                        right: 20px;
                    }

                    svg {
                        vertical-align: middle;
                        border-style: none;
                    }
                </style>
                <!-- stats -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stats">
                        <span>Sản phẩm</span>
                        <p>{{ $productCount }}</p>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                            <linearGradient id="gradient" x2="1" y2="1">
                                <stop offset="0%" stop-color="#ff55a5" />
                                <stop offset="100%" stop-color="#ff5860" />
                            </linearGradient>
                            <path fill="url(#gradient)"
                                d="M16 64C16 28.7 44.7 0 80 0H304c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H80c-35.3 0-64-28.7-64-64V64zM144 448c0 8.8 7.2 16 16 16h64c8.8 0 16-7.2 16-16s-7.2-16-16-16H160c-8.8 0-16 7.2-16 16zM304 64H80V384H304V64z" />
                        </svg>
                    </div>
                </div>
                <!-- end stats -->

                <!-- stats -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stats">
                        <span>Bài Viết</span>
                        <p>{{ $postCount }}</p>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <linearGradient id="gradient" x2="1" y2="1">
                                <stop offset="0%" stop-color="#ff55a5" />
                                <stop offset="100%" stop-color="#ff5860" />
                            </linearGradient>
                            <path fill="url(#gradient)"
                                d="M192 32c0 17.7 14.3 32 32 32c123.7 0 224 100.3 224 224c0 17.7 14.3 32 32 32s32-14.3 32-32C512 128.9 383.1 0 224 0c-17.7 0-32 14.3-32 32zm0 96c0 17.7 14.3 32 32 32c70.7 0 128 57.3 128 128c0 17.7 14.3 32 32 32s32-14.3 32-32c0-106-86-192-192-192c-17.7 0-32 14.3-32 32zM96 144c0-26.5-21.5-48-48-48S0 117.5 0 144V368c0 79.5 64.5 144 144 144s144-64.5 144-144s-64.5-144-144-144H128v96h16c26.5 0 48 21.5 48 48s-21.5 48-48 48s-48-21.5-48-48V144z" />
                        </svg>
                    </div>
                </div>
                <!-- end stats -->

                <!-- stats -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stats">
                        <span>Người Dùng</span>
                        <p>{{ $userCount }}</p>
                        <img src="{{ asset('BackEnd/img/user-circle.svg') }}" alt="">
                    </div>
                </div>
                <!-- end stats -->

                <!-- dashbox -->
                <div class="col-12">
                    <div class="dashbox">
                        <div class="dashbox__title">
                            <h3><img src="{{ asset('BackEnd/img/chart.svg') }}" alt="">Doanh Thu</h3>

                        </div>
                        <div class="dashbox__table-wrap">
                            <div style="text-transform: capitalize;" id="myChart"></div>
                        </div>
                    </div>
                </div>
                <!-- end dashbox -->

                <!-- dashbox -->
                <div class="col-12 col-xl-6">
                    <div class="dashbox">
                        <div class="dashbox__title">
                            <h3><img src="{{ asset('BackEnd/img/user-circle.svg') }}" alt=""> Người Dùng Mới</h3>

                            <div class="dashbox__wrap">
                                <a class="dashbox__refresh" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M21,11a1,1,0,0,0-1,1,8.05,8.05,0,1,1-2.22-5.5h-2.4a1,1,0,0,0,0,2h4.53a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4.77A10,10,0,1,0,22,12,1,1,0,0,0,21,11Z" />
                                    </svg></a>
                            </div>
                        </div>

                        <div class="dashbox__table-wrap">
                            <table class="main__table main__table--dash">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>HỌ & TÊN</th>
                                        <th>EMAIL</th>
                                        <th>NGÀY GIỜ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <div class="main__table-text">{{ $user->id }}</div>
                                            </td>
                                            <td>
                                                <div class="main__table-text">{{ $user->name }}</div>
                                            </td>
                                            <td>
                                                <div class="main__table-text main__table-text--grey">{{ $user->email }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="main__table-text">{{ $user->created_at }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end dashbox -->

                <!-- dashbox -->
                <div class="col-12 col-xl-6">
                    <div class="dashbox">
                        <div class="dashbox__title">
                            <h3><img src="{{ asset('BackEnd/img/award.svg') }}" alt=""> Sản Phẩm Hàng Đầu</h3>

                            <div class="dashbox__wrap">
                                <a class="dashbox__refresh" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M21,11a1,1,0,0,0-1,1,8.05,8.05,0,1,1-2.22-5.5h-2.4a1,1,0,0,0,0,2h4.53a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4.77A10,10,0,1,0,22,12,1,1,0,0,0,21,11Z" />
                                    </svg></a>
                            </div>
                        </div>

                        <div class="dashbox__table-wrap">
                            <table class="main__table main__table--dash">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>SẢN PHẨM</th>
                                        <th>THỂ LOẠI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productTop as $item)
                                        <tr>
                                            <td>
                                                <div class="main__table-text">{{ $item->id }}</div>
                                            </td>
                                            <td>
                                                <div class="main__table-text">{{ $item->name }}</div>
                                            </td>
                                            <td>
                                                <div class="main__table-text">{{ $item->ProToCate->name }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end dashbox -->
            </div>
        </div>
    </main>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        new Morris.Bar({
            element: 'myChart',
            parseTime: false,
            hideHover: 'auto',
            barColors: ['rgb(255,85,165)'],
            xkey: 'day',
            ykeys: ['total', 'profit'],
            labels: ['Doanh Thu', 'Lợi Nhuận'],
            xLabelAngle: 43,
            labelTop: true,
            data: {!! json_encode($chartData) !!}
        });
    </script>
@stop

@extends('LayoutUser')
@section('content')
    <!-- slider-group-start -->
    <div class="slider-group  mt-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <!-- slider-area-start -->
                    <div class="slider-area">
                        <div class="slider-active owl-carousel">
                            @foreach ($sliders as $item)
                                <div class="single-slider slider-hm4-1 pt-154 pb-154 bg-img"
                                    style="background-image:url({{ asset('uploads/slider/' . $item->image) }});">
                                    <div class="slider-content-4 slider-animated-1 pl-40">
                                        <h1>{!! $item->name !!}</h1>
                                        <h2>{!! $item->desc !!}</h2>
                                        <a href="{{ $item->link }}">Mua ngay!</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- slider-area-end -->
                </div>
            </div>
        </div>
    </div>
    <!-- slider-group-end -->
    <!-- home-main-area-start -->
    <div class="home-main-area mt-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <!-- category-area-start -->
                    <div class="category-area mb-30">
                        <h3><a href="#">Danh mục sản phẩm <i class="fa fa-bars"></i></a></h3>
                        <div class="category-menu">
                            @include('User.inc.menu_inc')
                        </div>
                    </div>
                    <!-- category-area-end -->
                    <!-- banner-area-start -->
                    <div class="banner-area mb-30">
                        <div class="banner-img-2">
                            <a href="#"><img src="{{ asset('User/') }}/img/banner/99.png" alt="banner" /></a>
                        </div>
                    </div>
                    <!-- banner-area-end -->
                    <!-- most-product-area-start -->
                    @if (count($topProduct) > 0)
                        <div class="most-product-area mb-30">
                            <div class="section-title-2 mb-30">
                                <h3>SẢN PHẨM THỊNH HÀNH</h3>
                            </div>
                            <div class="product-active-2 owl-carousel">
                                @foreach ($topProduct as $item)
                                    <div class="product-total-2">
                                        <div class="single-most-product bd mb-18">
                                            <div class="most-product-img">
                                                <a href="{{ route('home.show', $item->slug) }}"><img
                                                        src="{{ asset('uploads/sanpham/' . $item->ProToGall->imageDefault) }}"
                                                        alt="" /></a>
                                            </div>
                                            <div class="most-product-content">
                                                <h4><a href="{{ route('home.show', $item->slug) }}">{{ $item->name }}</a>
                                                </h4>
                                                <div class="product-price">
                                                    <ul>
                                                        <li>{{ number_format($item->price) }}₫</li>
                                                        @if ($item->priceOld > 0)
                                                            <li class="old-price">{{ number_format($item->priceOld) }}₫</li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <!-- most-product-area-end -->
                    <!-- recent-post-area-start -->
                    <div class="recent-post-area mb-30">
                        <div class="section-title-2 mb-30">
                            <h3>Bài viết </h3>
                        </div>
                        <div class="post-active-2 owl-carousel">
                            @foreach ($posts as $item)
                                <div class="single-post">
                                    <div class="post-img">
                                        <a href="{{ route('post.show', $item) }}"><img
                                                src="{{ asset('uploads/baiviet/' . $item->image) }}"
                                                alt="{{ $item->name }}" /></a>
                                        <div class="blog-date-time">
                                            <span class="day-time">{{ $item->created_at->format('d') }}</span>
                                            <span class="moth-time">{{ $item->created_at->format('M') }}</span>
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <h3><a href="{{ route('post.show', $item) }}">{{ $item->name }}</a></h3>
                                        <span class="meta-author"> {{ $item->PostToUser->name }} </span>
                                        <p style="text-align: justify;"> {!! substr($item->short_desc, 0, 200) !!}
                                            {{ strlen($item->short_desc) > 200 ? '...' : '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- recent-post-area-end -->
                    <!-- block-newsletter-area-start -->
                    <div class="block-newsletter">
                        <h2>ĐĂNG KÝ GỬI BẢN TIN</h2>
                        <p>Bạn luôn có thể cập nhật thông tin mới của công ty chúng tôi!</p>
                        <form action="#">
                            <input type="text" placeholder="Nhập email" />
                        </form>
                        <a href="#">gửi Email</a>
                    </div>
                    <!-- block-newsletter-area-end -->
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                    <!-- banner-area-5-start -->
                    <div class="banner-area-5">
                        <div class="single-banner-4 xs-mb">
                            <div class="banner-img-2">
                                <a href="#"><img src="{{ asset('User/') }}/img/banner/97.png" alt="banner" /></a>
                            </div>
                        </div>
                        <div class="single-banner-5">
                            <div class="banner-img-2">
                                <a href="#"><img src="{{ asset('User/') }}/img/banner/96.png" alt="banner" /></a>
                            </div>
                        </div>
                    </div>
                    <!-- banner-area-5-end -->
                    <!-- new-book-area-start -->
                    <div class="new-book-area ptb-50">
                        <div class="section-title-2 mb-30">
                            <h3>Mới Nhất</h3>
                        </div>
                        <div class="tab-active-3 owl-carousel">
                            @foreach ($newProduct as $key => $item)
                                <div class="tab-total">
                                    <!-- single-product-start -->
                                    <div class="product-wrapper mb-40">
                                        <div class="product-img">
                                            <a href="{{ route('home.show', $item->slug) }}">
                                                <img src="{{ asset('uploads/sanpham/' . $item->ProToGall->imageDefault) }}"
                                                    alt="" class="primary" />
                                            </a>
                                            <div class="quick-view">
                                                <a class="action-view" href="{{ route('home.show', $item->slug) }}"
                                                    title="Chi tiết">
                                                    <i class="fa fa-search-plus"></i>
                                                </a>
                                            </div>
                                            <div class="product-flag">
                                                <ul>
                                                    @if ($item->newPro == 0)
                                                        <li><span class="sale">mới</span></li>
                                                    @endif
                                                    @if ($item->priceOld > 0)
                                                        <li>
                                                            <span
                                                                class="discount-percentage">-{{ number_format(100 - ($item->priceOld / $item->price) * 100) }}%</span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-details text-center">
                                            <div class="product-rating">
                                                <ul>
                                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                </ul>
                                            </div>
                                            <h4><a
                                                    href="{{ route('home.show', $item->slug) }}">{{ ucwords($item->name) }}</a>
                                            </h4>
                                            <div class="product-price">
                                                <ul>
                                                    <li>{{ number_format($item->price) }}₫</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-link">
                                            <div class="product-button">
                                                <input type="hidden" class="hide_qty_{{ $item->id }}"
                                                    value="1">
                                                <a href="#" class="addCart" data-proId="{{ $item->id }}"
                                                    title="Thêm giỏ hàng"><i class="fa fa-shopping-cart"></i>Thêm giỏ
                                                    hàng</a>
                                            </div>
                                            <div class="add-to-link">
                                                <ul>
                                                    <li><a href="{{ route('home.show', $item->slug) }}"
                                                            title="Chi tiết"><i class="fa fa-external-link"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single-product-end -->
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- new-book-area-start -->
                    <!-- hot-sell-area-2-start -->
                    @if (count($saleProduct) > 0)
                        <div class="hot-sell-area-2 pb-50">
                            <div class="section-title-2 title-big bt pt-50 mb-30">
                                <h3>hot sale</h3>
                            </div>
                            <div class="hot-sell-active owl-carousel">
                                @foreach ($saleProduct as $item)
                                    {{--  @if ($item->newPro == 0)  --}}
                                        <!-- single-product-start -->
                                        <div class="product-wrapper">
                                            <div class="product-img">
                                                <a href="{{ route('home.show', $item->slug) }}">
                                                    <img src="{{ asset('uploads/sanpham/' . $item->ProToGall->imageDefault) }}"
                                                        alt="" class="primary" />
                                                </a>
                                                <div class="quick-view">
                                                    <a class="action-view" href="{{ route('home.show', $item->slug) }}"
                                                        title="Chi tiết">
                                                        <i class="fa fa-search-plus"></i>
                                                    </a>
                                                </div>
                                                <div class="product-flag">
                                                    <ul>
                                                        @if ($item->newPro == 0)
                                                            <li><span class="sale">mới</span></li>
                                                        @endif
                                                        @if ($item->priceOld > 0)
                                                            <li>
                                                                <span
                                                                    class="discount-percentage">-{{ number_format(100 - ($item->priceOld / $item->price) * 100) }}%</span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-details text-center">
                                                <div class="timer-2 text-center">
                                                    <div data-countdown="{!! Carbon\Carbon::now('Asia/Ho_Chi_Minh')->endOfWeek()->format('Y/m/d') !!}"></div>
                                                </div>
                                                <div class="product-rating mt-20">
                                                    <ul>
                                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                    </ul>
                                                </div>
                                                <h4><a
                                                        href="{{ route('home.show', $item->slug) }}">{{ ucwords($item->name) }}</a>
                                                </h4>
                                                <div class="product-price">
                                                    <ul>
                                                        <li>{{ number_format($item->price) }}₫</li>
                                                        @if ($item->priceOld > 0)
                                                            <li class="old-price">{{ number_format($item->priceOld) }}₫
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-link">
                                                <div class="product-button">
                                                    <input type="hidden" class="hide_qty_{{ $item->id }}"
                                                        value="1">
                                                    <a href="#" class="addCart" data-proId="{{ $item->id }}"
                                                        title="Thêm giỏ hàng"><i class="fa fa-shopping-cart"></i>Thêm giỏ
                                                        hàng</a>
                                                </div>
                                                <div class="add-to-link">
                                                    <ul>
                                                        <li><a href="{{ route('home.show', $item->slug) }}"
                                                                title="Chi tiết"><i class="fa fa-external-link"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single-product-end -->
                                    {{--  @endif  --}}
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <!-- hot-sell-area-2-end -->
                    <!-- product-area-start -->
                    <div class="product-area">
                        <div class="row">
                            @if (isset($cateTop3))
                                @php
                                    $col = 12;
                                    if ($cateTop3->count() == 3) {
                                        $col = 4;
                                    }
                                    if ($cateTop3->count() == 2) {
                                        $col = 6;
                                    }
                                @endphp
                                @foreach ($cateTop3 as $item)
                                    <div class="col-lg-{{ $col }} col-md-12">
                                        <div class="section-title-2 mb-30">
                                            <h3>{{ $item->name }}</h3>
                                        </div>
                                        <div class="product-active-3 owl-carousel">
                                            <div class="product-total-2">
                                                @foreach ($item->CateToPro->take(3) as $row)
                                                    <div class="single-most-product bd mb-18">
                                                        <div class="most-product-img">
                                                            <a href="{{ route('home.show', $row->slug) }}"><img
                                                                    src="{{ asset('uploads/sanpham/' . $row->ProToGall->imageDefault) }}"
                                                                    alt="$item->name" /></a>
                                                        </div>
                                                        <div class="most-product-content">
                                                            <div class="product-rating">
                                                                <ul>
                                                                    <li><a href="#"><i class="fa fa-star"></i></a>
                                                                    </li>
                                                                    <li><a href="#"><i class="fa fa-star"></i></a>
                                                                    </li>
                                                                    <li><a href="#"><i class="fa fa-star"></i></a>
                                                                    </li>
                                                                    <li><a href="#"><i class="fa fa-star"></i></a>
                                                                    </li>
                                                                    <li><a href="#"><i class="fa fa-star"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <h4><a
                                                                    href="{{ route('home.show', $row->slug) }}">{{ $row->name }}</a>
                                                            </h4>
                                                            <div class="product-price">
                                                                <ul>
                                                                    <li>{{ number_format($row->price) }}₫</li>
                                                                    @if ($row->priceOld > 0)
                                                                        <li class="old-price">
                                                                            {{ number_format($row->priceOld) }}₫</li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <!-- product-area-end -->
                </div>
            </div>
        </div>
    </div>
    <!-- home-main-area-end -->
    <!-- banner-area-start -->
    <div class="banner-area-5 mtb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-img-2 for-height">
                        <a href="#"><img src="{{ asset('User') }}/img/banner/98.png" alt="banner" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner-area-end -->
    <!-- social-group-area-start -->
    <div class="social-group-area ptb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title-3">
                        <h3>TWEET MỚI NHẤT</h3>
                    </div>
                    <div class="twitter-content">
                        <div class="twitter-icon">
                            <a href="#"><i class="fa fa-twitter"></i></a>
                        </div>
                        <div class="twitter-text">
                            <p>
                                Sự rõ ràng cũng là một quá trình năng động tuân theo thói quen thay đổi của độc giả. Thật
                                đáng ngạc nhiên khi lưu ý làm thế nào
                            </p>
                            <a href="#">phongvan</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title-3">
                        <h3>GIỮ LIÊN LẠC</h3>
                    </div>
                    <div class="link-follow">
                        <ul>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                            <li><a href="#"><i class="fa fa-flickr"></i></a></li>
                            <li><a href="#"><i class="fa fa-vimeo"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- social-group-area-end -->
@endsection
@section('js')
    <script>
        setInterval(function() {
            $('.owl-next').click();
        }, 10000);
    </script>
@stop

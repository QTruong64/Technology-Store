@extends('LayoutUser')
@section('content')
    @include('User.inc.area', ['active' => !isset($result) ? 'Tất cả' : $result->name])
    <!-- shop-main-area-start -->
    <div class="shop-main-area mb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12 order-lg-1 order-2 mt-sm-50 mt-xs-40">
                    <div class="shop-left">
                        <div class="section-title-5 mb-30">
                            <h2>TÙY CHỌN MUA SẮM</h2>
                        </div>
                        <div class="left-title mb-20">
                            <h4>LOẠI</h4>
                        </div>
                        <div class="left-menu mb-30">
                            <ul>
                                @foreach ($categories as $item)
                                    <li>
                                        <a
                                            href="{{ route('home.show', $item->slug) }}">{{ ucwords($item->name) }}<span>({{ $item->CateToPro->count() }})</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <style>
                            .left-menu ul li input {
                                display: inline-block;
                                font-size: 16px;
                                margin-right: 20px;
                            }

                            .left-menu ul li {
                                color: #333;
                                display: block;
                                font-size: 15px;
                                font-weight: 400;
                                line-height: 26px;
                                padding: 10px 0;
                                position: relative;
                                text-decoration: none;
                                font-family: 'Rufina', serif;
                                font-weight: 400;
                            }
                        </style>
                        @php
                            $i = 0;
                            $mucgia = [];
                            $manhinh = [];
                            $ram = [];
                            $rom = [];
                            $priceGet = '';
                            $screenGet = '';
                            $ramGet = '';
                            $romGet = '';
                            if (isset(request()->mucgia)) {
                                $priceGet = request()->mucgia;
                            }
                            $mucgia = explode(',', $priceGet);
                            if (isset(request()->manhinh)) {
                                $screenGet = request()->manhinh;
                            }
                            $manhinh = explode(',', $screenGet);
                            if (isset(request()->ram)) {
                                $ramGet = request()->ram;
                            }
                            $ram = explode(',', $ramGet);
                            if (isset(request()->rom)) {
                                $romGet = request()->rom;
                            }
                            $rom = explode(',', $romGet);

                            $priceArray = ['Dưới 2 triệu', 'Từ 2 - 4 triệu', 'Từ 4 - 7 triệu', 'Từ 7 - 13 triệu', 'Từ 13 - 20 triệu', 'Trên 20 triệu'];
                            $ramArray = [4, 6, 8, 16, 32];
                            $romArray = [128, 256, 512, 1];
                        @endphp

                        <div class="left-title mb-20">
                            <h4>GIÁ</h4>
                        </div>
                        <div class="left-menu mb-30">
                            <ul>
                                @foreach ($priceArray as $item)
                                    <li>
                                        <input {{ in_array(Str::slug($item), $mucgia) ? 'checked' : '' }} type="checkbox"
                                            data-filter='mucgia' name="mucgia" class="boloc-mucgia"
                                            value="{{ Str::slug($item) }}"> {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="left-title mb-20">
                            <h4>MÀN HÌNH</h4>
                        </div>
                        <div class="left-menu mb-30">
                            <ul>
                                @foreach ($screens as $item)
                                    <li>
                                        <input {{ in_array($item->screen, $manhinh) ? 'checked' : '' }} type="checkbox"
                                            data-filter='manhinh' name="manhinh" class="boloc-manhinh"
                                            value="{{ $item->screen }}"> {{ $item->screen }} inch
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="left-title mb-20">
                            <h4>RAM</h4>
                        </div>
                        <div class="left-menu mb-30">
                            <ul>
                                @foreach ($ramArray as $item)
                                    <li>
                                        <input {{ in_array($item, $ram) ? 'checked' : '' }} type="checkbox"
                                            data-filter='ram' name="ram" class="boloc-ram" value="{{ $item }}">
                                        {{ $item }} GB
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="left-title mb-20">
                            <h4>ROM</h4>
                        </div>
                        <div class="left-menu mb-30">
                            <ul>
                                @foreach ($romArray as $item)
                                    <li>
                                        <input {{ in_array($item, $rom) ? 'checked' : '' }} type="checkbox"
                                            data-filter='rom' name="rom" class="boloc-rom" value="{{ $item }}">
                                        {{ $item }} {{ $item == 1 ? 'TB' : 'GB' }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="left-title mb-20">
                            <h4>NGẪU NHIÊN</h4>
                        </div>

                        <div class="random-area mb-30">
                            <div class="product-active-2 owl-carousel">
                                @foreach ($random as $item)
                                    <div class="product-total-2">
                                        <div class="single-most-product bd mb-18">
                                            <div class="most-product-img">
                                                <a href="{{ route('home.show', $item->slug) }}"><img
                                                        src="{{ asset('uploads/sanpham/' . $item->ProToGall->imageDefault) }}"
                                                        alt="book" /></a>
                                            </div>
                                            <div class="most-product-content">
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
                                                        @if ($item->priceOld > 0)
                                                            <li class="old-price">{{ number_format($item->priceOld) }}₫
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        @foreach ($randomOther as $item2)
                                            <div class="single-most-product bd mb-18">
                                                <div class="most-product-img">
                                                    <a href="{{ route('home.show', $item2->slug) }}"><img
                                                            src="{{ asset('uploads/sanpham/' . $item2->ProToGall->imageDefault) }}"
                                                            alt="book" /></a>
                                                </div>
                                                <div class="most-product-content">
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
                                                            href="{{ route('home.show', $item2->slug) }}">{{ ucwords($item2->name) }}</a>
                                                    </h4>
                                                    <div class="product-price">
                                                        <ul>
                                                            <li>{{ number_format($item2->price) }}₫</li>
                                                            @if ($item2->priceOld > 0)
                                                                <li class="old-price">
                                                                    {{ number_format($item2->priceOld) }}₫</li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="left-title-2 mb-30">
                            <h2>SO SÁNH SẢN PHẨM</h2>
                            @if (session()->has('compare'))
                                @foreach (session()->get('compare') as $item)
                                    @php
                                        $i++;
                                    @endphp
                                    @if ($i < 3)
                                        <div class="product-total-2">
                                            <div class="single-most-product bd mb-18">
                                                <div class="most-product-img">
                                                    <a href="{{ route('home.show', $item['slug']) }}"><img
                                                            src="{{ asset('uploads/sanpham/' . $item['image']) }}"
                                                            alt="book" /></a>
                                                </div>
                                                <div class="most-product-content">
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
                                                            href="{{ route('home.show', $item['slug']) }}">{{ ucwords($item['name']) }}</a>
                                                    </h4>
                                                    <div class="product-price">
                                                        <ul>
                                                            <li>{{ number_format($item['price']) }}₫</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <p>Bạn không có gì để so sánh cả.</p>
                            @endif
                        </div>
                        <div class="left-title-2">
                            <h2>SẢN PHẨM YÊU THÍCH</h2>
                            @if (count($wishlists) == 0)
                                <p>Bạn không có mục nào trong danh sách mong muốn của bạn.</p>
                            @endif
                            @foreach ($wishlists->take(3) as $item)
                                <div class="product-total-2">
                                    <div class="single-most-product bd mb-18">
                                        <div class="most-product-img">
                                            <a href="{{ route('home.show', $item->WhishToPro->slug) }}"><img
                                                    src="{{ asset('uploads/sanpham/' . $item->WhishToPro->ProToGall->imageDefault) }}"
                                                    alt="book" /></a>
                                        </div>
                                        <div class="most-product-content">
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
                                                    href="{{ route('home.show', $item->WhishToPro->slug) }}">{{ ucwords($item->WhishToPro->name) }}</a>
                                            </h4>
                                            <div class="product-price">
                                                <ul>
                                                    <li>{{ number_format($item->WhishToPro->price) }}₫</li>
                                                    @if ($item->WhishToPro->priceOld > 0)
                                                        <li class="old-price">
                                                            {{ number_format($item->WhishToPro->priceOld) }}₫
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 col-12 order-lg-2 order-1">
                    <div class="category-image mb-30">
                        <a href="#"><img src="{{ asset('User/img/banner/32.jpg') }}" alt="banner" /></a>
                    </div>
                    <div class="section-title-5 mb-30">
                        <h2>{{ isset($result) ? $result->name : 'Tất Cả' }}</h2>
                    </div>
                    <div class="toolbar mb-30">
                        <div class="shop-tab">
                            <div class="tab-3">
                                <ul class="nav">
                                    <li><a class="active" href="#th" data-bs-toggle="tab"><i
                                                class="fa fa-th-large"></i>Grid</a></li>
                                    <li><a href="#list" data-bs-toggle="tab"><i class="fa fa-bars"></i>List</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="toolbar-sorter">
                            <span>Sắp xếp</span>
                            <select id="sapxep" class="sorter-options" data-role="sorter">
                                <option value=""> Chọn </option>
                                <option {{ request()->sapxep == 'moinhat' ? 'selected' : '' }} value="moinhat"> Mới nhất
                                </option>
                                <option {{ request()->sapxep == 'banchaynhat' ? 'selected' : '' }} value="banchaynhat">
                                    Bán chạy nhất </option>
                                <option {{ request()->sapxep == 'giagiamdan' ? 'selected' : '' }} value="giagiamdan"> Giá
                                    giảm dần </option>
                                <option {{ request()->sapxep == 'giatangdan' ? 'selected' : '' }} value="giatangdan"> Giá
                                    tăng dần </option>
                            </select>
                            <a href="#"><i class="fa fa-arrow-up"></i></a>
                        </div>
                    </div>
                    <!-- tab-area-start -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="th">
                            <div class="row">
                                @if ($products->count() == 0)
                                    @include('User.inc.not_found')
                                @endif
                                @foreach ($products as $item)
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                        <!-- single-product-start -->
                                        <div class="product-wrapper mb-40">
                                            <div class="product-img">
                                                <a href="{{ route('home.show', $item->slug) }}">
                                                    <img src="{{ asset('uploads/sanpham/' . $item->ProToGall->imageDefault) }}"
                                                        alt="book" class="primary" />
                                                </a>
                                                <div class="quick-view">
                                                    <a class="action-view" onclick="doDuLieuSanPham({{ $item->id }})"
                                                        title="Xem Nhanh">
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
                                                        href="{{ route('home.show', $item->slug) }}">{{ $item->name }}</a>
                                                </h4>
                                                <div class="product-price">
                                                    <ul>
                                                        <li>{{ number_format($item->price) }}₫</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-link">
                                                <div class="product-button">
                                                    <a href="#" title="Thêm giỏ hàng"><i
                                                            class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                                                </div>
                                                <div class="add-to-link">
                                                    <ul>
                                                        <li><a href="{{ route('home.show', $item->slug) }}"
                                                                title="Details"><i class="fa fa-external-link"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single-product-end -->
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="list">
                            @if ($products->count() > 0)
                                @foreach ($products as $item)
                                    <!-- single-shop-start -->
                                    <div class="single-shop mb-30">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <div class="product-wrapper-2">
                                                    <div class="product-img">
                                                        <a href="{{ route('home.show', $item->slug) }}">
                                                            <img src="{{ asset('uploads/sanpham/' . $item->ProToGall->imageDefault) }}"
                                                                alt="book" class="primary" />
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-12">
                                                <div class="product-wrapper-content">
                                                    <div class="product-details">
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
                                                                @if ($item->priceOld > 0)
                                                                    <li class="old-price">
                                                                        {{ number_format($item->priceOld) }}₫</li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                        <p>{!! substr(strip_tags($item->description), 0, 200) !!} ... </p>
                                                    </div>
                                                    <div class="product-link">
                                                        <div class="product-button">
                                                            <a href="#" title="Thêm giỏ hàng"><i
                                                                    class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                                                        </div>
                                                        <div class="add-to-link">
                                                            <ul>
                                                                <li><a href="{{ route('home.show', $item->slug) }}"
                                                                        title="Chi tiết"><i
                                                                            class="fa fa-external-link"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single-shop-end -->
                                @endforeach
                            @else
                                <div class="div-search col-12">
                                    <div height="200" width="200" class="img-search">
                                        <img src="{{ asset('User/img/no-products-found.png') }}">
                                    </div>
                                    <p class="title-seach">Không tìm thấy sản phẩm nào</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- tab-area-end -->
                    <!-- pagination-area-start -->
                    {{--  <div class="pagination-area mt-50">
                        <div class="list-page-2">
                            <p>Items 1-9 of 11</p>
                        </div>
                        <div class="page-number">
                            <ul>
                                <li><a href="#" class="active">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#" class="angle"><i class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </div>
                    </div>  --}}
                    <!-- pagination-area-end -->
                </div>
            </div>
        </div>
    </div>
    <!-- shop-main-area-end -->
@endsection
@section('js')
    <script>
        $('.boloc-mucgia').click(function() {
            var mucgia = [],
                temp = [];
            $.each($("[data-filter='mucgia']:checked"), function() {
                temp.push($(this).val());
            });
            if (temp.length !== 0) {
                mucgia += '?mucgia=' + temp.toString() +
                    '&sapxep={{ request()->sapxep }}' +
                    '&txtSearch={{ request()->txtSearch }}' +
                    '&txtCate={{ request()->txtCate }}';
            } else {
                url = '{!! url()->full() !!}';
                url = url.replace("&mucgia={{ request()->mucgia }}", "");
                window.location.href = url.replace("mucgia={{ request()->mucgia }}&", "");
                return false;
            }
            window.location.href = mucgia;
        });
        $('.boloc-manhinh').click(function() {
            var manhinh = [],
                temp = [];
            $.each($("[data-filter='manhinh']:checked"), function() {
                temp.push($(this).val());
            });
            if (temp.length !== 0) {
                manhinh += '?manhinh=' + temp.toString() +
                    '&mucgia={{ request()->mucgia }}' +
                    '&sapxep={{ request()->sapxep }}' +
                    '&txtSearch={{ request()->txtSearch }}' +
                    '&txtCate={{ request()->txtCate }}';
            } else {
                url = '{!! url()->full() !!}';
                url = url.replace("&manhinh={{ request()->manhinh }}", "");
                window.location.href = url.replace("manhinh={{ request()->manhinh }}&", "");
                return false;
            }
            window.location.href = manhinh;
        });
        $('.boloc-ram').click(function() {
            var ram = [],
                temp = [];
            $.each($("[data-filter='ram']:checked"), function() {
                temp.push($(this).val());
            });
            if (temp.length !== 0) {
                ram += '?ram=' + temp.toString() +
                    '&mucgia={{ request()->mucgia }}' +
                    '&manhinh={{ request()->manhinh }}' +
                    '&rom={{ request()->rom }}' +
                    '&sapxep={{ request()->sapxep }}' +
                    '&txtSearch={{ request()->txtSearch }}' +
                    '&txtCate={{ request()->txtCate }}';
            } else {
                url = '{!! url()->full() !!}';
                url = url.replace("&ram={{ request()->ram }}", "");
                window.location.href = url.replace("ram={{ request()->ram }}&", "");
                return false;
            }
            window.location.href = ram;
        });
        $('.boloc-rom').click(function() {
            var rom = [],
                temp = [];
            $.each($("[data-filter='rom']:checked"), function() {
                temp.push($(this).val());
            });
            if (temp.length !== 0) {
                rom += '?rom=' + temp.toString() +
                    '&mucgia={{ request()->mucgia }}' +
                    '&manhinh={{ request()->manhinh }}' +
                    '&ram={{ request()->ram }}' +
                    '&sapxep={{ request()->sapxep }}' +
                    '&txtSearch={{ request()->txtSearch }}' +
                    '&txtCate={{ request()->txtCate }}';
            } else {
                url = '{!! url()->full() !!}';
                url = url.replace("&rom={{ request()->rom }}", "");
                window.location.href = url.replace("rom={{ request()->rom }}&", "");
                return false;
            }
            window.location.href = rom;
        });
        $('#sapxep').change(function() {
            var urlCu = '{!! url()->full() !!}';
            var urlMoi = urlCu.replace("&sapxep={{ request()->sapxep }}", "");
            @if (isset(request()->mucgia) || isset(request()->manhinh) || isset(request()->ram) || isset(request()->rom))
                var key = "{!! isset(request()->mucgia) || isset(request()->manhinh) || isset(request()->ram) || isset(request()->rom)
                    ? '&'
                    : '?' !!}";
                var url = urlMoi.replace(
                    "?sapxep={{ request()->sapxep }}", "") + "" + key + "sapxep=" + $(this).val();
            @else
                var url2 = urlMoi.replace(
                    "?sapxep={{ request()->sapxep }}", "") + "" + "&sapxep=" + $(this).val();
                var url = url2.replace("&txtSearch={{ request()->txtSearch }}",
                    "?txtSearch={{ request()->txtSearch }}");
            @endif

            if (url) {
                window.location = url;
            }
            return false;
        });
    </script>
@stop

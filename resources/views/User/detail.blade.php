@extends('LayoutUser')
@section('content')
    @include('User.inc.area', ['active' => $product->name, 'cate' => $product->ProToCate])
    <!-- product-main-area-start -->
    <div class="product-main-area mb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 order-lg-1 order-1">
                    <!-- product-main-area-start -->
                    <div class="product-main-area">
                        <div class="row">
                            <div class="col-lg-5 col-md-6 col-12">
                                <div class="flexslider">
                                    <ul class="slides">
                                        <li data-thumb="{{ asset('uploads/sanpham/' . $product->ProToGall->imageDefault) }}">
                                            <img src="{{ asset('uploads/sanpham/' . $product->ProToGall->imageDefault) }}"
                                                alt=""style=" height: 500px !important; " />
                                        </li>
                                        @if ($product->ProToGall->image != '')
                                            @php
                                                $imgArr = explode('|', $product->ProToGall->image);
                                            @endphp
                                            @foreach ($imgArr as $item)
                                                <li data-thumb="{{ asset('uploads/sanpham/' . $item) }}">
                                                    <img src="{{ asset('uploads/sanpham/' . $item) }}"
                                                        alt=""style=" height: 500px !important; " />
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-6 col-12">
                                <div class="product-info-main">
                                    <div class="page-title">
                                        <h1>{{ ucwords($product->name) }}</h1>
                                    </div>
                                    <div class="product-info-stock-sku">
                                        <span>{{ $product->qty > 0 ? 'Còn hàng' : 'Hết hàng' }}</span>
                                        <div class="product-attribute">
                                            <span>SP{{ $product->id }}</span>
                                        </div>
                                    </div>
                                    <div class="product-reviews-summary">
                                        <div class="rating-summary">
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                        </div>
                                        <div class="reviews-actions">
                                            <a href="#"><span class="fb-comments-count" data-href="{{ url()->full() }}"></span> Đánh giá</a>
                                            <a href="#" class="view">Thêm đánh giá</a>
                                        </div>
                                    </div>
                                    <div class="product-info-price">
                                        <div class="price-final">
                                            <span>{{ number_format($product->price) }}₫</span>
                                            @if ($product->priceOld > 0)
                                                <span class="old-price">{{ number_format($product->priceOld) }}₫</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product-add-form">
                                        <form action="#">
                                            <div class="quality-button">
                                                <input class="qty hide_qty_{{ $product->id }}" min="1" max="{{ $product->qty }}"
                                                    name="qtyOrder" type="number" value="1">
                                            </div>
                                            <a href="#" class="addCart" data-proId="{{ $product->id }}" title="Thêm giỏ hàng">Thêm giỏ hàng</a>
                                        </form>
                                    </div>
                                    @php
                                        $check = false;
                                        if (Auth::check() && isset($product->ProToWhish)) {
                                            if ($product->ProToWhish->user_id == Auth::id()) {
                                                $check = true;
                                            }
                                        }
                                    @endphp
                                    <div class="product-social-links">
                                        <div class="product-addto-links">
                                            <a style="color: {!! $check == true ? 'red' : 'white' !!}"
                                                href="{{ route('link.show', $product->id) }}"><i
                                                    class="fa fa-heart"></i></a>
                                            <a href="{{ route('link.edit', $product->id) }}"><i
                                                    class="fa fa-pie-chart"></i></a>
                                            <a href="#"><i class="fa fa-envelope-o"></i></a>
                                        </div>
                                        <div class="product-addto-links-text">
                                            <p>
                                                {!! substr(strip_tags($product->description), 0, 200) !!} ...
                                                <a title="Xem thêm Giới thiệu về nội dung {{ $product->name }}"
                                                    class="readmore-detail" href="javascript:void(0)"
                                                    onclick="ScrollTo('desc');">Xem thêm</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product-main-area-end -->
                    <!-- product-info-area-start -->
                    <div class="product-info-area mt-80">
                        <!-- Nav tabs -->
                        <ul class="nav">
                            <li><a class="active" href="#Details" data-bs-toggle="tab">Mô tả</a></li>
                            <li><a href="#Reviews" data-bs-toggle="tab">Đánh giá (<span class="fb-comments-count" data-href="{{ url()->full() }}"></span>)</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="Details">
                                <div class="valu">
                                    <h3 style="font-weight: normal;font-size: 1.45rem;">{{ ucfirst($product->name) }}</h3>
                                    <p id="desc">{!! $product->description !!}</p><br>
                                    @if (isset($product->phone_id))
                                    <h3 style="font-size: 17px;color: #555555; font-weight: bold; line-height: 1.5;">Thông
                                        tin chi tiết</h3>
                                    <div class="parameter">
                                        <ul class="parameter__list active">
                                            <li data-index="0" data-prop="0">
                                                <p class="lileft">Màn hình:</p>
                                                <div class="liright">
                                                    <span class="comma">{{ $product->ProToPhone->screen }}</span>
                                                </div>
                                            </li>
                                            <li data-index="0" data-prop="0">
                                                <p class="lileft">Hệ điều hành:</p>
                                                <div class="liright">
                                                    <span class="">{{ $product->ProToPhone->system }}</span>
                                                </div>
                                            </li>
                                            <li data-index="0" data-prop="0">
                                                <p class="lileft">Camera sau:</p>
                                                <div class="liright">
                                                    <span class="">{{ $product->ProToPhone->rear_camera }} </span>
                                                </div>
                                            </li>
                                            <li data-index="0" data-prop="0">
                                                <p class="lileft">Camera trước:</p>
                                                <div class="liright">
                                                    <span class="">{{ $product->ProToPhone->front_camera }}</span>
                                                </div>
                                            </li>
                                            <li data-index="0" data-prop="0">
                                                <p class="lileft">Chip:</p>
                                                <div class="liright">
                                                    <span class="">{{ $product->ProToPhone->chip }}</span>
                                                </div>
                                            </li>
                                            <li data-index="0" data-prop="0">
                                                <p class="lileft">RAM:</p>
                                                <div class="liright">
                                                    <span class="">{{ $product->ProToPhone->ram }} GB</span>
                                                </div>
                                            </li>
                                            <li data-index="0" data-prop="0">
                                                <p class="lileft">Dung lượng lưu trữ:</p>
                                                <div class="liright">
                                                    <span class="">{{ $product->ProToPhone->rom }} GB</span>
                                                </div>
                                            </li>
                                            <li data-index="0" data-prop="0">
                                                <p class="lileft">SIM:</p>
                                                <div class="liright">
                                                    <span class="comma">{{ $product->ProToPhone->sim }}</span>
                                                </div>
                                            </li>
                                            <li data-index="0" data-prop="0">
                                                <p class="lileft">Pin, Sạc:</p>
                                                <div class="liright">
                                                    <span class="comma">{!! $product->ProToPhone->pin !!}</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Reviews">
                                <div class="valu valu-2">
                                    <div class="fb-comments" data-href="{{ url()->full() }}" data-width="100%" data-numposts="5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product-info-area-end -->
                    <!-- new-book-area-start -->
                    <div class="new-book-area mt-60">
                        <div class="section-title text-center mb-30">
                            <h3>{{ isset($productlike[0]['count']) ? 'CÓ THỂ BẠN CŨNG THÍCH' : 'CÁC SẢN PHẨM KHÁC CỦA SHOP' }}
                            </h3>
                        </div>
                        <div class="tab-active-2 owl-carousel">
                            <!-- single-product-start -->
                            @foreach ($productlike as $item)
                                <div class="product-wrapper">
                                    <div class="product-img">
                                        <a href="{{ route('home.show', $item->slug) }}">
                                            <img src="{{ asset('uploads/sanpham/' . $item->ProToGall->imageDefault) }}"
                                                alt="book" class="primary" />
                                        </a>
                                        <div class="quick-view">
                                            <a class="action-view" href="#"
                                                onclick="doDuLieuSanPham({{ $item->id }})" title="Xem Nhanh">
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
                                                            class="discount-percentage">-{{ number_format((($item->priceOld - $item->price) / $item->price) * 100) }}%</span>
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
                                            <a href="#" title="Thêm giỏ hàng"><i
                                                    class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                                        </div>
                                        <div class="add-to-link">
                                            <ul>
                                                <li><a href="{{ route('home.show', $item->slug) }}" title="Chi tiết"><i
                                                            class="fa fa-external-link"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- single-product-end -->
                        </div>
                    </div>
                    <!-- new-book-area-start -->
                </div>
            </div>
        </div>
    </div>
    <!-- product-main-area-end -->
@endsection
@section('js')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v18.0" nonce="N23HVZeX"></script>
@stop

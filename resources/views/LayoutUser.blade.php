<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Phong Van</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" sizes="32x32">

    <!-- all css here -->
    <!-- bootstrap v3.3.6 css -->
    <link rel="stylesheet" href="{{ asset('User/css/bootstrap.min.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('User/css/animate.css') }}">
    <!-- meanmenu css -->
    <link rel="stylesheet" href="{{ asset('User/css/meanmenu.min.css') }}">
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="{{ asset('User/css/owl.carousel.css') }}">
    <!-- font-awesome css -->
    <link rel="stylesheet" href="{{ asset('User/css/font-awesome.min.css') }}">
    <!-- flexslider.css-->
    <link rel="stylesheet" href="{{ asset('User/css/flexslider.css') }}">
    <!-- chosen.min.css-->
    <link rel="stylesheet" href="{{ asset('User/css/chosen.min.css') }}">
    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('User/style.css') }}">
    <link rel="stylesheet" href="{{ asset('User/css/main.css') }}">
    <!-- responsive css -->
    <link rel="stylesheet" href="{{ asset('User/css/responsive.css') }}">
    @yield('css')
    <style>
        .active-color{
            color: #00abe0 !important;
        }
    </style>
    <!-- modernizr css -->
    <script src="{{ asset('User/js/vendor/modernizr-2.8.3.min.js') }}"></script>
</head>

<body class="home-4">

    <header>
        <!-- header-top-area-start -->
        <div class="header-top-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="language-area">
                            <ul>
                                <li><img src="{{ asset('User/img/flag/4.png') }}" alt="flag" /><a
                                        href="#">Tiếng việt<i class="fa fa-angle-down"></i></a>
                                    <div class="header-sub">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="{{ asset('User/img/flag/4.png') }}"
                                                        alt="flag" />Vi</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="{{ asset('User/img/flag/1.jpg') }}"
                                                        alt="flag" />En</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="account-area text-end">
                            <ul>
                                @if (auth()->check())
                                    <li><a href="{{ route('myaccount.index') }}">Thông tin tài khoản</a></li>
                                @endif
                                <li><a href="{{ route('cart.create') }}">Thanh Toán</a></li>
                                @if (auth()->check())
                                    <li>
                                        <form action="{{ route('auth.store') }}" method="POST" class="submitForm">
                                            @csrf
                                            <input type="hidden" name="action" value="logout">
                                            <a href="#" id="clickSubmit">Đăng xuất</a>
                                        </form>
                                    </li>
                                @else
                                    <li><a href="{{ route('authuser.signin.index') }}">Đăng Nhập</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header-top-area-end -->
        <!-- header-mid-area-start -->
        <div class="header-mid-area ptb-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="logo-area">
                            <a href="{{ route('home.index') }}"><img src="{{ asset('User/img/logo/1.png') }}"
                                alt="logo" /></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5 col-12">
                        <div class="header-search">
                            <form action="{{ route('search.index') }}" method="GET">
                                <input type="text" list="showProduct" id="txtSearch" name="txtSearch" placeholder="Tìm mọi thứ ở đây..." />
                                <button style="border: none;" type="submit"><i style="display: block;"
                                        class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="my-cart">
                            <ul>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i>Giỏ hàng</a>
                                    <span>{{ Cart::count() }}</span>
                                    <div class="mini-cart-sub">
                                        <div class="cart-product">
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach (Cart::content() as $item)
                                                @php
                                                    $total += $item->qty * $item->price;
                                                @endphp
                                                <div class="single-cart">
                                                    <div class="cart-img">
                                                        <a href="{{ route('home.show', $item->options->slug) }}"><img
                                                                src="{{ asset('uploads/sanpham/' . $item->options->image) }}"
                                                                alt="book" /></a>
                                                    </div>
                                                    <div class="cart-info">
                                                        <h5><a
                                                                href="{{ route('home.show', $item->options->slug) }}">{{ ucwords($item->name) }}</a>
                                                        </h5>
                                                        <p>{{ $item->qty }} x
                                                            {{ number_format($item->price) }}₫</p>
                                                    </div>
                                                    <div class="cart-icon">
                                                        <a href="{{ route('cart.show', $item->rowId) }}"><i
                                                                class="fa fa-remove"></i></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="cart-totals">
                                            <h5>Tổng <span>{{ number_format($total) }}₫</span></h5>
                                        </div>
                                        <div class="cart-bottom">
                                            <a class="view-cart" href="{{ route('cart.index') }}">Xem giỏ
                                                hàng</a>
                                            <a href="{{ route('cart.create') }}">thanh toán</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header-mid-area-end -->
        <!-- main-menu-area-start -->
        <div class="main-menu-area d-md-none d-none d-lg-block" id="header-sticky">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="menu-area">
                            <nav>
                                <ul>
                                    <li class="{{ Navigation::isActiveRoute('home') }}">
                                        <a href="{{ route('home.index') }}">Trang Chủ</a>
                                    </li>

                                    <li class="{{ Navigation::isActiveRoute(['cart','link','links','all']) }}"><a href="#">Chi Tiết<i class="fa fa-angle-down"></i></a>
                                        <div class="sub-menu sub-menu-2">
                                            <ul>
                                                <li><a href="{{ route('all.create') }}" class="{{ Navigation::isActiveRoute('all','active-color') }}">Tất Cả sản phẩm</a></li>
                                                <li><a href="{{ route('cart.create') }}" class="{{ Navigation::isActiveRoute('cart','active-color') }}">thanh toán</a></li>
                                                <li><a href="{{ route('links.index') }}" class="{{ Navigation::isActiveRoute('links','active-color') }}">yêu thích</a></li>
                                                <li><a href="{{ route('link.create') }}" class="{{ Navigation::isActiveRoute('link','active-color') }}">so sánh</a></li>
                                                <li><a href="404">404 Page</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="{{ Navigation::isActiveRoute('post') }}">
                                        <a href="{{ route('post.index') }}">Bài Viết</a>
                                    </li>
                                    <li class="{{ Navigation::isActiveRoute('about') }}"><a href="{{ route('about.create') }}">Giới Thiệu</a></li>
                                    <li class="{{ Navigation::isActiveRoute('contact') }}"><a href="{{ route('contact.index') }}">Liên Hệ</a></li>

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-menu-area-end -->
        <!-- mobile-menu-area-start -->
        <div class="mobile-menu-area d-lg-none d-block fix">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mobile-menu">
                            <nav id="mobile-menu-active">
                                <ul id="nav">
                                    <li><a href="index.html">Home</a>
                                        <ul>
                                            <li><a href="index.html">Home-1</a></li>
                                            <li><a href="index-2.html">Home-2</a></li>
                                            <li><a href="index-3.html">Home-3</a></li>
                                            <li><a href="index-4.html">Home-4</a></li>
                                            <li><a href="index-5.html">Home-5</a></li>
                                            <li><a href="index-6.html">Home-6</a></li>
                                            <li><a href="index-7.html">Home-7</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="shop.html">Enable Cookies</a></li>
                                    <li><a href="product-details.html">Pages</a>
                                        <ul>
                                            <li><a href="shop.html">shop</a></li>
                                            <li><a href="shop-list.html">shop list view</a></li>
                                            <li><a href="product-details.html">product-details</a></li>
                                            <li><a href="product-details-affiliate.html">product-affiliate</a></li>
                                            <li><a href="blog.html">blog</a></li>
                                            <li><a href="blog-details.html">blog-details</a></li>
                                            <li><a href="contact.html">contact</a></li>
                                            <li><a href="about.html">about</a></li>
                                            <li><a href="login.html">login</a></li>
                                            <li><a href="register.html">register</a></li>
                                            <li><a href="my-account.html">my-account</a></li>
                                            <li><a href="cart.html">cart</a></li>
                                            <li><a href="compare.html">compare</a></li>
                                            <li><a href="checkout.html">checkout</a></li>
                                            <li><a href="wishlist.html">wishlist</a></li>
                                            <li><a href="404.html">404 Page</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.html">contact us</a></li>
                                    <li><a href="#">blog</a>
                                        <ul>
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="blog-details.html">blog-details</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile-menu-area-end -->
    </header>
    <!-- header-area-end -->
    @yield('content')
    <!-- footer-area-start -->
    <footer>
        <!-- footer-top-start -->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-top-menu bb-2">
                            <nav>
                                <ul>
                                    <li><a href="#">Trang Chủ</a></li>
                                    <li><a href="#">Bật Cookie</a></li>
                                    <li><a href="#">Chính Sách Quyền Riêng Tư Và Cookie</a></li>
                                    <li><a href="#">Liên Hệ Chúng Tôi</a></li>
                                    <li><a href="#">blog</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer-top-start -->
        <!-- footer-mid-start -->
        <div class="footer-mid ptb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="single-footer br-2 xs-mb">
                                    <div class="footer-title mb-20">
                                        <h3>CÁC SẢN PHẨM</h3>
                                    </div>
                                    <div class="footer-mid-menu">
                                        <ul>
                                            <li><a href="#">Về chúng tôi</a></li>
                                            <li><a href="#">Giá giảm </a></li>
                                            <li><a href="#">Sản phẩm mới</a></li>
                                            <li><a href="#">Sản phấm bán tốt nhất</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="single-footer br-2 xs-mb">
                                    <div class="footer-title mb-20">
                                        <h3>Công ty chúng tôi</h3>
                                    </div>
                                    <div class="footer-mid-menu">
                                        <ul>
                                            <li><a href="#">Liên hệ chúng tôi</a></li>
                                            <li><a href="#">Sơ đồ trang web</a></li>
                                            <li><a href="#">Cửa hàng</a></li>
                                            <li><a href="#">Tài khoản của tôi </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="single-footer br-2 xs-mb">
                                    <div class="footer-title mb-20">
                                        <h3>Tài khoản của bạn</h3>
                                    </div>
                                    <div class="footer-mid-menu">
                                        <ul>
                                            <li><a href="#">Địa chỉ</a></li>
                                            <li><a href="#">Phiếu tín dụng </a></li>
                                            <li><a href="#"> Đơn đặt hàng</a></li>
                                            <li><a href="#">Thông tin cá nhân</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="single-footer mrg-sm">
                            <div class="footer-title mb-20">
                                <h3>Thông tin cửa hàng</h3>
                            </div>
                            <div class="footer-contact">
                                <p class="adress">
                                    <span>Công ty của tôi</span> 123Abc, K88.
                                </p>
                                <p><span>Gọi ngay cho chúng tôi:</span> 01234xxxxxx</p>
                                <p><span>Email:</span> support@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer-mid-end -->
        <!-- footer-bottom-start -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row bt-2">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="copy-right-area">
                            <p>&copy; {{ now()->format('Y') }} <strong> PhongVan </strong>❤️<a href="#"
                                    target="_blank"><strong>PiPj</strong></a>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="payment-img text-end">
                            <a href="#"><img src="{{ asset('User/img/1.png') }}" alt="payment" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer-bottom-end -->
    </footer>
    <!-- footer-area-end -->

    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="modal-tab">
                                <div class="product-details-large tab-content">
                                    <div class="tab-pane active" id="image-x">
                                        <img id="imageModal" src="" alt="" />
                                    </div>
                                    @for ($i = 0; $i <= 1; $i++)
                                        <div class="tab-pane arrImg" id="image-{{ $i }}">
                                            <img class="imageArrModal{{ $i }}" src=""
                                                alt="" />
                                        </div>
                                    @endfor

                                </div>
                                <div class="product-details-small quickview-active owl-carousel">
                                    <a class="active" href="#image-x"><img class="imageSubModal" src=""
                                            alt="" /></a>
                                    @for ($i = 0; $i <= 1; $i++)
                                        <a class="arrImgSub" href="#image-{{ $i }}"><img
                                                class="imageArrSubModal{{ $i }}" src=""
                                                alt="" /></a>
                                    @endfor

                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="modal-pro-content">
                                <h3 id="nameModal">Chaz Kangeroo Hoodie3</h3>
                                <div class="price">
                                    <span id="priceModal">$70.00</span>
                                </div>
                                <p id="descModal"></p>
                                <form action="#">
                                    <input type="number" min="1" value="1" />
                                    <button>Thêm giỏ hàng</button>
                                </form>
                                <span><i class="fa fa-check"></i> Còn Hàng</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->

    <!-- all js here -->
    <!-- jquery latest version -->
    <script src="{{ asset('User/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('User/js/bootstrap.min.js') }}"></script>
    <!-- owl.carousel js -->
    <script src="{{ asset('User/js/owl.carousel.min.js') }}"></script>
    <!-- meanmenu js -->
    <script src="{{ asset('User/js/jquery.meanmenu.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset('User/js/wow.min.js') }}"></script>
    <!-- jquery.parallax-1.1.3.js -->
    <script src="{{ asset('User/js/jquery.parallax-1.1.3.js') }}"></script>
    <!-- jquery.countdown.min.js -->
    <script src="{{ asset('User/js/jquery.countdown.min.js') }}"></script>
    <!-- jquery.flexslider.js -->
    <script src="{{ asset('User/js/jquery.flexslider.js') }}"></script>
    <!-- chosen.jquery.min.js -->
    <script src="{{ asset('User/js/chosen.jquery.min.js') }}"></script>
    <!-- jquery.counterup.min.js -->
    <script src="{{ asset('User/js/jquery.counterup.min.js') }}"></script>
    <!-- waypoints.min.js -->
    <script src="{{ asset('User/js/waypoints.min.js') }}"></script>
    <!-- plugins js -->
    <script src="{{ asset('User/js/plugins.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('User/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let timer = null;

        function debunce(calback) {
            if (timer) clearTimeout(timer)
            timer = setTimeout(() => calback(), 1000);
        }
    </script>
    @yield('js')

    <script>

        @if (session()->has('error'))
            Swal.fire({
                title: 'Lỗi!',
                html: '{!! session()->get('error') !!}',
                icon: 'error',
                confirmButtonText: 'Tiếp tục'
            });
        @endif
        @if (session()->has('success'))
            Swal.fire({
                title: 'Thành công!',
                text: '{!! session()->get('success') !!}',
                icon: 'success',
                confirmButtonText: 'Tiếp tục'
            });
        @endif
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function ScrollTo($id) {
            const element = document.getElementById($id);
            element.scrollIntoView();
        }

        $(document).on('click', '.addCart', function(e) {
            e.preventDefault();
            var id = $(this).data('proid');
            var qty = $('.hide_qty_' + id).val();

            $.ajax({
                type: 'post',
                url: '{{ route('home.store') }}',
                data: {
                    'id': id,
                    'qty': qty,
                    'action': 'addToCart',
                },
                success: function(res) {
                    location.reload();
                }
            })

        });

        $(document).on('click', '#clickSubmit', function(e) {
            e.preventDefault();
            $('.submitForm').submit();
        });
    </script>
</body>

</html>

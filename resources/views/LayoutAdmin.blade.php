<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('BackEnd/css/bootstrap-reboot.min.css') }}">
    <link rel="stylesheet" href="{{ asset('BackEnd/css/bootstrap-grid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('BackEnd/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('BackEnd/css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('BackEnd/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('BackEnd/css/admin.css') }}">
    @yield('css')

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('BackEnd/icon/favicon-32x32.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <meta name="keywords" content="">
    <meta name="author" content="Dmitry Volkov">
    <title>Phong Van</title>

</head>

<body>

    <!-- header -->
    <header class="header">
        <div class="header__content">
            <!-- header logo -->
            <a href="{{ route('tongquan.index') }}" class="header__logo"
                style="font-size: 26px; color: white;padding-left: 12%; text-transform: uppercase; ">
                <span>Phong</span>&nbsp;<span class="text-gradient">vân</span>
            </a>
            <!-- end header logo -->

            <!-- header menu btn -->
            <button class="header__btn" type="button">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <!-- end header menu btn -->
        </div>
    </header>
    <!-- end header -->
    <form action="{{ route('auth.store') }}" method="POST">
        @csrf
        <!-- sidebar -->
        <div class="sidebar">
            <!-- sidebar logo -->
            <a href="{{ route('tongquan.index') }}" class="sidebar__logo"
                style="font-size: 26px; color: white;padding-left: 12%; text-transform: uppercase; ">
                <span>Phong</span>&nbsp;<span class="text-gradient">vân</span>
            </a>
            <!-- end sidebar logo -->

            <!-- sidebar user -->

            <div class="sidebar__user">
                <div class="sidebar__user-img">
                    <img src="{{ asset('User/img/user.png') }}" alt="">
                </div>
                @php
                    $roles = auth()->user()->roles;
                    foreach ($roles as $role) {
                        $roleName = $role->display_name;
                    }
                @endphp
                <div class="sidebar__user-title">
                    <span>{{ ucfirst($roleName) }}</span>
                    <p>{{ ucwords(auth()->user()->name) }}</p>
                </div>

                <input type="hidden" name="action" value="logout">
                <input type="hidden" name="route" value="admin">
                <button class="sidebar__user-btn" type="submit" title="logout">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path
                            d="M4,12a1,1,0,0,0,1,1h7.59l-2.3,2.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0l4-4a1,1,0,0,0,.21-.33,1,1,0,0,0,0-.76,1,1,0,0,0-.21-.33l-4-4a1,1,0,1,0-1.42,1.42L12.59,11H5A1,1,0,0,0,4,12ZM17,2H7A3,3,0,0,0,4,5V8A1,1,0,0,0,6,8V5A1,1,0,0,1,7,4H17a1,1,0,0,1,1,1V19a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V16a1,1,0,0,0-2,0v3a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V5A3,3,0,0,0,17,2Z">
                        </path>
                    </svg>
                </button>

            </div>

            <!-- end sidebar user -->

            <!-- sidebar nav -->
            <ul class="sidebar__nav">
                @can('list-dashboard')
                    <li class="sidebar__nav-item">
                        <a href="{{ route('tongquan.index') }}"
                            class="sidebar__nav-link {{ Navigation::isActiveRoute('tongquan') }}"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path
                                    d="M10,13H3a1,1,0,0,0-1,1v7a1,1,0,0,0,1,1h7a1,1,0,0,0,1-1V14A1,1,0,0,0,10,13ZM9,20H4V15H9ZM21,2H14a1,1,0,0,0-1,1v7a1,1,0,0,0,1,1h7a1,1,0,0,0,1-1V3A1,1,0,0,0,21,2ZM20,9H15V4h5Zm1,4H14a1,1,0,0,0-1,1v7a1,1,0,0,0,1,1h7a1,1,0,0,0,1-1V14A1,1,0,0,0,21,13Zm-1,7H15V15h5ZM10,2H3A1,1,0,0,0,2,3v7a1,1,0,0,0,1,1h7a1,1,0,0,0,1-1V3A1,1,0,0,0,10,2ZM9,9H4V4H9Z" />
                            </svg> Tổng Quan</a>
                    </li>
                @endcan
                @can('list-category')
                    <li class="sidebar__nav-item">
                        <a href="{{ route('theloai.index') }}"
                            class="sidebar__nav-link {{ Navigation::isActiveRoute('theloai') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                <path d="M256 80C141.1 80 48 173.1 48 288V392c0 13.3-10.7 24-24 24s-24-10.7-24-24V288C0 146.6 114.6 32 256 32s256 114.6 256 256V392c0 13.3-10.7 24-24 24s-24-10.7-24-24V288c0-114.9-93.1-208-208-208zM80 352c0-35.3 28.7-64 64-64h16c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H144c-35.3 0-64-28.7-64-64V352zm288-64c35.3 0 64 28.7 64 64v64c0 35.3-28.7 64-64 64H352c-17.7 0-32-14.3-32-32V320c0-17.7 14.3-32 32-32h16z"/>
                            </svg> Thể Loại</a>
                    </li>
                @endcan
                @can('list-product')
                    <li class="sidebar__nav-item">
                        <a href="{{ route('sanpham.index') }}"
                            class="sidebar__nav-link {{ Navigation::isActiveRoute('sanpham') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                                <path d="M16 64C16 28.7 44.7 0 80 0H304c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H80c-35.3 0-64-28.7-64-64V64zM144 448c0 8.8 7.2 16 16 16h64c8.8 0 16-7.2 16-16s-7.2-16-16-16H160c-8.8 0-16 7.2-16 16zM304 64H80V384H304V64z"/>
                            </svg> Sản Phẩm </a>
                    </li>
                @endcan
                @can('list-order')
                    <li class="sidebar__nav-item">
                        <a href="{{ route('donhang.index') }}"
                            class="sidebar__nav-link {{ Navigation::isActiveRoute('donhang') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512">
                                <path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64H48c8.8 0 16 7.2 16 16V368c0 44.2 35.8 80 80 80h18.7c-1.8 5-2.7 10.4-2.7 16c0 26.5 21.5 48 48 48s48-21.5 48-48c0-5.6-1-11-2.7-16H450.7c-1.8 5-2.7 10.4-2.7 16c0 26.5 21.5 48 48 48s48-21.5 48-48c0-5.6-1-11-2.7-16H608c17.7 0 32-14.3 32-32s-14.3-32-32-32H144c-8.8 0-16-7.2-16-16V80C128 35.8 92.2 0 48 0H32zM192 80V272c0 26.5 21.5 48 48 48H560c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48H464V176c0 5.9-3.2 11.3-8.5 14.1s-11.5 2.5-16.4-.8L400 163.2l-39.1 26.1c-4.9 3.3-11.2 3.6-16.4 .8s-8.5-8.2-8.5-14.1V32H240c-26.5 0-48 21.5-48 48z"/>
                            </svg> Đơn Hàng</a>
                    </li>
                @endcan
                @can('list-import')
                    <li class="sidebar__nav-item">
                        <a href="{{ route('phieunhap.index') }}"
                            class="sidebar__nav-link {{ Navigation::isActiveRoute('phieunhap') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                <path d="M128 64c0-35.3 28.7-64 64-64H352V128c0 17.7 14.3 32 32 32H512V448c0 35.3-28.7 64-64 64H192c-35.3 0-64-28.7-64-64V336H302.1l-39 39c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l80-80c9.4-9.4 9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l39 39H128V64zm0 224v48H24c-13.3 0-24-10.7-24-24s10.7-24 24-24H128zM512 128H384V0L512 128z"/>
                            </svg> Phiếu Nhập</a>
                    </li>
                @endcan
                @can('list-discount')
                    <li class="sidebar__nav-item">
                        <a href="{{ route('giamgia.index') }}"
                            class="sidebar__nav-link {{ Navigation::isActiveRoute('giamgia') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                <path d="M225.9 32C103.3 32 0 130.5 0 252.1 0 256 .1 480 .1 480l225.8-.2c122.7 0 222.1-102.3 222.1-223.9C448 134.3 348.6 32 225.9 32zM224 384c-19.4 0-37.9-4.3-54.4-12.1L88.5 392l22.9-75c-9.8-18.1-15.4-38.9-15.4-61 0-70.7 57.3-128 128-128s128 57.3 128 128-57.3 128-128 128z"/>
                            </svg> Mã Giãm Giá</a>
                    </li>
                @endcan
                @can('list-slider')
                    <li class="sidebar__nav-item">
                        <a href="{{ route('slider.index') }}"
                            class="sidebar__nav-link {{ Navigation::isActiveRoute('slider') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                <path d="M0 416c0 17.7 14.3 32 32 32l54.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 448c17.7 0 32-14.3 32-32s-14.3-32-32-32l-246.7 0c-12.3-28.3-40.5-48-73.3-48s-61 19.7-73.3 48L32 384c-17.7 0-32 14.3-32 32zm128 0a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM320 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm32-80c-32.8 0-61 19.7-73.3 48L32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l246.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48l54.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-54.7 0c-12.3-28.3-40.5-48-73.3-48zM192 128a32 32 0 1 1 0-64 32 32 0 1 1 0 64zm73.3-64C253 35.7 224.8 16 192 16s-61 19.7-73.3 48L32 64C14.3 64 0 78.3 0 96s14.3 32 32 32l86.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 128c17.7 0 32-14.3 32-32s-14.3-32-32-32L265.3 64z"/>
                            </svg> Sliders</a>
                    </li>
                @endcan
                @canany(['list-user','list-role','add-dashboard'])
                <li class="dropdown sidebar__nav-item">
                    <a class="dropdown-toggle sidebar__nav-link {{ Navigation::isActiveRoute('taikhoan') }} {{ Navigation::isActiveRoute('vaitro') }}"
                        href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <path
                                d="M12,2A10,10,0,0,0,4.65,18.76h0a10,10,0,0,0,14.7,0h0A10,10,0,0,0,12,2Zm0,18a8,8,0,0,1-5.55-2.25,6,6,0,0,1,11.1,0A8,8,0,0,1,12,20ZM10,10a2,2,0,1,1,2,2A2,2,0,0,1,10,10Zm8.91,6A8,8,0,0,0,15,12.62a4,4,0,1,0-6,0A8,8,0,0,0,5.09,16,7.92,7.92,0,0,1,4,12a8,8,0,0,1,16,0A7.92,7.92,0,0,1,18.91,16Z" />
                        </svg>Tài Khoản</a>
                    <ul class="dropdown-menu sidebar__dropdown-menu scrollbar-dropdown"
                        aria-labelledby="dropdownMenuMore">
                        @can('list-user')
                            <li>
                                <a class="{{ Navigation::isActiveRoute('taikhoan') }}"
                                    href="{{ route('taikhoan.index') }}">Danh Sách</a>
                            </li>
                        @endcan
                        @can('list-role')
                            <li>
                                <a class="{{ Navigation::isActiveRoute('vaitro') }}"
                                    href="{{ route('vaitro.index') }}">Phân Quyền</a>
                            </li>
                        @endcan
                        @can('add-dashboard')
                            <li>
                                <a class="{{ Navigation::isActiveRoute('tongquan') }}"
                                    href="{{ route('tongquan.create') }}">Thêm Nhiệm Vụ</a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                @canany(['list-type','list-post'])
                <!-- dropdown -->
                <li class="dropdown sidebar__nav-item">
                    <a class="dropdown-toggle sidebar__nav-link" href="#" role="button" id="dropdownMenuMore"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <path d="M192 32c0 17.7 14.3 32 32 32c123.7 0 224 100.3 224 224c0 17.7 14.3 32 32 32s32-14.3 32-32C512 128.9 383.1 0 224 0c-17.7 0-32 14.3-32 32zm0 96c0 17.7 14.3 32 32 32c70.7 0 128 57.3 128 128c0 17.7 14.3 32 32 32s32-14.3 32-32c0-106-86-192-192-192c-17.7 0-32 14.3-32 32zM96 144c0-26.5-21.5-48-48-48S0 117.5 0 144V368c0 79.5 64.5 144 144 144s144-64.5 144-144s-64.5-144-144-144H128v96h16c26.5 0 48 21.5 48 48s-21.5 48-48 48s-48-21.5-48-48V144z"/>
                        </svg> Bài Viết</a>
                    <ul class="dropdown-menu sidebar__dropdown-menu scrollbar-dropdown"
                        aria-labelledby="dropdownMenuMore">
                        @can('list-type')
                        <li><a href="{{ route('loaibaiviet.index') }}">Thể Loại</a></li>
                        @endcan
                        @can('list-post')
                        <li><a href="{{ route('baiviet.index') }}">Danh sách</a></li>
                        @endcan
                    </ul>
                </li>
                <!-- end dropdown -->
                @endcanany
                @can('list-tag')
                    <li class="sidebar__nav-item">
                        <a href="{{ route('tags.index') }}"
                            class="sidebar__nav-link {{ Navigation::isActiveRoute('tags') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                <path d="M345 39.1L472.8 168.4c52.4 53 52.4 138.2 0 191.2L360.8 472.9c-9.3 9.4-24.5 9.5-33.9 .2s-9.5-24.5-.2-33.9L438.6 325.9c33.9-34.3 33.9-89.4 0-123.7L310.9 72.9c-9.3-9.4-9.2-24.6 .2-33.9s24.6-9.2 33.9 .2zM0 229.5V80C0 53.5 21.5 32 48 32H197.5c17 0 33.3 6.7 45.3 18.7l168 168c25 25 25 65.5 0 90.5L277.3 442.7c-25 25-65.5 25-90.5 0l-168-168C6.7 262.7 0 246.5 0 229.5zM144 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
                            </svg>
                            Tags</a>
                    </li>
                @endcan
            </ul>
            <!-- end sidebar nav -->

            <!-- sidebar copyright -->
            <div class="sidebar__copyright">© PhongVan, {{ now()->format('Y') }}. <br>Create by <a href="#" target="_blank"
                    rel="noopener">PiPj</a>.</div>
            <!-- end sidebar copyright -->
        </div>
    </form>
    <!-- end sidebar -->

    <!-- main content -->
    @yield('content')

    <!-- end main content -->
    <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
    <!-- JS -->
    <script src="{{ asset('BackEnd/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('BackEnd/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('BackEnd/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('BackEnd/js/jquery.mousewheel.min.js') }}"></script>
    <script src="{{ asset('BackEnd/js/jquery.mCustomScrollbar.min.js') }}"></script>
    <script src="{{ asset('BackEnd/js/select2.min.js') }}"></script>
    <script src="{{ asset('BackEnd/js/admin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="csrf-token"]').val()
                }
            });
        });
    </script>
    @yield('page')
    @yield('js')

    <script>
        {{--  $('.eventClick').click(function(){
            $(this).attr('disabled','disabled');
            $(this).text('Đang tải...');
            setTimeout(function() {
                $('.eventClick').attr('disabled',false);
                $('.eventClick').text('thêm');
            }, 2000);
        });  --}}

        function formatGia(input) {
            input.value = parseFloat(input.value.replace(/,/g, ""))
                .toFixed(0)
                .toString()
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        };

        function dinhDangGia(input) {
            var giaTri = input.value.split(","); // format tien ,,, lai thanh so
            var temp = "";
            for (var i = 0; i < giaTri.length; i++) {
                temp += giaTri[i];
            }
            input.value = parseFloat(temp);
            if (isNaN(input.value)) {
                input.value = 0;
            } else {
                formatGia(input);
            }
        };
    </script>
</body>

</html>

@extends('LayoutUser')
@section('css')
    <style>
        .sidebar-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            display: block;
            margin-right: 12px;
            border: 1px solid #efefef;
        }

        .sidebar-img img {
            width: 100%;
        }

        .sidebar-title {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
        }

        .sidebar-title span {
            display: block;
            font-family: 'Open Sans', sans-serif;
            color: rgba(164, 164, 164, 0.5);
            font-size: 10px;
        }

        .sidebar-title p {
            color: #222222;
            display: block;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 0;
        }

        .col-3 {
            width: 60px;
        }
    </style>
@stop
@section('content')
    @include('User.inc.area', ['active' => 'Thông tin tài khoản'])
    <!-- entry-header-area-start -->
    <div class="entry-header-area">
        <div class="container">
            <div class="row">

                <div class="col-3">
                    <div class="col-6 sidebar-img">
                        <img src="{{ asset('User/img/user.png') }}" alt="">
                    </div>
                </div>
                <div class="col-9">
                    @php
                        $roles = auth()->user()->roles;
                        foreach ($roles as $role) {
                            $roleName = $role->display_name;
                        }
                    @endphp
                    <div class="col-6 sidebar-title">
                        <span>{{ ucfirst($roleName) }}</span>
                        <p>{{ ucwords(auth()->user()->name) }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- entry-header-area-end -->
    <!-- my account wrapper start -->
    <div class="my-account-wrapper mb-70">
        <div class="container">
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- My Account Page Start -->
                        <div class="myaccount-page-wrapper">
                            <!-- My Account Tab Menu Start -->
                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    <div class="myaccount-tab-menu nav" role="tablist">
                                        @can('list-dashboard')
                                        <a href="{{ route('tongquan.index') }}"><i
                                            class="fa fa-unlock"></i>Trang quản trị</a>
                                        @endcan
                                        <a href="#dashboad" class="clickTabList active" data-bs-toggle="tab"><i
                                                class="fa fa-dashboard"></i>
                                            Bảng điều khiển </a>
                                        <a href="#orders" class="clickTabList" data-bs-toggle="tab"><i
                                                class="fa fa-cart-arrow-down"></i>
                                            Đơn đặt hàng</a>
                                        {{--  <a href="#download" class="clickTabList" data-bs-toggle="tab"><i
                                                class="fa fa-cloud-download"></i>
                                            Tải xuống</a>  --}}

                                        <a href="#account-info" class="clickTabList" data-bs-toggle="tab"><i
                                                class="fa fa-user"></i> chi tiết tài
                                            khoản</a>
                                        <form action="{{ route('auth.store') }}" method="POST" class="submitForm">
                                            @csrf
                                            <input type="hidden" name="action" value="logout">
                                            <a href="#" id="clickSubmit"><i class="fa fa-sign-out"></i> đăng xuất</a>
                                        </form>
                                    </div>
                                </div>
                                <!-- My Account Tab Menu End -->

                                <!-- My Account Tab Content Start -->
                                <div class="col-lg-9 col-md-8">
                                    <div class="tab-content" id="myaccountContent">
                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Bảng điều khiển </h5>
                                                <div class="welcome">
                                                    <p>Xin chào, <strong>{{ ucwords(auth()->user()->name) }}</strong></p>
                                                </div>
                                                <p class="mb-0">Từ bảng điều khiển tài khoản của bạn. bạn có thể dễ dàng
                                                    kiểm tra và xem các đơn đặt hàng gần đây của mình, quản lý địa chỉ giao
                                                    hàng và thanh toán cũng như chỉnh sửa mật khẩu và chi tiết tài khoản của
                                                    bạn.</p>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="orders" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Đơn hàng</h5>
                                                <div class="myaccount-table table-responsive text-center">
                                                    <table class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Mã</th>
                                                                <th>Trạng thái</th>
                                                                <th>Tổng tiền</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($orders as $item)
                                                                <tr>
                                                                    <td>DH{{ $item->id }}</td>
                                                                    <td>
                                                                        @if ($item->status == 0)
                                                                            Đã hủy
                                                                        @endif
                                                                        @if ($item->status == 1)
                                                                            Chờ xác nhận
                                                                        @endif
                                                                        @if ($item->status == 2)
                                                                            Đang chuẩn bị hàng
                                                                        @endif
                                                                        @if ($item->status == 3)
                                                                            Đang giao hàng
                                                                        @endif
                                                                        @if ($item->status == 4)
                                                                            Đã giao thành công
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ number_format($item->totalPrice) }}₫</td>
                                                                    <td><a href="{{ route('myaccount.show', $item->id) }}"
                                                                            class="btn btn-sqr clickDetail">Chi tiết</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="order_detail" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Đơn hàng chi tiết</h5>
                                                <div class="row mb-15">
                                                    <div class="col-6">
                                                        <p class="mb-0">Họ tên: <span id="name"></span>
                                                        </p>
                                                        <p class="mb-0">Số điện thoại: <span id="phone"></span>
                                                        </p>
                                                        <p class="mb-0">Địa chỉ: <span id="address"></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">Ngày đặt: <span id="date"></span>
                                                        </p>
                                                        <p class="mb-0">Tình trạng giao hàng: <span id="status"></span>

                                                        </p>
                                                        <p class="mb-0 pr-1 cantrai" style="line-height: 18px!important;">
                                                            Ghi chú: <span id="note"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="myaccount-table table-responsive text-center">
                                                    <table class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Sản phẩm</th>
                                                                <th>Số lượng</th>
                                                                <th>Giá</th>
                                                                <th>Tổng</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tableBody">
                                                        </tbody>
                                                        <footer>
                                                            <tr>
                                                                <td colspan="2">Tổng Thanh Toán</td>
                                                                <td id="totalPrice" colspan="2"></td>
                                                            </tr>
                                                        </footer>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="download" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Downloads</h5>
                                                <div class="myaccount-table table-responsive text-center">
                                                    <table class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Date</th>
                                                                <th>Expire</th>
                                                                <th>Download</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Haven - Free Real Estate PSD Template</td>
                                                                <td>Aug 22, 2018</td>
                                                                <td>Yes</td>
                                                                <td><a href="#" class="btn btn-sqr"><i
                                                                            class="fa fa-cloud-download"></i>
                                                                        Download File</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>HasTech - Profolio Business Template</td>
                                                                <td>Sep 12, 2018</td>
                                                                <td>Never</td>
                                                                <td><a href="#" class="btn btn-sqr"><i
                                                                            class="fa fa-cloud-download"></i>
                                                                        Download File</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->
                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="account-info" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h5>Chi tiết tài khoản</h5>
                                                <div class="account-details-form">
                                                    <form action="{{ route('myaccount.store') }}" method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="name" class="required">Họ &
                                                                        tên</label>
                                                                    <input type="text" required name="name"
                                                                        placeholder="Họ & tên"
                                                                        value="{{ auth()->user()->name }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="last-name" class="required">Email</label>
                                                                    <input type="email"
                                                                        value="{{ auth()->user()->email }}" disabled />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="phone" class="required">Số điện thoại
                                                            </label>
                                                            <input type="tel" name="phone"
                                                                placeholder="Số điện thoại"
                                                                value="{{ auth()->user()->phone }}" />
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="address" class="required">Địa chỉ</label>
                                                            <textarea name="address" placeholder="Địa chỉ">{{ auth()->user()->address }}</textarea>
                                                        </div>
                                                        @if (isset(auth()->user()->password))
                                                        <fieldset>
                                                            <legend>Thay đổi mật khẩu</legend>
                                                            <div class="single-input-item">
                                                                <label for="current-pwd" class="required">Mật Khẩu Hiện
                                                                    Tại</label>
                                                                <input type="password" id="passwordCurrent"
                                                                    name="passwordCurrent"
                                                                    placeholder="Mật Khẩu Hiện Tại" />
                                                                <span id="messageCurrent"></span>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="single-input-item">
                                                                        <label for="new-pwd" class="required">Mật Khẩu
                                                                            Mới</label>
                                                                        <input type="password" id="newPassword"
                                                                            name="newPassword"
                                                                            placeholder="Mật Khẩu Mới" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="single-input-item">
                                                                        <label for="confirm-pwd" class="required">Xác Nhận
                                                                            Mật Khẩu</label>
                                                                        <input type="password" id="confirmPassword"
                                                                            name="confirmPassword"
                                                                            placeholder="Xác Nhận Mật Khẩu" />
                                                                        <span id="message"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        @endif
                                                        <div class="single-input-item">
                                                            <button type="submit" class="btn btn-sqr">lưu thay
                                                                đổi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->
                                    </div>
                                </div>
                                <!-- My Account Tab Content End -->
                            </div>
                        </div>
                        <!-- My Account Page End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- my account wrapper end -->

@endsection
@section('js')
    <script>

        $('#passwordCurrent').keyup(function() {
            var key = $(this).val();
            debunce(() => $.get('{{ route('myaccount.index') }}', {
                'key': key
            }, function(res, status) {
                if (res.status == 200) {
                    $('#messageCurrent').html('Mật khẩu trùng khớp').css('color', 'green');
                } else {
                    $('#messageCurrent').html('Mật khẩu không trùng khớp!').css('color', 'red');
                }
            }));


        });
        $('#newPassword, #confirmPassword').on('keyup', function() {
            var newPass = $('#newPassword').val();
            var confirmPass = $('#confirmPassword').val();

            if (newPass == confirmPass) {
                $('#message').html('Mật khẩu trùng khớp').css('color', 'green');
            } else {
                $('#message').html('Mật khẩu không trùng khớp!').css('color', 'red');
            }

        });
        $('.clickTabList').click(function() {
            var href = $(this).attr('href');
            if (href == '#orders') {
                $('#orders').addClass('active show');
            }
            $('#order_detail').removeClass('active show');
        });
        $(document).on('click', '.clickDetail', function(e) {
            e.preventDefault();
            $('#orders').removeClass('active show');
            $('#order_detail').addClass('active show');

            var url = $(this).attr('href');
            $('#tableBody').html('');
            $.get(url, function(res, status) {
                var status = '';
                var customer = res.customer;
                $('#name').text(customer.name);
                $('#phone').text(customer.phone);
                $('#address').text(customer.address);
                $('#note').text(customer.note);
                $('#date').text(customer.order_date);
                if (customer.status == 0) {
                    status = 'Đã hủy';
                }
                if (customer.status == 1) {
                    status = 'Chờ xác nhận';
                }
                if (customer.status == 2) {
                    status = 'Đang chuẩn bị hàng';
                }
                if (customer.status == 3) {
                    status = 'Đang giao hàng';
                }
                if (customer.status == 4) {
                    status = 'Đã giao thành công';
                }
                $('#status').text(status);
                console.log(res.detail);
                res.detail.forEach(function(val, index) {
                    var total = val.qtyBuy * val.price;
                    $('#tableBody').append('\
                                        <tr>\
                                            <td>' + val.name + '</td>\
                                            <td>' + val.qtyBuy + '</td>\
                                            <td>' + val.price.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '₫</td>\
                                            <td>' + total.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '₫</td>\
                                        </tr>\
                                    ');
                    $('#totalPrice').text(res.totalPrice + '₫');
                });
            }, 'json');




        });
    </script>
@stop

@extends('LayoutUser')
@section('content')
    @include('User.inc.area', ['active' => 'Thanh toán'])

    <!-- checkout-area-start -->
    <div class="checkout-area mb-70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! $message !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php Session::forget('success'); ?>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {!! $message !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php Session::forget('error'); ?>
                    @endif
                    <form action="{{ route('cart.store') }}" method="POST" id="checkOutForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="checkbox-form">
                                    <h3>CHI TIẾT THANH TOÁN</h3>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 ">
                                            <div class="checkout-form-list">
                                                <label>Họ & tên <span class="required">*</span></label>
                                                <input type="text" name="name" id="name" placeholder="Họ & tên"
                                                    required value="{{ auth()->check() ? auth()->user()->name : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="checkout-form-list">
                                                <label>Email <span class="required">*</span></label>
                                                <input type="email" placeholder="" disabled
                                                    value="{{ auth()->check() ? auth()->user()->email : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="checkout-form-list">
                                                <label>Số điện thoại</label>
                                                <input type="tel" name="phone" id="phone" required
                                                    placeholder="Số điện thoại"
                                                    value="{{ auth()->check() ? auth()->user()->phone : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="checkout-form-list">
                                                <label>Địa chỉ <span class="required">*</span></label>
                                                <input type="text" name="address" id="address" placeholder="Địa chỉ"
                                                    required>
                                            </div>
                                        </div>
                                        <div class=" col-lg-12">
                                            <div class="country-select">
                                                <label>Hình thức thanh toán <span class="required">*</span></label>
                                                <select name="payment" id="payment" required>
                                                    <option value="">Chọn</option>
                                                    <option value="0">Trực tiếp</option>
                                                    <option value="1">Paypal</option>
                                                    {{--  <option value="2">Chuyển khoản</option>  --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="order-notes">
                                            <div class="checkout-form-list">
                                                <label>Ghi chú đặt hàng</label>
                                                <textarea name="note" id="note"
                                                    placeholder="Ghi chú về đơn đặt hàng của bạn, ví dụ như ghi chú đặc biệt cho việc giao hàng." rows="10"
                                                    cols="30" id="checkout-mess"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="your-order">
                                    <h3>ĐƠN ĐẶT HÀNG CỦA BẠN</h3>
                                    <div class="your-order-table table-responsive">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="product-name">Sản phẩm</th>
                                                    <th class="product-total">Giá</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $subTotal = 0;
                                                @endphp
                                                @foreach (Cart::content() as $item)
                                                    @php
                                                        $subTotal += $item->price * $item->qty;
                                                    @endphp
                                                    <tr class="cart_item">
                                                        <td class="product-name">
                                                            {{ $item->name }} <strong class="product-quantity"> ×
                                                                {{ $item->qty }}</strong>
                                                        </td>
                                                        <td class="product-total">
                                                            <span class="amount">{{ number_format($item->price) }}₫</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                @php
                                                    $total = $subTotal;
                                                    if (session()->has('coupon')) {
                                                        $total = $subTotal - session()->get('coupon')[0]['price'];
                                                    }
                                                @endphp
                                                <tr class="order-total">
                                                    <th>TỔNG tiền</th>
                                                    <td><strong><span
                                                                class="amount">{{ number_format($total) }}₫</span></strong>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="payment-method">
                                        <div class="payment-accordion">
                                            <div class="collapses-group">
                                                <div class="panel-group" id="accordion" role="tablist"
                                                    aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingOne">
                                                            <h4 class="panel-title">
                                                                <a data-bs-toggle="collapse" data-bs-parent="#accordion"
                                                                    href="#collapseOne" aria-expanded="true"
                                                                    aria-controls="collapseOne">
                                                                    Thanh Toán Trực Tiếp
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseOne" class="panel-collapse collapse in"
                                                            role="tabpanel" aria-labelledby="headingOne">
                                                            <div class="panel-body">
                                                                <p>Thực hiện thanh toán của bạn trực tiếp vào khi nhận hàng.
                                                                    Vui lòng sử dụng ID đơn đặt hàng của
                                                                    bạn làm tham chiếu thanh toán.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingTwo">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button"
                                                                    data-bs-toggle="collapse" data-bs-parent="#accordion"
                                                                    href="#collapseTwo" aria-expanded="false"
                                                                    aria-controls="collapseTwo">
                                                                    Chuyển khoản trực tiếp
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseTwo" class="panel-collapse collapse"
                                                            role="tabpanel" aria-labelledby="headingTwo">
                                                            <div class="panel-body">
                                                                <p>Thực hiện thanh toán của bạn trực tiếp vào tài khoản ngân
                                                                    hàng của chúng tôi. Vui lòng sử dụng ID đơn đặt hàng của
                                                                    bạn làm tham chiếu thanh toán. Đơn đặt hàng của bạn sẽ
                                                                    không được giao cho đến khi số tiền trong tài khoản của
                                                                    chúng tôi được thanh toán.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingThree">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button"
                                                                    data-bs-toggle="collapse" data-bs-parent="#accordion"
                                                                    href="#collapseThree" aria-expanded="false"
                                                                    aria-controls="collapseThree">
                                                                    PayPal <img src="{{ asset('User/img/2.png') }}"
                                                                        alt="payment" />
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseThree" class="panel-collapse collapse"
                                                            role="tabpanel" aria-labelledby="headingThree">
                                                            <div class="panel-body">
                                                                <p>Thanh toán qua PayPal; bạn có thể thanh toán bằng thẻ tín
                                                                    dụng nếu bạn không có tài khoản PayPal.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order-button-payment">
                                            <input {{ auth()->check() && Cart::count() > 0 ? '' : 'disabled' }}
                                                class="button-cod" type="{{ auth()->check() ? 'submit' : 'button' }}"
                                                value="đặt hàng">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- checkout-area-end -->
@endsection
@section('js')

@stop

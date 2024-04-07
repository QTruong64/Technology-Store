@extends('LayoutUser')
@section('content')
    @include('User.inc.area', ['active' => 'Giỏ hàng'])
    <!-- cart-main-area-start -->
    <div class="cart-main-area mb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form action="#">
                        <div class="table-content table-responsive mb-15 border-1">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Ảnh</th>
                                        <th class="product-name">Sản Phẩm</th>
                                        <th class="product-price">Giá</th>
                                        <th class="product-quantity">Số lượng</th>
                                        <th class="product-subtotal">Tổng</th>
                                        <th class="product-remove">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subTotal = 0;
                                    @endphp
                                    @foreach (Cart::content() as $item)
                                        @php
                                            $subTotal += $item->qty * $item->price;
                                        @endphp
                                        <tr>
                                            <td class="product-thumbnail">
                                                <a href="{{ route('home.show', $item->options->slug) }}"><img
                                                        src="{{ asset('uploads/sanpham/' . $item->options->image) }}"
                                                        alt="book" /></a>
                                            </td>
                                            <td class="product-name"><a
                                                    href="{{ route('home.show', $item->options->slug) }}">{{ ucwords($item->name) }}</a>
                                            </td>
                                            <td class="product-price"><span
                                                    class="amount">{{ number_format($item->price) }}₫</span></td>
                                            <td class="product-quantity"><input type="number" class="change_qty"
                                                    data-rowid="{{ $item->rowId }}" min="0"
                                                    max="{{ $item->weight }}" oninput="this.value = Math.abs(this.value)"
                                                    value="{{ $item->qty }}"></td>
                                            <td class="product-subtotal">{{ number_format($item->price * $item->qty) }}₫
                                            </td>
                                            <td class="product-remove"><a href="{{ route('cart.show', $item->rowId) }}"><i
                                                        class="fa fa-times"></i></a></td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="buttons-cart mb-30">
                        <ul>
                            <li><a href="{{ route('home.index') }}">Tiếp tục mua sắm</a></li>
                        </ul>
                    </div>
                    <div class="coupon">
                        <h3>Mã giãm giá</h3>
                        <p>Nhập mã phiếu giảm giá của bạn nếu bạn có.</p>
                        <form action="{{ route('shared.store') }}" method="POST">
                            @csrf
                            <input type="text" name="code" placeholder="Mã giãm giá" required
                                value="{{ old('code') }}">
                            <button type="submit">áp dụng phiếu giảm giá</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="cart_totals">
                        <h2>Tổng Giỏ Hàng</h2>
                        @php
                            $total = $subTotal;
                            if (session()->has('coupon')) {
                                $total = $subTotal - session()->get('coupon')[0]['price'];
                            }
                        @endphp
                        <table>
                            <tbody>
                                <tr class="cart-subtotal">
                                    <th>TỔNG PHụ</th>
                                    <td>
                                        <span class="amount">{{ number_format($subTotal) }}₫</span>
                                    </td>
                                </tr>
                                @if (session()->has('coupon'))
                                    <tr class="cart-subtotal">
                                        <th>Giảm giá</th>
                                        <td>
                                            <span
                                                class="amount">-{{ number_format(session()->get('coupon')[0]['price']) }}₫</span>
                                        </td>
                                    </tr>
                                @endif
                                <tr class="order-total">
                                    <th>tổng cộng</th>
                                    <td>
                                        <strong>
                                            <span class="amount">{{ number_format($total) }}₫</span>
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="wc-proceed-to-checkout">
                            <a href="{{ route('cart.create') }}">Tiến hành thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart-main-area-end -->
@endsection
@section('js')
    <script>
        $(document).on('change', '.change_qty', function() {
            var rowId = $(this).data('rowid');
            var qty = $(this).val();

            $.ajax({
                type: 'get',
                url: 'sua-gio-hang/' + rowId,
                data: {
                    'qty': qty
                },
                success: function(res) {
                    location.reload();
                }
            })
        });
    </script>
@stop

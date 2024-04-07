<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>[PhongVan] - In đơn hàng</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair:ital,opsz,wght@0,5..1200,400;0,5..1200,500;0,5..1200,700;1,5..1200,400;1,5..1200,500;1,5..1200,700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Playfair',serif;
            font-size: 14px;
        }

        .text {
            vertical-align: middle !important;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .table-active {
            background-color: #E5E5E5;
        }
    </style>
</head>

<body>
    <div style="width:100%; float:left; line-height: 200%; font-size:12px">
        <p style="float: right; text-align: right; padding-right:20px; line-height: 140%">
            Ngày đặt hàng: {{ $order->created_at->format('d-m-Y') }}<br><br>
            <span style="text-align: center">
                <img src="data:image/png;base64, {{ base64_encode($qrcode) }} ">
            </span>
        </p>
        @php
            $subtotal = 0;
            $email = 'support@gmail.com';
            $phone = '077.xxx.xxxx';
            $phone_name = '(Mr. P)';
        @endphp
        <div style="float: left; margin: 0 0 1.5em 0; ">
            <strong style="font-size: 18px;text-transform: uppercase;">Phong Vân</strong>
            <br />
            <strong>Địa chỉ:</strong> 123. Abc.
            <br />
            <strong>Điện thoại:</strong> {{ $phone . ' ' . $phone_name }}
            <br />
            <strong>Email:</strong> {{ $email }}
        </div>
        <div style="clear:both"></div>
        <div class="col-12" style="text-align: center">
            <h2 style="text-transform: uppercase;font-weight: bold;">phiếu đơn hàng</h2>
        </div>
        <table style="width: 100%">
            <tr>
                <td valign="top" style="width: 65%">
                    <h3 style="margin: 1.5em 0 1em 0; font-style: bold;text-transform: uppercase;font-size: 14px;">Chi
                        tiết đơn hàng</h3>
                    <hr style="border: none; border-top: 2px solid #CCE2F1;" />
                    <table class="table table-borderless" width="100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text text-center" style="width:10%;">#</th>
                                <th scope="col" class="text text-center" style="width:50%;">Sản phẩm</th>
                                <th scope="col" class="text text-center" style="width:15%;">Số lượng</th>
                                <th scope="col" class="text text-center" style="width:25%;">Giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->OrderToDetail as $key => $row)
                                @php
                                    $subtotal += $row->qtyBuy * $row->price;
                                @endphp
                                <tr valign="top" style="border-top: 1px solid #d9d9d9;">
                                    <td class="text text-center" style="padding: 5px 0px">{{ $key + 1 }}</td>
                                    <td class="text text-left">
                                        {{ $row->OrderDetailToProduct->name }}
                                    </td>
                                    <td class="text text-center" style="padding: 5px 0px">{{ $row->qtyBuy }}</td>
                                    <td class="text text-center" style="padding: 5px 0px">
                                        {{ number_format($row->price) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr style="border-top: 1px solid #dbdbdb;" />
                    <div class="row">
                        <div class="col-xs-6">&nbsp;</div>
                        <div class="col-xs-6" style="float: right;">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr class="active">
                                        <td>Tổng giá sản phẩm:</td>
                                        <td>{{ number_format($subtotal) }}<sup>₫</sup></td>
                                    </tr>
                                    @if (isset($order->OrderToDiscount))
                                    <tr class="active">
                                        <td>Giảm giá:</td>
                                        <td>-{{ number_format($order->OrderToDiscount->price) }}<sup>₫</sup></td>
                                    </tr>
                                    @else
                                    <tr class="active">
                                        <td>Phí vận chuyển:</td>
                                        <td>0<sup>₫</sup></td>
                                    </tr>
                                    @endif
                                    <tr class="active">
                                        <td><strong>Tổng tiền:</strong></td>
                                        <td><strong>{{ number_format($order->totalPrice) }}<sup>₫</sup></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
                <td valign="top" style="padding: 0px 20px">
                    <h3 style="font-size: 14px;margin: 1.5em 0 1em 0; font-style: bold;text-transform: uppercase;">Thông
                        tin đơn hàng</h3>
                    <hr style="border: none; border-top: 2px solid #CCE2F1;" />
                    <div style="margin: 0 0 1em 0; padding: 1em; border: 1px solid #d9d9d9;">
                        <strong>Mã đơn hàng:</strong><br>DH{{ $order->id }}<br>
                        <strong>Ngày đặt hàng:</strong><br>{{ $order->created_at->format('d-m-Y') }}<br>
                        <strong>Phương thức thanh toán</strong><br>{{ $order->payment == 0 ? 'COD' : 'ATM' }}
                        <br>
                        <strong>Phương thức vận chuyển</strong><br>Shipper
                    </div>
                    <h3 style="font-size: 14px;margin: 1.5em 0 1em 0;font-style: bold;text-transform: uppercase;">Thông
                        tin khách hàng</h3>
                    <hr style="border: none; border-top: 2px solid #CCE2F1;" />
                    <div style="margin: 0 0 1em 0; padding: 1em; border: 1px solid #d9d9d9;  white-space: normal;">
                        <strong>{{ $order->OrderToCus->name }}</strong><br />
                        <strong>Địa chỉ:</strong> {{ $order->OrderToCus->address }}<br />
                        <strong>Sdt:</strong> {{ $order->OrderToCus->phone }}<br />
                        <strong>Email:</strong> {{ $order->OrderToCus->CusToUser->email }}<br />
                        @if (isset($order->OrderToCus->note))
                            <strong>Ghi chú:</strong> <i>({{ $order->OrderToCus->note }})</i><br />
                        @endif
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    Nếu bạn có thắc mắc, vui lòng liên hệ chúng tôi qua email <u>{{ $email }}</u> hoặc <a
                    style="color: #000" href="tel:+{{ $phone }}">{{ $phone . ' ' . $phone_name }}</a>
                </td>
            </tr>
        </table>
    </div>
</body>

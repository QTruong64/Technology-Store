@extends('LayoutAdmin')
@section('content')
    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- main title -->
                <div class="col-12">
                    <div class="main__title">
                        <h2>{{ !isset($coupon) ? 'Thêm Mới' : 'Cập Nhật' }}</h2>
                    </div>
                </div>
                <!-- end main title -->

                <!-- form -->
                @php
                    $ngayHienTai = \Carbon\Carbon::now()->format('Y-m-d');
                    $route = isset($coupon) ? route('giamgia.update', $coupon->id) : route('giamgia.store');
                    $start = isset($coupon) ? date('Y-m-d', strtotime($coupon->start)) : $ngayHienTai;
                    $end = isset($coupon) ? date('Y-m-d', strtotime($coupon->end)) : $ngayHienTai;
                    $price = isset($coupon) ? number_format($coupon->price) : '';
                    $code = isset($coupon) ? $coupon->code : '';
                    $status = isset($coupon) ? $coupon->status : '';
                @endphp
                <div class="col-12">
                    <form action="{{ $route }}" method="POST" class="form">
                        @isset($coupon)
                            @method('PUT')
                        @endisset
                        @csrf

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <input pattern="[A-Za-z0-9]{3,50}"
                                        title="(Gồm các ký tự là chữ thường, in hoa hoặc số, không dấu và không khoảng cách, tối đa 50 ký tự)"
                                        type="text" name="code" class="form__input" placeholder="Mã Giảm" required
                                        value="{{ $code }}">
                                </div>
                                <div class="col-6">
                                    <input type="text" name="price" onkeyup="dinhDangGia(this)" pattern="[0-9,]*"
                                        class="form__input" placeholder="Giá Tiền" required value="{{ $price }}">
                                </div>
                                <div class="col-6">
                                    <input type="date" name="start" id="idNgayBatDau" min="{{ $start }}"
                                        value="{{ $start }}" onblur="chinhNgay(this, 'idNgayKetThuc')"
                                        class="form__input" title="Ngày bắt đầu" required>
                                </div>
                                <div class="col-6">
                                    <input type="date" name="end" id="idNgayKetThuc" min="{{ $end }}"
                                        value="{{ $end }}" class="form__input" title="Ngày kết thúc" required>
                                </div>
                                <div class="col-12">
                                    <select class="js-example-basic-single" name="status" id="status">
                                        <option value=""></option>
                                        <option {{ $status == 0 ? 'selected' : '' }} value="0">Hiện</option>
                                        <option {{ $status == 1 ? 'selected' : '' }} value="1">Ẩn</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">

                                <div class="col-12">
                                    <button type="submit" class="form__btn">Gửi</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- end form -->
            </div>
        </div>
    </main>
@endsection
@section('js')
    <script>
        function chinhNgay(idNgayBatDau, idNgayKetThuc) {
            var inputNgayKetThuc = document.getElementById(idNgayKetThuc);
            inputNgayKetThuc.value = idNgayBatDau.value;
            inputNgayKetThuc.min = idNgayBatDau.value;
        };
    </script>
@stop

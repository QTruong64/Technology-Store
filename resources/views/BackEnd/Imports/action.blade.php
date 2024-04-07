@extends('LayoutAdmin')
@section('content')
    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- main title -->
                <div class="col-12">
                    <div class="main__title">
                        <h2>{{ !isset($import) ? 'Thêm Mới' : 'Cập Nhật' }}</h2>
                    </div>
                </div>
                <!-- end main title -->

                <!-- form -->
                @php
                    $route = isset($import) ? route('phieunhap.update', $import->id) : route('phieunhap.store');
                    $daThanhToanUp = isset($import) ?  ($import->total_price-$import->debt) : 0;
                    $cusName = isset($import) ?  'ND'.$import->user_id.' | '.$import->ImportToUser->name .' | '.$import->ImportToUser->phone : '';
                @endphp
                <div class="col-12">
                    <form action="{{ $route }}" method="POST" class="form">
                        @isset($import)
                            @method('PUT')
                        @endisset
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <h4 class="profile__title">Danh sách sản phẩm</h4>
                            </div>
                            <!-- details form -->
                            <div class="col-8">
                                <table class="table" style="background: #28282d;color:white;">
                                    <thead>
                                        <tr>
                                            <th style="padding-left: 15px; width: 5%;">
                                                <button type="button" onclick="create_tr('table_body')"
                                                    class="main__table-btn main__table-btn--edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                        <path
                                                            d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" />
                                                    </svg>
                                                </button>
                                            </th>

                                            <th style="width: 30%;" class="table-th">TÊN SẢN PHẨM</th>
                                            <th style="width: 15%;" class="table-th">SỐ LƯỢNG</th>
                                            <th style="width: 25%;" class="table-th">GIÁ TIỀN</th>
                                            <th style="width: 25%;" class="table-th">THÀNH TIỀN</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body">
                                        @if (isset($import))
                                            @foreach ($import->ImportToDetail as $i => $row)
                                            @php
                                                $i++;
                                                $pro = $row->ImportDetailToProduct;
                                                $nameUp = 'SP'. $pro->id .' | '. $pro->name;
                                                $qtyUp = $row->qty;
                                                $priceUp = number_format($row->price);
                                            @endphp
                                            <tr class="idtr" data-id="{{ $i }}">
                                                <td style="vertical-align: middle;">
                                                    <button onclick="remove_tr(this)" type="button"
                                                        class="main__table-btn main__table-btn--delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <path
                                                                d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z" />
                                                        </svg>
                                                    </button>
                                                </td>
                                                <td>
                                                    <input id="inputSanPham{{ $i }}" onblur="doDuLieuSanPham('{{ $i }}')" list="inSanPham{{ $i }}" name="name[]" required
                                                        class="profile__input" autocomplete="off" value="{{ $nameUp ?? '' }}">
                                                    <datalist id="inSanPham{{ $i }}">
                                                        @foreach ($products as $key => $value)
                                                            <option value="SP{{ $value->id }} | {{ $value->name }}">Tồn
                                                                kho: {{ $value->qty }} | Khách đặt:
                                                                {{ $value->ProToOrderDetail->sum('qtyBuy') }}
                                                            </option>
                                                        @endforeach
                                                    </datalist>

                                                </td>
                                                <td>
                                                    <input name="qty[]" id="qty{{ $i }}" min="1" required
                                                        class="profile__input" onkeyup="tinhTongTien()" step="1" value="{{ $qtyUp ?? '' }}">
                                                </td>
                                                <td>
                                                    <input name="price[]" id="price{{ $i }}" required class="profile__input"
                                                         value="{{ $priceUp ?? '' }}" onkeyup="tinhTongTien()">
                                                </td>
                                                <td>
                                                    <input name="total" id="total{{ $i }}" required class="profile__input"
                                                        readonly>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                            </div>
                            <!-- end details form -->

                            <!-- password form -->
                            <div class="col-4" style="border-left: 1px solid rgba(255, 255, 255, 0.05);">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-12">
                                        <div class="profile__group">
                                            <label class="profile__label" for="oldpass">Thông tin khách hàng (*)</label>
                                            <input list="khachHang" name="thongTinNguoiDung" required
                                                class="profile__input" value="{{ $cusName }}">
                                            <input type="hidden" name="hiddenIdCus" value="{{ $import->OrderToCus->id ?? '' }}">
                                            <datalist id="khachHang">
                                                @foreach ($users as $nd)
                                                    <option
                                                        value="ND{{ $nd->id }} | {{ $nd->name }} | {{ $nd->phone }}">
                                                    </option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="profile__group">
                                        <label class="profile__label" for="smallSelect">Ghi chú</label>
                                        <textarea name="note" rows="5" class="profile__input">{{ $import->note ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="row m-2 pt-0">
                                    <div class="form-group col-6 ml-auto p-0" style="padding-right:12px!important">
                                        <h5 class="profile__label" style="padding: 10px 0px">Tổng tiền:</h5>
                                    </div>
                                    <div class="form-group col-6 p-0">
                                        <input style="padding-left:15px" class="profile__input" type="text"
                                            id="tongTienHien" pattern="[0-9,]*" value="0" min="0"
                                            readonly name="tongTienHien">
                                            <input type="number" min="0" hidden="" id="tongTien" name="tongTien"
                                        required="">
                                    </div>
                                </div>
                                <div class="row m-2 pt-0">
                                    <div class="form-group col-6 ml-auto p-0" style="padding-right:12px!important">
                                        <h5 class="profile__label" style="padding: 10px 0px">Đã thanh toán:</h5>
                                    </div>
                                    <div class="form-group col-6 p-0">
                                        <input style="padding-left:15px" class="profile__input" type="text"
                                            id="daThanhToan" name="daThanhToan" value="{{ $daThanhToanUp }}"
                                            min="{{ $daThanhToanUp }}" required="" onkeyup="tinhTongTien()">
                                    </div>
                                </div>
                                <div class="row m-2 pt-0">
                                    <div class="form-group col-6 ml-auto p-0" style="padding-right:12px!important">
                                        <h5 class="profile__label" style="padding: 10px 0px">Tính vào công nợ:</h5>
                                    </div>
                                    <div class="form-group col-6 p-0">
                                        <input style="padding-left:15px" class="profile__input" type="text"
                                            id="congNo" name="congNo" pattern="[0-9,]*" value="0"
                                            min="0" required="" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4" style="border-top: 1px solid rgba(255, 255, 255, 0.05);">
                                <button style="float: right;margin-right: 0.5%; margin-top: 3%;" type="submit"
                                    class="profile__btn">Gửi</button>
                            </div>
                            <!-- end password form -->

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
        $(document).ready(function(){
            var tableBody = document.getElementById("table_body");
            if(tableBody.rows.length > 0){
                tinhTongTien();
                hienThiThongTinNguoiNhanKhac();
            }
        });
        var stt = {{ isset($import) ? count($import->ImportToDetail)+1 : 1 }};
        function create_tr() {
            $('#table_body').append(`
                <tr class="idtr" data-id="`+stt+`">
                    <td style="vertical-align: middle;">
                        <button onclick="remove_tr(this)" type="button"
                            class="main__table-btn main__table-btn--delete">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path
                                    d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z" />
                            </svg>
                        </button>
                    </td>
                    <td>
                        <input id="inputSanPham`+stt+`" onblur="doDuLieuSanPham(`+stt+`)" list="inSanPham`+stt+`" name="name[]" required
                            class="profile__input" autocomplete="off">
                        <datalist id="inSanPham`+stt+`">
                            @foreach ($products as $key => $value)
                                <option value="SP{{ $value->id }} | {{ $value->name }}">Tồn
                                    kho: {{ $value->qty }} | Khách đặt:
                                    {{ $value->ProToOrderDetail->sum('qtyBuy') }}
                                </option>
                            @endforeach
                        </datalist>

                    </td>
                    <td>
                        <input name="qty[]" id="qty`+stt+`" min="1" required
                            class="profile__input" onkeyup="tinhTongTien()" step="1">
                    </td>
                    <td>
                        <input name="price[]" id="price`+stt+`" required class="profile__input" onkeyup="tinhTongTien()">
                    </td>
                    <td>
                        <input id="total`+stt+`" required class="profile__input"
                            readonly>
                    </td>
                </tr>
            `);
            stt++;
        }
        function remove_tr(This) {
            This.closest('tr').remove();
            tinhTongTien();
        }
        function doDuLieuSanPham(soThuTu) {
            soThuTuCanDoDuLieu = soThuTu;
            danhSachSanPham = {!! $products !!};
            var inputSanPham = document.getElementById("inputSanPham"+soThuTu);
            maSanPham = inputSanPham.value.split(" | ")[0].split("SP")[1];
            danhSachSanPham.forEach(timThongTinSanPham);
        }
        function timThongTinSanPham(thongTinSanPham) {
            if (thongTinSanPham['id'] == maSanPham){
                document.getElementById('qty'+soThuTuCanDoDuLieu).value = 1;
                document.getElementById('price'+soThuTuCanDoDuLieu).value = 0;
                tinhTongTien();
            }
        }
        function tinhTongTien() {
            var soTienGiam = 0;
            var inputTongTien = document.getElementById('tongTienHien');
            var inputCongNo = document.getElementById('congNo');
            var inputDaThanhToan = document.getElementById('daThanhToan');

            var giaTriDaThanhToan = inputDaThanhToan.value.split(","); // format tien ,,, lai thanh so
            var temp = "";
            for (var i = 0; i < giaTriDaThanhToan.length; i++) {
                temp += giaTriDaThanhToan[i];
            }
            inputDaThanhToan.value = temp; // format tien ,,, lai thanh so

            inputTongTien.value = 0;
            inputCongNo.value = 0;

            var tableDonhang = document.getElementById("table_body");
            var demDong = tableDonhang.rows.length;
            $(".idtr").each(function(){
                var item = $(this).data('id');
                var inputSoLuong = document.getElementById('qty'+item);
                var inputDonGia = document.getElementById('price'+item);


                var giaTriDonGia = inputDonGia.value.split(","); // format tien ,,, lai thanh so
                temp = "";
                for (var j = 0; j < giaTriDonGia.length; j++) {
                    temp += giaTriDonGia[j];
                }
                inputDonGia.value = temp; // format tien ,,, lai thanh so

                var inputThanhTien = document.getElementById('total'+item);
                inputSoLuong.value = parseFloat(inputSoLuong.value);
                inputDonGia.value = parseFloat(inputDonGia.value);
                inputThanhTien.value = parseFloat(inputSoLuong.value * inputDonGia.value);
                inputTongTien.value = parseFloat(inputTongTien.value) + parseFloat(inputSoLuong.value *
                    inputDonGia.value);
                if (isNaN(inputDonGia.value)) inputDonGia.value = 0;
                if (isNaN(inputSoLuong.value)) inputSoLuong.value = 0;
                if (isNaN(inputThanhTien.value)) inputThanhTien.value = 0;
                formatGia(inputDonGia);
                formatGia(inputThanhTien);
            });

            if(parseFloat(inputDaThanhToan.value) > parseFloat(inputTongTien.value)){
                inputDaThanhToan.value = inputDaThanhToan.min;
            }

            inputCongNo.value = parseFloat(soTienGiam) + parseFloat(inputDaThanhToan.value) - parseFloat(inputTongTien.value);
            tongTien.value = parseFloat(inputTongTien.value);
            if (isNaN(inputTongTien.value)) {
                inputTongTien.value = 0;
                tongTien.value = 0;
            }
            if (isNaN(inputDaThanhToan.value)) inputDaThanhToan.value = 0;
            if (isNaN(inputCongNo.value)) inputCongNo.value = 0;

            inputDaThanhToan.setAttribute("min", inputDaThanhToan.min);
            inputDaThanhToan.setAttribute("max", inputTongTien.value);

            formatGia(inputTongTien);
            formatGia(inputDaThanhToan);
            formatGia(inputCongNo);
        };
        function hienThiThongTinNguoiNhanKhac() {
            var thongTinNguoiNhanKhac = document.getElementById('thongTinNguoiNhanKhac');
            if (thongTinNguoiNhanKhac.checked) {
                console.log(thongTinNguoiNhanKhac.checked);
                $('#thongTinNguoiNhan').css('display', 'block');
                $('#thongTinNguoiNhan').css('background', 'rgb(89 89 89 / 17%)');
            } else {
                $('#thongTinNguoiNhan').css('display', 'none');
            }
        }
    </script>
@stop

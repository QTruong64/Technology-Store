@extends('LayoutAdmin')
@section('content')
    <!-- main content -->
    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- main title -->
                <div class="col-12">
                    <div class="main__title">
                        <h2>Mã Giảm Giá</h2>

                        <span class="main__title-stat">Tổng {{ $Count }}</span>

                        <div class="main__title-wrap">
                            <!-- filter sort -->
                            <div class="filter">
                                @can('add-discount')
                                <a href="{{ route('giamgia.create') }}" class="main__table-btn main__table-btn--edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path
                                            d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" />
                                    </svg>
                                </a>
                                @endcan
                            </div>
                            <!-- end filter sort -->
                        </div>
                    </div>
                </div>
                <!-- end main title -->

                <!-- users -->
                <div class="col-12">
                    <div class="col-12">
                        <div class="main__table-wrap">
                            <table class="main__table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>MÃ</th>
                                        <th>SỐ TIỀN</th>
                                        <th>HẠN SỬ DỤNG</th>
                                        <th>TRẠNG THÁI</th>
                                        <th>HÀNH ĐỘNG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupon as $key => $value)
                                        <tr>
                                            <td>
                                                <div class="main__table-text">MG{{ $key+1 }}</div>
                                            </td>
                                            <td>
                                                <div class="main__table-text">{{ $value->code }}</div>
                                            </td>
                                            <td>
                                                <div class="main__table-text">{{ number_format($value->price) }}</div>
                                            </td>
                                            <td>
                                                <div class="main__table-text">
                                                    @php
                                                        $now = strtotime(date('M j, Y'));
                                                        $end = strtotime(date("M j, Y",strtotime($value->end)));
                                                    @endphp
                                                    @if ($end >= $now)
                                                        <span class="text-box box-success">Còn Hạn</span>
                                                    @else
                                                        <span class="text-box box-danger">Hết Hạn</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="main__table-text">
                                                    <a href="#">
                                                        <i class="fas {{ $value->status == 0 ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="main__table-btns">
                                                    @can('edit-discount')
                                                    <a href="{{ route('giamgia.edit',$value->id) }}" class="main__table-btn main__table-btn--edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <path
                                                                d="M5,18H9.24a1,1,0,0,0,.71-.29l6.92-6.93h0L19.71,8a1,1,0,0,0,0-1.42L15.47,2.29a1,1,0,0,0-1.42,0L11.23,5.12h0L4.29,12.05a1,1,0,0,0-.29.71V17A1,1,0,0,0,5,18ZM14.76,4.41l2.83,2.83L16.17,8.66,13.34,5.83ZM6,13.17l5.93-5.93,2.83,2.83L8.83,16H6ZM21,20H3a1,1,0,0,0,0,2H21a1,1,0,0,0,0-2Z" />
                                                        </svg>
                                                    </a>
                                                    @endcan
                                                    @can('delete-discount')
                                                    <a href="#modal-delete" onclick="ModalDel('{{ $value->id }}','{{ $value->code }}','{{ route('giamgia.destroy',$value->id) }}')" class="main__table-btn main__table-btn--delete open-modal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <path
                                                                d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z" />
                                                        </svg>
                                                    </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end users -->

                    <!-- paginator -->
                    <div class="col-12">
                        {!! $coupon->render('BackEnd.inc.paginator') !!}
                    </div>
                </div>
                <!-- end paginator -->
            </div>
        </div>
    </main>
    <!-- end main content -->

    <!-- modal delete -->
    <div id="modal-delete" class="zoom-anim-dialog mfp-hide modal">
        <form action="" id="clickDel" method="POST">
            @method('DELETE')
            @csrf
            <h6 class="modal__title">Xóa Thể Loại</h6>

            <p class="modal__text">Bạn có chắc muốn xóa <strong>"<i id="item"></i>"</strong> không?</p>

            <div class="modal__btns">

                <button type="submit" class="modal__btn modal__btn--apply">Xóa</button>

                <button class="modal__btn modal__btn--dismiss" type="button">Hủy</button>
            </div>
        </form>
    </div>
    <!-- end modal delete -->
@endsection
@section('js')
    <script>
        function ModalDel(id, name,url) {
            $('#item').text(name);
            $('#clickDel').attr('action', url);
        }
    </script>
@stop

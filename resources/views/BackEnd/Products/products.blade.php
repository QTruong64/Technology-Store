@extends('LayoutAdmin')
@section('content')
    <!-- main content -->
    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- main title -->
                <div class="col-12">
                    <div class="main__title">
                        <h2>Thể Loại</h2>

                        <span class="main__title-stat">Tổng {{ $productCount }}</span>
                        @can('add-product')
                        <div class="main__title-wrap">
                            <div class="filter" id="filter__sort">
                                <span class="filter__item-label">Chọn:</span>

                                <div class="filter__item-btn dropdown-toggle" role="navigation" id="filter-sort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <input type="button" value="Thêm Mới">
                                    <span></span>
                                </div>

                                <ul class="filter__item-menu dropdown-menu scrollbar-dropdown" aria-labelledby="filter-sort">
                                    <li><a class="sidebar__nav-link " href="{{ route('sanpham.phone.create') }}">Điện Thoại</a></li>
                                    <li><a class="sidebar__nav-link " href="{{ route('sanpham.accessory.create') }}">Phụ Kiện</a></li>
                                </ul>
                            </div>
                        </div>
                        @endcan
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
                                        <th>ID</th>
                                        <th>HÌNH</th>
                                        <th>TÊN</th>
                                        <th>THỂ LOẠI</th>
                                        <th>GIÁ BÁN</th>
                                        <th>NGÀY TẠO</th>
                                        <th>HÀNH ĐỘNG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $value)
                                        <tr>
                                            <td>
                                                <div class="main__table-text">SP{{ $value->id }}</div>
                                            </td>
                                            <td>
                                                <div class="main__table-text">
                                                    <img src="{{ asset('uploads/sanpham/' . $value->ProToGall->imageDefault) }}"
                                                        width="100" height="100">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="main__table-text">{{ $value->name }}</div>
                                            </td>
                                            <td>
                                                <div class="main__table-text">{{ $value->ProToCate->name }}</div>
                                            </td>
                                            <td>
                                                <div
                                                    class="main__table-text {{ $value->priceOld > 0 ? 'main__table-text--green' : '' }}">
                                                    {{ number_format($value->price) }}</div>
                                            </td>
                                            <td>
                                                <div class="main__table-text">
                                                    {{ \Carbon\Carbon::parse($value->created_at)->toFormattedDateString() }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="main__table-btns">
                                                    @can('edit-product')
                                                    <a href="{{ route('sanpham.edit', $value->id) }}"
                                                        class="main__table-btn main__table-btn--edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <path
                                                                d="M5,18H9.24a1,1,0,0,0,.71-.29l6.92-6.93h0L19.71,8a1,1,0,0,0,0-1.42L15.47,2.29a1,1,0,0,0-1.42,0L11.23,5.12h0L4.29,12.05a1,1,0,0,0-.29.71V17A1,1,0,0,0,5,18ZM14.76,4.41l2.83,2.83L16.17,8.66,13.34,5.83ZM6,13.17l5.93-5.93,2.83,2.83L8.83,16H6ZM21,20H3a1,1,0,0,0,0,2H21a1,1,0,0,0,0-2Z" />
                                                        </svg>
                                                    </a>
                                                    @endcan
                                                    @can('delete-product')
                                                    <a href="#modal-delete"
                                                        onclick="ModalDel('{{ $value->id }}','{{ $value->name }}','{{ route('sanpham.destroy',$value->id) }}')"
                                                        class="main__table-btn main__table-btn--delete open-modal">
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
                        {!! $products->render('BackEnd.inc.paginator') !!}
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

@if (isset($category))
    <div class="col-12">
        <div class="main__table-wrap">
            <table class="main__table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TÊN THỂ LOẠI</th>
                        <th>TÊN THỂ LOẠI CHA</th>
                        <th>NGÀY TẠO</th>
                        <th>HÀNH ĐỘNG</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category as $cate)
                        <tr>
                            <td>
                                <div class="main__table-text">{{ $cate->id }}</div>
                            </td>
                            <td>
                                <div class="main__table-text">{{ $cate->name }}</div>
                            </td>
                            <td>
                                <a style="cursor: pointer;" class="main__table-text main__table-text--green"
                                    title="{{ isset($cate->parent_id) ? $cate->ParentCate->name : '' }}">{{ $cate->parent_id }}</a>
                            </td>
                            <td>
                                <div class="main__table-text">
                                    {{ \Carbon\Carbon::parse($cate->created_at)->toFormattedDateString() }}
                                </div>
                            </td>
                            <td>
                                <div class="main__table-btns">
                                    <a href="{{ route('theloai.show',$cate->id) }}" class="main__table-btn main__table-btn--edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path
                                                d="M5,18H9.24a1,1,0,0,0,.71-.29l6.92-6.93h0L19.71,8a1,1,0,0,0,0-1.42L15.47,2.29a1,1,0,0,0-1.42,0L11.23,5.12h0L4.29,12.05a1,1,0,0,0-.29.71V17A1,1,0,0,0,5,18ZM14.76,4.41l2.83,2.83L16.17,8.66,13.34,5.83ZM6,13.17l5.93-5.93,2.83,2.83L8.83,16H6ZM21,20H3a1,1,0,0,0,0,2H21a1,1,0,0,0,0-2Z" />
                                        </svg>
                                    </a>
                                    <a href="#modal-delete" onclick="ModalDel('{{ $cate->id }}','{{ $cate->name }}')" class="main__table-btn main__table-btn--delete open-modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path
                                                d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z" />
                                        </svg>
                                    </a>
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
        {!! $category->render('Admin.inc.paginator') !!}
    </div>
@endif
@if (isset($products))
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
                                <div class="main__table-text">{{ $value->id }}</div>
                            </td>
                            <td>
                                <div class="main__table-text">
                                    <img src="{{ asset('uploads/sanpham/'.$value->ProToGall->imageDefault) }}" width="100" height="100">
                                </div>
                            </td>
                            <td>
                                <div class="main__table-text">{{ $value->name }}</div>
                            </td>
                            <td>
                                <div class="main__table-text"
                                    >{{ $value->ProToCate->name }}</div>
                            </td>
                            <td>
                                <div class="main__table-text {{ $value->priceOld > 0 ? 'main__table-text--green' : '' }}">{{ number_format($value->price) }}</div>
                            </td>
                            <td>
                                <div class="main__table-text">
                                    {{ \Carbon\Carbon::parse($value->created_at)->toFormattedDateString() }}
                                </div>
                            </td>
                            <td>
                                <div class="main__table-btns">
                                    <a href="{{ route('sanpham.show',$value->id) }}" class="main__table-btn main__table-btn--edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path
                                                d="M5,18H9.24a1,1,0,0,0,.71-.29l6.92-6.93h0L19.71,8a1,1,0,0,0,0-1.42L15.47,2.29a1,1,0,0,0-1.42,0L11.23,5.12h0L4.29,12.05a1,1,0,0,0-.29.71V17A1,1,0,0,0,5,18ZM14.76,4.41l2.83,2.83L16.17,8.66,13.34,5.83ZM6,13.17l5.93-5.93,2.83,2.83L8.83,16H6ZM21,20H3a1,1,0,0,0,0,2H21a1,1,0,0,0,0-2Z" />
                                        </svg>
                                    </a>
                                    <a href="#modal-delete" onclick="ModalDel('{{ $value->id }}','{{ $value->name }}')" class="main__table-btn main__table-btn--delete open-modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path
                                                d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z" />
                                        </svg>
                                    </a>
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
        {!! $products->render('Admin.inc.paginator') !!}
    </div>
@endif
@section('page')
    <script>
        function fetchData(page) {
            $.ajax({
                url: "{{ url()->current() }}?page=" + page,
                success: function(data) {
                    $('#loadData').html(data);
                }
            });
        }
        $(document).ready(function() {

            $(document).on('click', '.paginator a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetchData(page);
            });

        });
    </script>
@stop

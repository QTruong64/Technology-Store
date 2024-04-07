@extends('LayoutUser')
@section('content')
    @include('User.inc.area', ['active' => 'So sánh'])
    <!-- compare main wrapper start -->
    <div class="compare-page-wrapper mb-70">
        <div class="container">
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Compare Page Content Start -->
                        <div class="compare-page-content-wrap">
                            <div class="compare-table table-responsive">
                                <table class="table table-bordered mb-0">
                                    @php
                                        $compare = session()->has('compare') ? session()->get('compare') : [];
                                    @endphp
                                    <tbody style="border-right: 1px solid #ccc;">
                                        <tr>
                                            <td class="first-column">Sản phẩm</td>
                                            @foreach ($compare as $item)
                                                <td class="product-image-title">
                                                    <a href="{{ route('home.show', $item['slug']) }}" class="image">
                                                        <img class="img-fluid" width="200" height="385"
                                                            src="{{ asset('uploads/sanpham/' . $item['image']) }}"
                                                            alt="Compare Product">
                                                    </a>
                                                    <a href="{{ route('home.show', $item['slug']) }}"
                                                        class="title">{{ $item['name'] }}</a>
                                                </td>
                                            @endforeach
                                            @if (empty($compare) || count($compare) == 1)
                                                <td class="product-image-title" style="vertical-align: middle;" rowspan="{{ count($compare) == 1 ? '' : 7 }}">
                                                    <style>
                                                        .plus {
                                                            border: 1px dashed #00abe0;
                                                            border-radius: 3px;
                                                            position: relative;
                                                            width: 60px;
                                                            height: 60px;
                                                            margin: auto;
                                                            display: flex;
                                                            justify-content: center;
                                                            align-items: center;
                                                        }

                                                        .plus i {
                                                            width: 20px;
                                                            height: 1px;
                                                            background: #00abe0;
                                                            position: absolute;
                                                            left: 0;
                                                            right: 0;
                                                            margin: auto;
                                                        }

                                                        .plus i:nth-child(2) {
                                                            transform: rotate(90deg);
                                                        }

                                                        .pop-up {
                                                            cursor: pointer;
                                                        }

                                                        .pop-up span {
                                                            display: block;
                                                            overflow: hidden;
                                                            font-size: 14px;
                                                            margin-top: 15px;
                                                            line-height: 137%;
                                                            color: #666;
                                                        }
                                                    </style>
                                                    <div class="pop-up" onclick="OpenPopup()">
                                                        <div class="plus">
                                                            <i></i>
                                                            <i></i>
                                                        </div>
                                                        <span>Thêm sản phẩm</span>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="first-column">Mô tả</td>
                                            @foreach ($compare as $item)
                                                <td class="pro-desc">
                                                    <div class="parameter">
                                                        <ul class="parameter__list active">
                                                            <li data-index="0" data-prop="0">
                                                                <p class="lileft">Màn hình:</p>
                                                                <div class="liright">
                                                                    <span class="comma">{{ $item['desc']->screen }}</span>
                                                                </div>
                                                            </li>
                                                            <li data-index="0" data-prop="0">
                                                                <p class="lileft">Hệ điều hành:</p>
                                                                <div class="liright">
                                                                    <span class="">{{ $item['desc']->system }}</span>
                                                                </div>
                                                            </li>
                                                            <li data-index="0" data-prop="0">
                                                                <p class="lileft">Camera sau:</p>
                                                                <div class="liright" style="width: calc(100% - 240px);">
                                                                    <span class="">{{ $item['desc']->rear_camera }} </span>
                                                                </div>
                                                            </li>
                                                            <li data-index="0" data-prop="0">
                                                                <p class="lileft">Camera trước:</p>
                                                                <div class="liright">
                                                                    <span class="">{{ $item['desc']->front_camera }}</span>
                                                                </div>
                                                            </li>
                                                            <li data-index="0" data-prop="0">
                                                                <p class="lileft">Chip:</p>
                                                                <div class="liright">
                                                                    <span class="">{{ $item['desc']->chip }}</span>
                                                                </div>
                                                            </li>
                                                            <li data-index="0" data-prop="0">
                                                                <p class="lileft">RAM:</p>
                                                                <div class="liright">
                                                                    <span class="">{{ $item['desc']->ram }} GB</span>
                                                                </div>
                                                            </li>
                                                            <li data-index="0" data-prop="0">
                                                                <p class="lileft">Dung lượng lưu trữ:</p>
                                                                <div class="liright">
                                                                    <span class="">{{ $item['desc']->rom }} GB</span>
                                                                </div>
                                                            </li>
                                                            <li data-index="0" data-prop="0">
                                                                <p class="lileft">SIM:</p>
                                                                <div class="liright">
                                                                    <span class="comma">{{ $item['desc']->sim }}</span>
                                                                </div>
                                                            </li>
                                                            <li data-index="0" data-prop="0">
                                                                <p class="lileft">Pin, Sạc:</p>
                                                                <div class="liright">
                                                                    <span class="comma">{!! $item['desc']->pin !!}</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="first-column">Giá</td>
                                            @foreach ($compare as $item)
                                                <td class="pro-price">{{ number_format($item['price']) }}₫</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="first-column">Trạng thái</td>
                                            @foreach ($compare as $item)
                                                <td class="pro-stock">{{ $item['qty'] > 0 ? 'Còn hàng' : 'Hết hàng' }}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="first-column">Giỏ hàng</td>
                                            @foreach ($compare as $item)
                                                <td>
                                                    <input type="hidden" class="hide_qty_{{ $item['id'] }}"
                                                        value="1">
                                                    <a href="#" class="btn btn-sqr addCart"
                                                        data-proId="{{ $item['id'] }}">thêm giỏ hàng</a>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="first-column">Sao</td>
                                            @foreach ($compare as $item)
                                                <td class="pro-ratting">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="first-column">Xóa</td>
                                            @foreach ($compare as $item)
                                                <td class="pro-remove">
                                                    <a href="{{ route('link.edit', $item['id']) }}"><i
                                                            class="fa fa-trash-o"></i></a>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Compare Page Content End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>

    </style>
    <!-- compare main wrapper end -->
    <div class="popup-addsp" style="display: none;">
        <div class="bg-popup"></div>
        <div class="close-popup" onclick="ClosePopup()">
            <aside>
                <i></i>
                <span>Đóng</span>
            </aside>
        </div>
        <div class="compare-popup">
            <h4>Hoặc nhập tên để tìm</h4>
            <form id="searchproductcompare" onsubmit="return false">
                <div class="find-sp">
                    <input type="text" id="SearchProductCompare" placeholder="Nhập tên điện thoại để tìm">
                    <i class="icon-findcp fa fa-search"></i>
                </div>
                <ul class="pro-compare pro-compare_search">
                </ul>
            </form>
            <div class="scroll-container">
                <h4>Sản phẩm đang khuyến mãi sốc <i class="iconcompare-fire fa fa-fire"></i></h4>
                <ul class="pro-compare pro-compare_sale">
                    @foreach ($products_sales as $item)
                        <li>
                            <a href="{{ route('link.edit',$item->id) }}" class="main-contain">
                                <div class="item-img item-img_42">
                                    <img class=" thumb"
                                        src="{{ asset('uploads/sanpham/' . $item->ProToGall->imageDefault) }}"
                                        alt="{{ ucwords($item->name) }}">
                                </div>
                                <h3>
                                    {{ ucwords($item->name) }}
                                </h3>
                                <div class="box-p">
                                    <p class="price-old black">{{ number_format($item->priceOld) }}₫</p>
                                    <span
                                        class="percent">-{{ number_format((($item->priceOld - $item->price) / $item->price) * 100) }}%</span>
                                </div>
                                <strong class="price">{{ number_format($item->price) }}₫</strong>
                            </a>
                            <a href="{{ route('link.edit',$item->id) }}" class="pro-nrview">
                                Thêm so sánh
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function ClosePopup() {
            $('.popup-addsp').css('display', 'none');
        }

        function OpenPopup() {
            $('.popup-addsp').css('display', 'block');
            var data = [];
            product = {!! $products !!};
            product.forEach(function(value) {
                data['SP' + value['id'] + '|' + value['name']] = 'SP' + value['id'] + '|' + value['name'];
            })
        }

        function formatPrice(input) {
            return input = parseFloat(input)
                .toFixed(0)
                .toString()
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        };

        $(document).on('keyup', '#SearchProductCompare', function() {
            var key = $(this).val();
            debunce(() => $.post('{{ route('link.store') }}', {
                'key': key
            }, function(res, status) {
                var output = '';
                $('.pro-compare_search').css('display', 'none');
                if (key.length > 0) {
                    $('.pro-compare_search').css('display', 'block');
                    $(res.data).each(function(index, value) {
                        var price = formatPrice(value.price);
                        var priceOld = formatPrice(value.priceOld);
                        output += `
                        <li>
                            <a href="javascript:;">
                                <div class="item-img">
                                    <img src="{{ asset('uploads/sanpham') }}/` + value.pro_to_gall.imageDefault + `"
                                        alt="` + value.name + `">
                                </div>
                                <div class="item-info">
                                    <h3>` + value.name + `</h3>
                                    <strong class="price">` + price + `₫</strong>`;
                        if (priceOld != 0) {
                            var percent = formatPrice(((value.price - value.priceOld) / value
                                .price) * 100);
                            output += `
                                            <div class="box-p">
                                                <p class="price-old black">` + priceOld + `₫</p>
                                                <span class="percent">` + percent + `%</span>
                                            </div>
                                        `;
                        }
                        output += `
                                </div>
                            </a>
                            <a href="{{ url('so-sanh') }}/` + value.id + `" class="pro-nrview">
                                <div class="plus">
                                    <i></i>
                                    <i></i>
                                </div>
                            </a>
                        </li>
                        `;
                    });
                    $('.pro-compare_search').html(output);
                }

            }));
        });

    </script>
@stop

@extends('LayoutUser')
@section('content')
    @include('User.inc.area', ['active' => 'Yêu thích'])
    <!-- cart-main-area-start -->
    <div class="cart-main-area mb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="wishlist-content">
                        <form action="#">
                            <div class="wishlist-table table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-remove">
                                                <span class="nobr">Remove</span>
                                            </th>
                                            <th class="product-thumbnail">Hình</th>
                                            <th class="product-name">Tên sản phẩm</th>
                                            <th class="product-price">Giá </th>
                                            <th class="product-stock-stauts">Trạng thái </th>
                                            <th class="product-subtotal">Thêm giỏ hàng</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($wishlist as $item)
                                        <tr>
                                            <td class="product-remove"><a href="{{ route('link.show',$item->pro_id) }}">×</a></td>
                                            <td class="product-thumbnail">
                                                <a href="{{ route('home.show', $item->WhishToPro->slug) }}"><img src="{{ asset('uploads/sanpham/'.$item->WhishToPro->ProToGall->imageDefault) }}" alt="man" /></a>
                                            </td>
                                            <td class="product-name"><a href="{{ route('home.show', $item->WhishToPro->slug) }}">{{ ucwords($item->WhishToPro->name) }}</a></td>
                                            <td class="product-price"><span class="amount">{{ number_format($item->WhishToPro->price) }}₫</span></td>
                                            <td class="product-stock-status"><span class="wishlist-in-stock">{{ $item->WhishToPro->qty > 0 ? 'Còn Hàng' : 'Hết hàng' }}</span>
                                            </td>
                                            <td class="product-add-to-cart">
                                                <input type="hidden" class="hide_qty_{{ $item->pro_id }}"
                                                    value="1">
                                                <a href="#" class="addCart" data-proId="{{ $item->pro_id }}" title="Thêm giỏ hàng"> Thêm giỏ hàng</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @if($wishlist->count() == 0)
                                        <tr>
                                            <td colspan="6">
                                                <div class="div-search col-12">
                                                    <div height="200" width="200" class="img-search">
                                                        <img src="{{ asset('User/img/no-products-found.png') }}">
                                                    </div>
                                                    <div class="title-seach">Không tìm thấy sản phẩm nào</div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                <div class="wishlist-share">
                                                    <h4 class="wishlist-share-title">Chia sẻ:</h4>
                                                    <ul>
                                                        <li><a href="#" class="facebook"><i
                                                                    class="fa fa-facebook"></i></a></li>
                                                        <li><a class="twitter" href="#"><i
                                                                    class="fa fa-twitter"></i></a></li>
                                                        <li><a class="pinterest" href="#"><i
                                                                    class="fa fa-dribbble"></i></a></li>
                                                        <li><a class="googleplus" href="#"><i
                                                                    class="fa fa-google-plus"></i></a></li>
                                                        <li><a class="email" href="#"><i
                                                                    class="fa fa-instagram"></i></a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart-main-area-end -->
@endsection

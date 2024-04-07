@extends('LayoutAdmin')
@section('content')
    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- main title -->
                <div class="col-12">
                    <div class="main__title">
                        <h2>{{ !isset($product) ? 'Thêm Mới' : 'Cập Nhật' }} Phụ kiện</h2>
                    </div>
                </div>
                <!-- end main title -->
                @php
                    $route = isset($product) ? route('sanpham.update', $product->id) : route('sanpham.store');
                    $name = isset($product) ? $product->name : '';
                    $description = isset($product) ? $product->description : '';
                    $price = isset($product) ? $product->price : 0;
                    $price_import = isset($product) ? $product->price_import : 0;
                    $qty = isset($product) ? $product->qty : 0;
                    $status = isset($product) ? $product->status : '';
                    $type = isset($product) ? $product->ProToAccessory->type : '';

                    $imageDefault = isset($product) ? asset('uploads/sanpham/' . $product->ProToGall->imageDefault) : '';
                @endphp
                <!-- form -->
                <div class="col-12">
                    <form action="{{ $route }}" method="POST" class="form" enctype="multipart/form-data">
                        @isset($product)
                            @method('PUT')
                        @endisset
                        @csrf
                        <input type="hidden" name="hidden_act" value="phukien">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12" style="text-align: -webkit-center;">
                                    <div class="form__img" style="width: 50%;">
                                        <label for="form__img-upload">Ảnh (Mặc định)</label>
                                        <input id="form__img-upload" name="imagedefault" type="file" accept="image/*"
                                            {{ isset($product) ? '' : 'required' }}>
                                        <img id="form__img" src="{{ $imageDefault }}" alt="" style="height: 100%; {{ isset($product) ? 'width: 50%' : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-7 form__content">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="profile__group">
                                        <label class="profile__label" for="username">Tên sản phẩm</label>
                                        <input type="text" name="name" class="form__input" required
                                            value="{{ $name }}">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="profile__group">
                                        <label class="profile__label" for="username">Danh Mục</label>
                                        <select class="js-example-basic-single" name="cateid" id="country" required>
                                            <option value=""></option>
                                            <option value="0">--- Chọn ---</option>
                                            {!! $html !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="profile__group">
                                        <label class="profile__label" for="username">Loại</label>
                                        <select class="js-example-basic-single" name="type" id="type" required>
                                            <option value=""></option>
                                            <option {{ $type == 'tai nghe' ? 'selected' : '' }} value="tai nghe">Tai nghe</option>
                                            <option {{ $type == 'sạc' ? 'selected' : '' }} value="sạc">Sạc</option>
                                            <option {{ $type == 'Pin dự phòng' ? 'selected' : '' }} value="Pin dự phòng">Pin dự phòng</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="profile__group">
                                        <label class="profile__label" for="username">Mô tả</label>
                                        <textarea id="text" name="desc" class="form__textarea" placeholder="VD: abc...">{{ $description }}</textarea>
                                    </div>
                                </div>
                                @isset($product)
                                <div class="col-12 col-lg-3">
                                    <div class="profile__group">
                                        <label class="profile__label" for="username">Giá Nhập</label>
                                        <input style="border-color: #ff55a5;" type="text" class="form__input" name="price_import" placeholder="Giá Nhập"
                                            required onkeyup="dinhDangGia(this)" pattern="[0-9,]*" readonly
                                            value="{{ number_format($price_import) }}">
                                    </div>
                                </div>
                                @endisset
                                <div class="col-12 col-lg-{{ isset($product) ? 4 : 6 }}">
                                    <div class="profile__group">
                                        <label class="profile__label" for="username">Giá Bán</label>
                                        <input type="text" class="form__input" name="price" placeholder="Giá Bán"
                                            required onkeyup="dinhDangGia(this)" pattern="[0-9,]*"
                                            value="{{ number_format($price) }}">
                                    </div>
                                </div>
                                @isset($product)
                                <div class="col-12 col-lg-2">
                                    <div class="profile__group">
                                        <label class="profile__label" for="username">Số Lượng</label>
                                        <input style="border-color: #ff55a5;" type="number" min="0" oninput="this.value = Math.abs(this.value)"
                                            class="form__input" name="qty" placeholder="Số Lượng" required readonly
                                            value="{{ $qty }}">
                                    </div>
                                </div>
                                @endisset
                                <div class="col-12 col-lg-{{ isset($product) ? 3 : 6 }}">
                                    <div class="profile__group">
                                        <label class="profile__label" for="username">Trạng Thái</label>
                                        <select class="js-example-basic-single" name="status" id="status" required>
                                            <option value=""></option>
                                            <option {{ $status == 0 ? 'selected' : '' }} value="0">Hiện</option>
                                            <option {{ $status == 1 ? 'selected' : '' }} value="1">Ẩn</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form__gallery">
                                        <label id="gallery1" for="form__gallery-upload">Ảnh Chi Tiết</label>
                                        <input data-name="#gallery1" id="form__gallery-upload" name="gallery[]"
                                            class="form__gallery-upload" type="file" accept="image/*" multiple>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button style="float: right;" type="submit"
                                        class="form__btn eventClick">Thêm</button>
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
    <script></script>
@stop

@extends('LayoutAdmin')
@section('content')
    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- main title -->
                <div class="col-12">
                    <div class="main__title">
                        <h2>{{ !isset($slider) ? 'Thêm Mới' : 'Cập Nhật' }}</h2>
                    </div>
                </div>
                <!-- end main title -->
                @php
                    $route = isset($slider) ? route('slider.update', $slider->id) : route('slider.store');
                    $name = isset($slider) ? $slider->name : '';
                    $desc = isset($slider) ? $slider->desc : '';
                    $link = isset($slider) ? $slider->link : '';
                    $status = isset($slider) ? $slider->status : '';
                    $imageDefault = isset($slider) ? asset('uploads/slider/' . $slider->image) : '';
                @endphp
                <!-- form -->
                <div class="col-12">
                    <form action="{{ $route }}" method="POST" class="form" enctype="multipart/form-data">
                        @isset($slider)
                            @method('PUT')
                        @endisset
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-5 form__cover">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-12">
                                        <div class="form__img" style="height: 469px;">
                                            <label for="form__img-upload">Ảnh (Mặc định)</label>
                                            <input id="form__img-upload" name="imagedefault" type="file" accept="image/*"
                                                {{ isset($slider) ? '' : 'required' }}>
                                            <img id="form__img" src="{{ $imageDefault }}" alt=" ">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-7 form__content">
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" name="name" class="form__input" placeholder="Tiêu đề" required
                                            value="{{ $name }}">
                                    </div>
                                    <div class="col-12">
                                        <textarea style="height: 324px;" name="desc" class="form__input" placeholder="Mô tả" required  rows="35">{{ $desc }}</textarea>
                                    </div>
                                    <div class="col-6">
                                        <input type="url" name="link" class="form__input" placeholder="Đường dẫn"
                                            value="{{ $link }}">
                                    </div>
                                    <div class="col-6">
                                        <select class="js-example-basic-single" name="status" id="status" required>
                                            <option value=""></option>
                                            <option {{ $status == 0 ? 'selected' : '' }}  value="0">Hiện</option>
                                            <option {{ $status == 1 ? 'selected' : '' }}  value="1">Ẩn</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <button style="float: right;" type="submit" class="form__btn eventClick">Thêm</button>
                                    </div>
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


    </script>
@stop

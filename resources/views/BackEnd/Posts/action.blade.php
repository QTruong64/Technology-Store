@extends('LayoutAdmin')
@section('content')
    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- main title -->
                <div class="col-12">
                    <div class="main__title">
                        <h2>{{ !isset($post) ? 'Thêm Mới' : 'Cập Nhật' }} Bài viết</h2>
                    </div>
                </div>
                <!-- end main title -->
                @php
                    $route = isset($post) ? route('baiviet.update', $post->id) : route('baiviet.store');
                    $name = isset($post) ? $post->name : '';
                    $short_desc = isset($post) ? $post->short_desc : '';
                    $description = isset($post) ? $post->desc : '';

                    $imageDefault = isset($post) ? asset('uploads/baiviet/' . $post->image) : '';
                @endphp
                <!-- form -->
                <div class="col-12">
                    <form action="{{ $route }}" method="POST" class="form" enctype="multipart/form-data">
                        @isset($post)
                            @method('PUT')
                        @endisset
                        @csrf
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12" style="text-align: -webkit-center;">
                                    <div class="form__img" style="width: 50%;">
                                        <label for="form__img-upload">Ảnh (Mặc định)</label>
                                        <input id="form__img-upload" name="imagedefault" type="file" accept="image/*"
                                            {{ isset($post) ? '' : 'required' }}>
                                        <img id="form__img" src="{{ $imageDefault }}" alt=""
                                            style="height: 100%; {{ isset($post) ? 'width: 50%' : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-7 form__content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="profile__group">
                                        <label class="profile__label">Tên sản phẩm</label>
                                        <input type="text" name="name" class="form__input" required
                                            value="{{ $name }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="profile__group">
                                        <label class="profile__label">Mô tả ngắn</label>
                                        <textarea name="short_desc" id="short_desc" class="form__textarea" placeholder="VD: abc...">{{ $short_desc }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="profile__group">
                                        <label class="profile__label">Mô tả</label>
                                        <textarea name="desc" id="desc" class="form__textarea" placeholder="VD: abc...">{{ $description }}</textarea>
                                    </div>
                                </div>
                                @php
                                    $arr_tag = [];
                                    if(isset($post->PostToPostTags)){

                                        foreach ($post->PostToPostTags as $tag) {
                                            $arr_tag[] = $tag->tag_id;
                                        }
                                    }
                                @endphp
                                <div class="col-12">
                                    <div class="profile__group">
                                        <label class="profile__label">Tag</label>
                                        <select class="js-example-basic-single" name="tags[]" id="tags"
                                            multiple="multiple" required>
                                            @foreach ($tags as $item)
                                                <option {{ in_array($item->id, $arr_tag) ? 'selected' : '' }}
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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

                    </form>
                </div>
                <!-- end form -->
            </div>
        </div>
    </main>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('BackEnd') }}/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.addCss('.cke_editable { background-color: #2b2b31; color: white }');
        CKEDITOR.config.autoParagraph = false;
        CKEDITOR.replace('desc');
    </script>
@stop

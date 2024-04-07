@extends('LayoutAdmin')
@section('content')
    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- main title -->
                <div class="col-12">
                    <div class="main__title">
                        <h2>{{ !isset($category) ? 'Thêm Mới' : 'Cập Nhật' }}</h2>
                    </div>
                </div>
                <!-- end main title -->

                <!-- form -->
                @php
                    $route = isset($category) ? route('theloai.update', $category->id) : route('theloai.store');
                    $name = isset($category) ? $category->name : '';
                @endphp
                <div class="col-12">
                    <form action="{{ $route }}" method="POST" class="form">
                        @isset($category)
                            @method('PUT')
                        @endisset
                        @csrf

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" name="name" class="form__input" placeholder="Name" required
                                        value="{{ $name }}">
                                </div>

                                <div class="col-6">
                                    <select class="js-example-basic-single" name="parent_id" id="country">
                                        <option value=""></option>
                                        <option value="0">--- Choose ---</option>
                                        {!! $html !!}
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

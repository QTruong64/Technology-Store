@extends('LayoutAdmin')
@section('content')
    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- main title -->
                <div class="col-12">
                    <div class="main__title">
                        <h2>{{ !isset($type) ? 'Thêm Mới' : 'Cập Nhật' }}</h2>
                    </div>
                </div>
                <!-- end main title -->

                <!-- form -->
                @php
                    $route = isset($type) ? route('loaibaiviet.update', $type->id) : route('loaibaiviet.store');
                    $name = isset($type) ? $type->name : '';
                    $status = isset($type) ? $type->status : '';
                @endphp
                <div class="col-12">
                    <form action="{{ $route }}" method="POST" class="form">
                        @isset($type)
                            @method('PUT')
                        @endisset
                        @csrf
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <input
                                        type="text" name="name" class="form__input" placeholder="Tên" required
                                        value="{{ $name }}">
                                </div>
                                <div class="col-6">
                                    <select class="js-example-basic-single" name="status" id="status">
                                        <option value=""></option>
                                        <option {{ $status == 0 ? 'selected' : '' }} value="0">Hiện</option>
                                        <option {{ $status == 1 ? 'selected' : '' }} value="1">Ẩn</option>
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


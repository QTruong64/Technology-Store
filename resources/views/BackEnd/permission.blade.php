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
                <div class="col-12">
                    <form action="{{ route('tongquan.store') }}" method="POST" class="form">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-7 form__content">
                                <div class="row">
                                    <div class="col-6">

                                        <select class="js-example-basic-single" name="name" id="country">
                                            <option value=""></option>
                                            <option value="0">--- Choose ---</option>
                                            @foreach (config('assets.assets') as $item)
                                                <option value="{{ $item['key'] }}|{{ $item['name'] }}">{{ $item['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-6">
                                        @foreach (config('assets.action') as $item)
                                        <input type="text" name="action[]" class="form__input" value="{{ $item }}" readonly>
                                        @endforeach
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
                        </div>
                    </form>
                </div>
                <!-- end form -->
            </div>
        </div>
    </main>
@endsection

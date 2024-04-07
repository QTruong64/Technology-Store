@extends('LayoutAdmin')
@section('content')
    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- main title -->
                <div class="col-12">
                    <div class="main__title">
                        <h2>{{ !isset($user) ? 'Thêm Mới' : 'Cập Nhật' }}</h2>
                    </div>
                </div>
                <!-- end main title -->

                <!-- form -->
                @php
                    $route = isset($user) ? route('taikhoan.update', $user->id) : route('taikhoan.store');
                    $name = isset($user) ? $user->name : '';
                    $email = isset($user) ? $user->email : '';
                    $roleId = isset($user) ? $user->roles : '';
                @endphp
                <div class="col-12">
                    <form action="{{ $route }}" method="POST" class="form">
                        @isset($user)
                            @method('PUT')
                        @endisset
                        @csrf

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="profile__label" for="username">Họ & tên</label>
                                        <input type="text" name="name" class="form__input" placeholder="Name" required
                                            value="{{ $name }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="profile__label" for="username">Email</label>
                                        <input {{ !empty($email) ? 'readonly' : '' }} type="email" name="email"
                                            class="form__input" placeholder="Email" required value="{{ $email }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="profile__label" for="username">Mật khẩu</label>
                                        <input type="text" name="password" class="form__input" placeholder="Password"
                                            {{ isset($user) ? '' : 'required' }} value="">
                                    </div>
                                    <div class="col-12">
                                        <label class="profile__label" for="username">Quyền</label>
                                        <select class="js-example-basic-single" name="role_id[]" multiple id="level">
                                            <option value=""></option>
                                            @foreach ($roles as $item)
                                                <option
                                                    {{ !empty($roleId) ? ($roleId->contains('id', $item->id) ? 'selected' : '') : '' }}
                                                    value="{{ $item->id }}">{{ $item->display_name }}</option>
                                            @endforeach
                                        </select>
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

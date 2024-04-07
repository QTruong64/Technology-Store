@extends('LayoutAdmin')
@section('content')
    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- main title -->
                <div class="col-12">
                    <div class="main__title">
                        <h2>{{ !isset($role) ? 'Thêm Mới' : 'Chỉnh sửa' }}</h2>
                    </div>
                </div>
                <!-- end main title -->

                <!-- form -->
                @php
                    $route = isset($role) ? route('vaitro.update', $role->id) : route('vaitro.store');
                    $name = isset($role) ? $role->name : '';
                    $display_name = isset($role) ? $role->display_name : '';
                    $permissionId = isset($role) ? $role->permissions : '';
                @endphp
                <div class="col-12">
                    <form action="{{ $route }}" method="POST">
                        @isset($role)
                            @method('PUT')
                        @endisset
                        @csrf
                        <div class="col-12">
                            <div class="row form">
                                <div class="col-12">
                                    <label class="profile__label" for="username">Tên</label>
                                    <input type="text" name="name" class="form__input" required
                                        value="{{ $name }}">
                                </div>
                                <div class="col-12">
                                    <label class="profile__label" for="username">Mô tả</label>
                                    <textarea rows="5" name="display_name" class="form__input" required>{{ $display_name }}</textarea>
                                </div>
                            </div>

                        </div>
                        <div class="col-12" >
                            <div class="row form">
                                <div class="col-12" style=" text-align: center; height: 20pt;">
                                    <div class="profile__title">
                                        <div class="form-group">
                                            <label class="form-check-label">
                                                <input class="form-check-input checkbox_all" type="checkbox">
                                                <span class="form-check-sign" style="font-size: 17px;">Tất cả</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ($permission as $parentitem)
                            <div class="col-12">
                                <div class="row form">
                                    <div class="col-12">
                                        <div class="profile__title" style="border-bottom: 1px solid white;">
                                            <div class="form-group">
                                                <label class="form-check-label">
                                                    <input class="form-check-input checkbox_parent" type="checkbox">
                                                    <span class="form-check-sign" style="font-size: 17px;">Module
                                                        {{ $parentitem->display_name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($parentitem->permissionsChildrent as $childitem)
                                        <div class="col-3">
                                            <div class="form-group">
                                                <div class="form-check p-0 mt-1 ml-4">
                                                    <label class="form-check-label profile__label">
                                                        <input
                                                            {{ !empty($permissionId) ? ($permissionId->contains('id', $childitem->id) ? 'checked' : '') : '' }}
                                                            class="form-check-input checkbox_child" name="permission_id[]"
                                                            type="checkbox" value="{{ $childitem->id }}">
                                                        <span class="form-check-sign"
                                                            style="padding-top:3px;">{{ $childitem->name }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12" style="margin-top: 3%;">
                            <div class="row" style="float: right;">
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
@section('js')
    <script>
        $('.checkbox_parent').on('click', function() {
            $(this).parents('.form').find('.checkbox_child').prop('checked', $(this).prop('checked'));
        });
        $('.checkbox_all').on('click', function() {
            $(this).parents().find('.checkbox_child').prop('checked', $(this).prop('checked'));
            $(this).parents().find('.checkbox_parent').prop('checked', $(this).prop('checked'));
        });
    </script>
@stop

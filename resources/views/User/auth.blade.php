@extends('LayoutUser')
@section('content')
@include('User.inc.area', ['active' => $action == 'signIn' ? 'Đăng nhập' : 'Đăng ký'])
<style>
    .social {
        margin-top: 2%;
        border: 1px solid rgba(0, 0, 0, 0.12);
        border-radius: 100%;
        font-size: 23px;
        vertical-align: middle;
        text-align: center;
        padding: 0.4% 1% 0.4% 1%;
        color: #00abe0;
    }

    .social:hover {
        border: 1px solid white;
        background-color: #00abe0;
        color: white;
    }
</style>
<!-- user-login-area-start -->
<div class="user-login-area mb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="login-title text-center mb-30">
                    <h2>{{ $action == 'signIn' ? 'Đăng nhập' : 'Đăng ký' }}</h2>
                    <div>
                        <a class="social" href="{{ route('social.google.index') }}"><i class="fa fa-google"></i></a>
                    </div>
                </div>
            </div>
            <div class="offset-lg-3 col-lg-6 col-md-12 col-12">
                <form action="{{ route('auth.store') }}" method="POST">
                    @csrf
                    @if ($action == 'signIn')
                    <input type="hidden" name="action" value="login">
                    <input type="hidden" name="level" value="user">
                    <div class="login-form">
                        <div class="single-login">
                            <label>Email<span>*</span></label>
                            <input type="email" name="email" required />
                        </div>
                        <div class="single-login" style="position: sticky;">
                            <label>Mật khẩu <span>*</span></label>
                            <input type="password" name="password" required />
                            <a style="position: absolute; top: 53%; right: 2%; color: #3b5998;"
                                href="{{ route('authuser.create') }}">Quên
                                mật khẩu?</a>
                        </div>
                        <div class="single-login single-login-2">
                            <button style=" width: 100%; margin-top: 2%; " type="submit">Đăng nhập</button>
                        </div>
                        <p>Chưa có tài khoản? <a href="{{ route('authuser.signup.index') }}">ĐĂNG KÝ</a> ngay!</p>
                    </div>
                    @else
                    <input type="hidden" name="action" value="register">
                    <div class="login-form">
                        <div class="single-login">
                            <label>Tài khoản<span>*</span></label>
                            <input type="text" name="name" required />
                        </div>
                        <div class="single-login">
                            <label>Email<span>*</span></label>
                            <input type="email" name="email" required />
                        </div>
                        <div class="single-login">
                            <label>Số điện thoại</label>
                            <input type="tel" name="phone" required />
                        </div>
                        <div class="single-login" style="position: sticky;">
                            <label>Mật khẩu <span>*</span></label>
                            <input type="password" name="password" id="password" required />
                        </div>
                        <div class="single-login" style="position: sticky;">
                            <label>Nhập lại mật khẩu <span>*</span></label>
                            <input type="password" name="re_password" id="re_password" required />
                        </div>
                        <div class="field">
                            <span id="message"></span>
                        </div>
                        <div class="single-login single-login-2">
                            <button id="submit-pass" style=" width: 100%; margin-top: 2%; " type="submit">Đăng
                                Ký</button>
                        </div>
                        <p>Dã có tài khoản? <a href="{{ route('authuser.signin.index') }}">ĐĂNG NHẬP</a> ngay!</p>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
<!-- user-login-area-end -->
<style type="text/css">
    .wrapper {
        height: 130px;
        width: 250px;
        background: #f8f8f8;
        padding: 10px;
    }

    .field {
        margin: 4px;
    }
</style>
@endsection
@section('js')
<script>
    $('#password, #re_password, #phone').on('keyup', function () {
        var password = $('#password').val();
        var re_password = $('#re_password').val();
        var phone = $('#phone').val();

        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/;
        var phoneRegex = /^0\d{9}$/;

        if (password == "" && re_password == "" && phone == "") {
            $('#submit-pass').prop('disabled', true);
            $('#message').hide();
        } else if (password == re_password && password.match(passwordRegex) && phone.match(phoneRegex)) {
            $('#submit-pass').prop('disabled', false);
            $('#message').hide();
        } else {
            $('#submit-pass').prop('disabled', true);
            $('#message').show().html('Mật khẩu không khớp hoặc không đủ mạnh hoặc số điện thoại không hợp lệ!').css('color', 'red');
        }
    });
</script>

@endsection

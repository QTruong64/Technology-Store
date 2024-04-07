<!DOCTYPE html>
<html lang="en">
<head>
    <title>YÊU CẦU THAY ĐỔI MẬT KHẨU</title>
    <style>
        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .col-50 {
            width: 50%;
            float: left;
        }

        @media (max-width: 480px) {
            .col-50 {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div style='background-color: #e3e3e3; padding: 20px 0px 10px 0px; color: #484a4c;'>
        <div style='margin: 0 auto; width: 100%; max-width: 660px; background-color: #fff;font-size: 14px'>
            <div style='border-bottom: 5px solid #01AAE3; padding: 20px;'>
                <img border='0' width="150" height="100" alt='logo sharecode' src='https://i.pinimg.com/originals/4a/79/ed/4a79ed8743ec46d4df847a7ba9d34b36.png' />
            </div>
            <div style='padding: 20px;'>
                <div style='text-align: center; font-size: 18px; font-weight: bold;margin-bottom: 15px;'>YÊU CẦU THAY ĐỔI MẬT KHẨU</div>
                <b style='font-style: italic;'>{{ $array['name'] }} thân mến,</b>
                <p>
                    Người dùng <b>{{ $array['email'] }}</b> {{ env('APP_NAME') }} đã nhận được yêu cầu thay đổi mật khẩu của quý khách.
                </p>
                <p style='clear: both; padding-top: 5px; text-align:center'>
                    <br /> Xin hãy click vào đường dẫn sau để đổi mật khẩu: <br />
                    <a href="{{ route('mail.show',$array['token']) }}" style='padding: 10px 20px;background: #01AAE3;line-height: 50px;color: white;border-radius: 5px;'>CLICK ME!</a><br />
                </p>
                <p>
                    Mọi thắc mắc và góp ý vui lòng liên hệ với shop qua email: support@gmail.com hoặc số điện thoại 1900 xxx (8-21h cả T7,CN).
                </p>
                <p>Trân trọng,<br> Pv.vn</p>
            </div>
        </div>
    </div>
</body>

</html>

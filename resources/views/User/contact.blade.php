@extends('LayoutUser')
@section('content')
@include('User.inc.area',['active'=>'Liên hệ'])
<!-- googleMap-area-start -->
<div class="map-area mb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125317.59141850974!2d106.5745420880079!3d11.025513530455374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d17273d88fa1%3A0x4ce77ac2d75e8e4c!2zVHAuIFRo4bunIEThuqd1IE3hu5l0LCBCw6xuaCBExrDGoW5nLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1684638426125!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- googleMap-end -->
<!-- contact-area-start -->
<div class="contact-area mb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="contact-info">
                    <h3>Thông tin liên hệ</h3>
                    <ul>
                        <li>
                            <i class="fa fa-map-marker"></i>
                            <span>Địa chỉ: </span> ABC,quận 4.
                        </li>
                        <li>
                            <i class="fa fa-envelope"></i>
                            <span>Điện thoại: </span> (+84) 123 4567 890
                        </li>
                        <li>
                            <i class="fa fa-mobile"></i>
                            <span>Email: </span>
                            <a href="#">support@gmail.com</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="contact-form">
                    <h3><i class="fa fa-envelope-o"></i>ĐỂ LẠI LỜI NHẮN</h3>
                    <form action="{{ route('mail.index') }}" method="GET" id="contact-form">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="single-form-3">
                                    <input name="name" type="text" placeholder="Tên">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="single-form-3">
                                    <input name="email" type="email" placeholder="Email">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="single-form-3">
                                    <textarea name="message" placeholder="Tin nhắn"></textarea>
                                    <button class="submit" type="submit">gửi tin nhắn</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p class="form-messege"></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contact-area-end -->
@endsection

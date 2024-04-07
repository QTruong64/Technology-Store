@extends('LayoutUser')
@section('content')
@include('User.inc.area',['active'=>'Giới thiệu'])

<!-- counter-area-start -->
<div class="counter-area pt-70 pb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="single-counter mb-30 text-center">
                    <h2 class="counter">90</h2>
                    <span>DỰ ÁN ĐÃ HOÀN THÀNH</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="single-counter mb-30 text-center">
                    <h2 class="counter">80</h2>
                    <span>chức năng</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="single-counter mb-30 text-center">
                    <h2 class="counter">100</h2>
                    <span>giao diện</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="single-counter mb-30 text-center">
                    <h2 class="counter">70</h2>
                    <span>tốc độ website</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- counter-area-end -->
<!-- team-area-start -->
<div class="team-area pt-70 pb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="team-title text-center mb-50">
                    <h2>Thành viên nhóm</h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="single-team mb-30">
                    <div class="team-img-area">
                        <div class="team-img">
                            <a href="#"><img src="https://i.pinimg.com/236x/65/f6/9e/65f69e531f37a58d6a169cfdc1460357.jpg" alt="man" /></a>
                        </div>
                        <div class="team-link">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="team-content text-center">
                        <h3>Pipj Moriarty</h3>
                        <span>PHP Devloper</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- team-area-end -->

@endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('BackEnd') }}/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="{{ asset('BackEnd') }}/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="{{ asset('BackEnd') }}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('BackEnd') }}/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="{{ asset('BackEnd') }}/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('BackEnd') }}/css/admin.css">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('BackEnd') }}/icon/favicon-32x32.png">
    <title>Phong Van</title>

</head>

<body>

    <!-- page 404 -->
    <div class="page-404 section--bg" data-bg="{{ asset('BackEnd') }}/img/section/section.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-404__wrap">
                        <div class="page-404__content">
                            <h1 class="page-404__title">403</h1>
                            <p class="page-404__text">HÀNH ĐỘNG NÀY LÀ TRÁI PHÉP!</p>
                            <a href="{{ str_replace(url('/'), '', url()->previous()) }}" class="page-404__btn">Trở lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page 404 -->

    <!-- JS -->
    <script src="{{ asset('BackEnd') }}/js/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('BackEnd') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('BackEnd') }}/js/jquery.magnific-popup.min.js"></script>
    <script src="{{ asset('BackEnd') }}/js/jquery.mousewheel.min.js"></script>
    <script src="{{ asset('BackEnd') }}/js/jquery.mCustomScrollbar.min.js"></script>
    <script src="{{ asset('BackEnd') }}/js/select2.min.js"></script>
    <script src="{{ asset('BackEnd') }}/js/admin.js"></script>
</body>

</html>

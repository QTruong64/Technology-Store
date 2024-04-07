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
    <link rel="apple-touch-icon" href="icon/favicon-32x32.png">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Dmitry Volkov">
    <title>Phong Van</title>
</head>

<body>

    <div class="sign section--bg" data-bg="{{ asset('Admin') }}/img/section/section.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sign__content">
                        <!-- authorization form -->
                        <form action="{{ route('auth.store') }}" method="POST" class="sign__form">
                            @csrf
                            <input type="hidden" name="action" value="login">
                            <a href="#" class="sign__logo" style="font-size: 38px;">
                                <span style="color: white;">ADM</span><span class="text-gradient">IN</span>
                            </a>

                            <div class="sign__group">
                                <input type="text" class="sign__input" name="email" placeholder="Email"
                                    value="{{ old('email') }}">
                            </div>

                            <div class="sign__group">
                                <input type="password" class="sign__input" name="password" placeholder="Password">
                            </div>



                            <button type="submit" class="sign__btn" type="button">Sign in</button>
                        </form>
                        <!-- end authorization form -->
                    </div>
                </div>
            </div>
        </div>
    </div>

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

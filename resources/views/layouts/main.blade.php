<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        @yield('head')
    </head>
    <body>
        <div id="preloder">
            <div class="loader"></div>
        </div>
        <div class="offcanvas-menu-overlay"></div>

        <div class="offcanvas-menu-wrapper">
            <div class="offcanvas__close">+</div>
            <ul class="offcanvas__widget">
                <li><span class="icon_search search-switch"></span></li>
                <li>
                    <a href="#">
                        <span class="icon_heart_alt"></span>
                        <div class="tip">2</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon_bag_alt"></span>
                        <div class="tip">2</div>
                    </a>
                </li>
            </ul>
            <div class="offcanvas__logo">
                <a href="./index.html"><img src="img/logo.png" alt></a>
            </div>
            <div id="mobile-menu-wrap"></div>
            <div class="offcanvas__auth">
                <a href="#">Login</a>
                <a href="#">Register</a>
            </div>
        </div>

        @include('partials.header')
        
        @yield('content')

        @include('partials.footer')

        @include('partials.search-model')

        <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('js/mixitup.min.js') }}"></script>
        <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
        <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
        <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        @yield('scripts')
    </body>
</html>
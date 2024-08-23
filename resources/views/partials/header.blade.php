<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-lg-2">
                <div class="header__logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="Logo"></a>
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <nav class="header__menu">
                    <ul>
                        <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="#">Women’s</a></li>
                        <li><a href="#">Men’s</a></li>
                        <li class="{{ Request::is('shop') ? 'active' : '' }}"><a href="{{ url('/shop') }}">Shop</a></li>
                        <li>
                            <a href="#">Pages</a>
                            <ul class="dropdown">
                                <li class="{{ Request::is('product-details') ? 'active' : '' }}"><a href="{{ url('/product-details') }}">Product Details</a></li>
                                <li class="{{ Request::is('shop-cart') ? 'active' : '' }}"><a href="{{ url('/shop-cart') }}">Shop Cart</a></li>
                                <li class="{{ Request::is('checkout') ? 'active' : '' }}"><a href="{{ url('/checkout') }}">Checkout</a></li>
                                <li class="{{ Request::is('blog-details') ? 'active' : '' }}"><a href="{{ url('/blog-details') }}">Blog Details</a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::is('blog') ? 'active' : '' }}"><a href="{{ url('/blog') }}">Blog</a></li>
                        <li class="{{ Request::is('contact') ? 'active' : '' }}"><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__right">
                    <div class="header__right__auth">
                        @guest
                            <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('register') }}">Register</a>
                        @else
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                               Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endguest
                    </div>
                    <ul class="header__right__widget">
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
                </div>
            </div>
        </div>
        <div class="canvas__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>

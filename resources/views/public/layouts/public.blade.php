<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'SchoolGear Liberia')</title>
    <meta name="description" content="@yield('description', 'SchoolGear Liberia is a school management platform helping schools simplify administration, manage academic information, and connect their school community through technology.')">

    <link rel="icon" href="{{ asset('schoolGear_liberia_public_site/img/favicon-96x96.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/bootstrap.min.css') }}">
    <!-- animate CSS -->
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/animate.css') }}">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/owl.carousel.min.css') }}">
    <!-- themify CSS -->
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/themify-icons.css') }}">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/flaticon.css') }}">
    <!-- magnific popup CSS -->
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/magnific-popup.css') }}">
    <!-- slick CSS -->
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/slick.css') }}">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/style.css') }}">
    <!-- SchoolGear brand overrides (loaded last, wins the cascade) -->
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/schoolgear-theme.css') }}">

    @stack('styles')
</head>

<body>
    <!--::header part start::-->
    <header class="main_menu home_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{ asset('logo/download.png') }}" alt="SchoolGear Liberia logo"
                                class="sg-header-logo">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item justify-content-end"
                            id="navbarSupportedContent">
                            <ul class="navbar-nav align-items-center">
                                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/about-us') }}">About</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/contact-us') }}">Contact</a>
                                </li>

                                <li class="nav-item header_cta_item">
                                    <a class="btn_2 header_signin_btn" href="{{ route('login') }}" id="signInBtn">
                                        <span class="signin_btn_text">Sign In</span>
                                        <span class="signin_btn_spinner"></span>
                                    </a>
                                </li>
                                <li class="nav-item header_cta_item">
                                    <a class="btn_1" href="{{ route('public.register') }}">Get Started</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header part end-->

    @yield('content')

    <!-- footer part start-->
    <footer class="footer-area">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <div class="single-footer-widget footer_1">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{ asset('logo/download.png') }}" alt="SchoolGear Liberia logo"
                                class="sg-header-logo">
                        </a>
                        <p>
                            SchoolGear Liberia is a modern school management system built to
                            help Liberian schools simplify administration, manage academic
                            records, and keep their school community connected.
                        </p>
                        <p>Built for schools. Designed for simpler school management.</p>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xl-4">
                    <div class="single-footer-widget footer_2">
                        <h4>Stay Connected</h4>
                        <p>
                            Stay informed about SchoolGear updates, new features, and
                            practical resources designed to help schools manage their
                            operations better.
                        </p>
                        <form action="#">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Enter email address"
                                        onfocus="this.placeholder = ''"
                                        onblur="this.placeholder = 'Enter email address'" />
                                    <div class="input-group-append">
                                        <button class="btn btn_1" type="button">
                                            <i class="ti-angle-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="social_icon">
                            <a href="#"><i class="ti-facebook"></i></a>
                            <a href="#"><i class="ti-twitter-alt"></i></a>
                            <a href="#"><i class="ti-instagram"></i></a>
                            <a href="#"><i class="ti-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-md-4">
                    <div class="single-footer-widget footer_2">
                        <h4>Contact Us</h4>
                        <div class="contact_info">
                            <p><span>Address :</span> Airfield, Sinkor, Monrovia, Liberia</p>
                            <p><span>Phone :</span> <a href="tel:+231770123498">+231 77 012 3498</a></p>
                            <p><span>Email :</span> <a
                                    href="mailto:potiphargvaye@gmail.com">potiphargvaye@gmail.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright_part_text text-center">
                        <div class="row">
                            <div class="col-lg-12">
                                <p class="footer-text m-0">
                                    Copyright &copy; {{ date('Y') }} SchoolGear Liberia. All rights reserved.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer part end-->

    <!-- jquery -->
    <script src="{{ asset('schoolGear_liberia_public_site/js/jquery-1.12.1.min.js') }}"></script>
    <!-- popper js -->
    <script src="{{ asset('schoolGear_liberia_public_site/js/popper.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('schoolGear_liberia_public_site/js/bootstrap.min.js') }}"></script>
    <!-- magnific popup js -->
    <script src="{{ asset('schoolGear_liberia_public_site/js/jquery.magnific-popup.js') }}"></script>
    <!-- swiper js -->
    <script src="{{ asset('schoolGear_liberia_public_site/js/swiper.min.js') }}"></script>
    <!-- masonry js -->
    <script src="{{ asset('schoolGear_liberia_public_site/js/masonry.pkgd.js') }}"></script>
    <!-- owl carousel js -->
    <script src="{{ asset('schoolGear_liberia_public_site/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('schoolGear_liberia_public_site/js/jquery.nice-select.min.js') }}"></script>
    <!-- slick js -->
    <script src="{{ asset('schoolGear_liberia_public_site/js/slick.min.js') }}"></script>
    <script src="{{ asset('schoolGear_liberia_public_site/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('schoolGear_liberia_public_site/js/waypoints.min.js') }}"></script>
    <!-- custom js -->
    <script src="{{ asset('schoolGear_liberia_public_site/js/custom.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var signInBtn = document.getElementById('signInBtn');
            if (!signInBtn) return;

            signInBtn.addEventListener('click', function() {
                // Don't preventDefault — let the link navigate normally.
                // This just updates the UI in the moment before the page unloads.
                signInBtn.classList.add('is-loading');
                signInBtn.querySelector('.signin_btn_text').textContent = 'Redirecting...';
            });
        });
    </script>

    @stack('scripts')
</body>

</html>

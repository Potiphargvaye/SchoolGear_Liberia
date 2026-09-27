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
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/whatsapp-widget.css') }}">

    @stack('styles')
</head>

<body>


    {{-- Sticky Wrapper Container --}}
    <div class="sg-header-sticky-wrapper">

        {{-- WASSCE 2026 announcement strip --}}
        <div class="sg-announce-banner">
            <div class="container">
                <div
                    class="d-flex flex-wrap align-items-center justify-content-center text-center py-2 sg-announce-row">

                    <span class="sg-announce-icon mr-2" aria-hidden="true">
                        <svg width="26" height="22" viewBox="0 0 32 28" xmlns="http://www.w3.org/2000/svg">
                            <polygon
                                points="27,2 27.6,3.6 29.3,3.7 27.9,4.7 28.4,6.3 27,5.3 25.6,6.3 26.1,4.7 24.7,3.7 26.4,3.6"
                                fill="#FFE29A" />
                            <polygon points="4,4 4.4,5.1 5.6,5.2 4.7,5.9 5,7 4,6.4 3,7 3.3,5.9 2.4,5.2 3.6,5.1"
                                fill="#FFE29A" />
                            <polygon points="16,8 30,13 16,18 2,13" fill="#FFE29A" />
                            <rect x="9" y="14" width="14" height="5" rx="1.2" fill="#3A2A99" />
                            <path d="M24,13.5 L24,21.5" stroke="#FFE29A" stroke-width="1.4" stroke-linecap="round" />
                            <circle cx="24" cy="22.5" r="1.6" fill="#FFE29A" />
                        </svg>
                    </span>

                    <span class="sg-announce-text">
                        Congratulations, WASSCE 2026 Candidates! Your results are in
                        <a href="https://result.liberiareg.org/" target="_blank" rel="noopener"
                            class="sg-announce-link">
                            check your result here
                        </a> to view your official results.
                    </span>

                    <a href="https://result.liberiareg.org/" target="_blank" rel="noopener"
                        class="sg-announce-btn ml-md-3 mt-2 mt-md-0">
                        Check My Results <span aria-hidden="true">&rarr;</span>
                    </a>

                </div>
            </div>
        </div>




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


        <!-- WhatsApp Floating Button -->
        <a href="https://wa.me/+231777987113" target="_blank" class="whatsapp-float"
            aria-label="Message us on WhatsApp">
            <svg class="whatsapp-icon" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.71.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                <path
                    d="M12.001 2C6.478 2 2 6.477 2 12c0 1.9.526 3.68 1.44 5.2L2 22l4.943-1.397A9.955 9.955 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12.001 2zm0 18.29a8.27 8.27 0 01-4.216-1.155l-.303-.18-3.13.884.836-3.05-.198-.313A8.267 8.267 0 013.71 12c0-4.577 3.714-8.29 8.29-8.29 4.577 0 8.29 3.713 8.29 8.29 0 4.576-3.713 8.29-8.289 8.29z" />
            </svg>
            <span class="whatsapp-tooltip">Message us on WhatsApp</span>
        </a>


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

            /// jjs script for the WASSCE Banner 
            function updateBannerOffset() {
                const banner = document.querySelector('.sg-announce-banner');
                const header = document.querySelector('.main_menu');

                if (banner && header) {
                    const bannerHeight = banner.offsetHeight;
                    // Dynamically pass exact banner height to CSS variable
                    document.documentElement.style.setProperty('--banner-height', bannerHeight + 'px');
                }
            }

            // Run on load and whenever screen resizes
            window.addEventListener('DOMContentLoaded', updateBannerOffset);
            window.addEventListener('resize', updateBannerOffset);
        </script>

        @stack('scripts')
</body>

</html>

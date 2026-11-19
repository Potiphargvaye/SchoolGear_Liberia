<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @php
        $seoTitle = trim($__env->yieldContent('title', 'SchoolGear Liberia'));
        $seoDescription = trim(
            $__env->yieldContent(
                'description',
                'SchoolGear Liberia is a school management platform helping schools simplify administration, manage academic information, and connect their school community through technology.',
            ),
        );
        $seoHost = preg_replace('/^www\./i', '', parse_url(config('app.url'), PHP_URL_HOST));
        $seoCanonical = trim($__env->yieldContent('canonical', 'https://' . $seoHost . request()->getPathInfo()));
        $seoRobots = trim($__env->yieldContent('robots', 'index, follow'));
        $seoOgImage = file_exists(public_path('schoolGear_liberia_public_site/img/og-share.jpg'))
            ? asset('schoolGear_liberia_public_site/img/og-share.jpg')
            : '';
    @endphp
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <link rel="canonical" href="{{ $seoCanonical }}">
    <meta name="robots" content="{{ $seoRobots }}">
    <meta property="og:title" content="@yield('og_title', $seoTitle)">
    <meta property="og:description" content="@yield('og_description', $seoDescription)">
    @if ($seoOgImage !== '')
        <meta property="og:image" content="{{ $seoOgImage }}">
    @endif
    <meta property="og:url" content="@yield('og_url', $seoCanonical)">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="SchoolGear Liberia">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', $seoTitle)">
    <meta name="twitter:description" content="@yield('twitter_description', $seoDescription)">
    @if ($seoOgImage !== '')
        <meta name="twitter:image" content="{{ $seoOgImage }}">
    @endif
    @stack('json-ld')

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
    <link rel="stylesheet"
        href="{{ asset('schoolGear_liberia_public_site/css/sg-nav.css') }}?v={{ @filemtime(public_path('schoolGear_liberia_public_site/css/sg-nav.css')) }}">
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/sg-cursor.css') }}">
    <script src="{{ asset('schoolGear_liberia_public_site/js/sg-cursor.js') }}" defer></script>

    <link rel="stylesheet"
        href="{{ asset('schoolGear_liberia_public_site/css/sg-cursor.css') }}?v={{ @filemtime(public_path('schoolGear_liberia_public_site/css/sg-cursor.css')) }}">
    <script
        src="{{ asset('schoolGear_liberia_public_site/js/sg-cursor.js') }}?v={{ @filemtime(public_path('schoolGear_liberia_public_site/js/sg-cursor.js')) }}"
        defer></script>
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
        <header class="main_menu home_menu sg-nav" data-sg-nav>
            <div class="sg-nav-bar">
                <div class="container">
                    <div class="sg-nav-inner">
                        <a class="sg-nav-brand" href="{{ url('/') }}" aria-label="SchoolGear Liberia home">
                            <img src="{{ asset('logo/download.png') }}" alt="SchoolGear Liberia logo"
                                class="sg-nav-logo">
                        </a>

                        <nav class="sg-nav-desktop-links" aria-label="Primary navigation">
                            <a class="sg-nav-link {{ request()->routeIs('home') ? 'is-active' : '' }}"
                                href="{{ url('/') }}">Home</a>
                            <a class="sg-nav-link {{ request()->is('about-us') ? 'is-active' : '' }}"
                                href="{{ url('/about-us') }}">About</a>
                            <a class="sg-nav-link {{ request()->routeIs('public.pricing') ? 'is-active' : '' }}"
                                href="{{ url('/pricing') }}">Pricing</a>
                            <a class="sg-nav-link {{ request()->is('contact-us') ? 'is-active' : '' }}"
                                href="{{ url('/contact-us') }}">Contact</a>
                        </nav>

                        <div class="sg-nav-desktop-actions">
                            <button type="button" class="sg-nav-search-trigger" data-sg-search-open hidden>
                                <i class="ti-search" aria-hidden="true"></i><span>Find your school</span>
                            </button>
                            <div class="sg-nav-signin-wrap" data-sg-signin-wrap>
                                <button type="button" class="sg-nav-signin-trigger" data-sg-signin-toggle
                                    aria-haspopup="true" aria-expanded="false">
                                    <span>Sign in</span><i class="ti-angle-down" aria-hidden="true"></i>
                                </button>
                                <div class="sg-nav-signin-panel" data-sg-signin-panel hidden>
                                    <a class="sg-nav-role-link"
                                        href="{{ route('login', ['role' => 'staff']) }}"><span
                                            class="sg-nav-role-icon"><i class="ti-briefcase"
                                                aria-hidden="true"></i></span><span><strong>Staff &amp;
                                                admins</strong><small>Manage your school</small></span></a>
                                    <a class="sg-nav-role-link"
                                        href="{{ route('login', ['role' => 'student']) }}"><span
                                            class="sg-nav-role-icon"><i class="ti-book"
                                                aria-hidden="true"></i></span><span><strong>Students</strong><small>Grades
                                                and attendance</small></span></a>
                                    <a class="sg-nav-role-link"
                                        href="{{ route('login', ['role' => 'parent']) }}"><span
                                            class="sg-nav-role-icon"><i class="ti-user"
                                                aria-hidden="true"></i></span><span><strong>Parents &amp;
                                                guardians</strong><small>Guardian access</small></span></a>
                                </div>
                            </div>
                            <a class="sg-nav-get-started" href="{{ route('public.register') }}">Get Started</a>
                        </div>

                        <div class="sg-nav-mobile-actions">
                            <button type="button" class="sg-nav-icon-button" data-sg-search-open hidden
                                aria-label="Find your school"><i class="ti-search" aria-hidden="true"></i></button>
                            <button type="button" class="sg-nav-menu-toggle" data-sg-menu-toggle
                                aria-controls="sg-nav-mobile-panel" aria-expanded="false"
                                aria-label="Open menu"><span></span><span></span><span></span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sg-nav-mobile-panel" id="sg-nav-mobile-panel" data-sg-mobile-panel hidden>
                <nav class="sg-nav-mobile-links" aria-label="Mobile navigation">
                    <a class="sg-nav-mobile-link {{ request()->routeIs('home') ? 'is-active' : '' }}"
                        href="{{ url('/') }}">Home</a>
                    <a class="sg-nav-mobile-link {{ request()->is('about-us') ? 'is-active' : '' }}"
                        href="{{ url('/about-us') }}">About</a>
                    <a class="sg-nav-mobile-link {{ request()->routeIs('public.pricing') ? 'is-active' : '' }}"
                        href="{{ url('/pricing') }}">Pricing</a>
                    <a class="sg-nav-mobile-link {{ request()->is('contact-us') ? 'is-active' : '' }}"
                        href="{{ url('/contact-us') }}">Contact</a>
                </nav>
                <p class="sg-nav-mobile-label">Sign in</p>
                <div class="sg-nav-mobile-roles">
                    <a class="sg-nav-role-link" href="{{ route('login', ['role' => 'staff']) }}"><span
                            class="sg-nav-role-icon"><i class="ti-briefcase"
                                aria-hidden="true"></i></span><span><strong>Staff &amp; admins</strong><small>Manage
                                your school</small></span></a>
                    <a class="sg-nav-role-link" href="{{ route('login', ['role' => 'student']) }}"><span
                            class="sg-nav-role-icon"><i class="ti-book"
                                aria-hidden="true"></i></span><span><strong>Students</strong><small>Grades and
                                attendance</small></span></a>
                    <a class="sg-nav-role-link" href="{{ route('login', ['role' => 'parent']) }}"><span
                            class="sg-nav-role-icon"><i class="ti-user"
                                aria-hidden="true"></i></span><span><strong>Parents &amp;
                                guardians</strong><small>Guardian access</small></span></a>
                </div>
                <a class="sg-nav-mobile-start" href="{{ route('public.register') }}">Get started</a>
            </div>

        </header>
        <!-- Header part end-->

        <div class="sg-nav sg-nav-modal-root">
            <div class="sg-nav-modal" data-sg-modal data-sg-search-endpoint="{{ route('public.schools.search') }}"
                hidden>
                <div class="sg-nav-modal-panel" role="dialog" aria-modal="true"
                    aria-labelledby="sg-nav-modal-title">
                    <div class="sg-nav-modal-header">
                        <h2 class="sg-nav-modal-title" id="sg-nav-modal-title">Find your school</h2>
                        <span class="sg-nav-modal-esc">ESC</span>
                        <button type="button" class="sg-nav-modal-close" data-sg-search-close
                            aria-label="Close school search"><i class="ti-close" aria-hidden="true"></i></button>
                    </div>
                    <div class="sg-nav-modal-body">
                        <label class="sr-only" for="sg-nav-search-input">Search for your school</label>
                        <div class="sg-nav-search-field">
                            <i class="ti-search" aria-hidden="true"></i>
                            <input class="sg-nav-search-input" id="sg-nav-search-input" data-sg-search-input
                                type="search" autocomplete="organization" maxlength="60"
                                placeholder="Search by school name">
                        </div>
                        <p class="sg-nav-search-state" data-sg-search-state="idle">Type your school's name</p>
                        <p class="sg-nav-search-state" data-sg-search-state="loading" hidden>Searching...</p>
                        <p class="sg-nav-search-state" data-sg-search-state="empty" hidden>No school found. Check the
                            spelling, or <a href="{{ url('/contact-us') }}">contact us</a> or <a
                                href="{{ url('/school-registration') }}">register your school</a>.</p>
                        <p class="sg-nav-search-state" data-sg-search-state="error" hidden>Search is unavailable.
                            Please try again.</p>
                        <div class="sg-nav-results" data-sg-results role="listbox"
                            aria-label="School search results"></div>
                    </div>
                </div>
            </div>
        </div>

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
                                <p><span>Address :</span> New Matadi, Opposite Don Bosco Youth Center, Monrovia, Liberia, West Africa</p>
                                <p><span>Phone :</span> <a href="tel:+231770123498">+231 77 012 3498</a></p>
                                <p><span>Email :</span> <a
                                        href="mailto:info@schoolgearliberia.com">info@schoolgearliberia.com</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-sm-6 col-md-4">
                        <div class="single-footer-widget footer_2">
                            <h4>Pages</h4>
                            <ul>
                                <li><a href="{{ url('/') }}">Home</a></li>
                                <li><a href="{{ url('/about-us') }}">About</a></li>
                                <li><a href="{{ url('/pricing') }}">Pricing</a></li>
                                <li><a href="{{ url('/contact-us') }}">Contact</a></li>
                            </ul>
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
        <script
            src="{{ asset('schoolGear_liberia_public_site/js/sg-nav.js') }}?v={{ @filemtime(public_path('schoolGear_liberia_public_site/js/sg-nav.js')) }}"
            defer></script>
</body>

</html>

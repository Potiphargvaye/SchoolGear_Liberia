@extends('public.layouts.public')

@section('title', 'Contact Us - New Matadi, Opposite Don-Bossco Youth-Center Monrovia, Liberia ')
@section('description', 'Contact Edmol MBHS for admissions, support, and inquiries.')
@section('canonical_url', 'https://www.edmolmbhs.com/contact-us')
@section('content')

    <body>
        <!-- Liberia Independence Day Banner -->
        <!-- ============================= -->
        <div class="lib-independence-banner">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center text-center py-2">
                    <span class="lib-flag-icon mr-2" aria-hidden="true">
                        <!-- Inline SVG Liberian Flag -->
                        <svg width="28" height="20" viewBox="0 0 28 20" xmlns="http://www.w3.org/2000/svg">
                            <rect width="28" height="20" fill="#fff" />
                            <g fill="#BF0A30">
                                <rect y="0" width="28" height="1.82" />
                                <rect y="3.64" width="28" height="1.82" />
                                <rect y="7.27" width="28" height="1.82" />
                                <rect y="10.9" width="28" height="1.82" />
                                <rect y="14.5" width="28" height="1.82" />
                                <rect y="18.2" width="28" height="1.82" />
                            </g>
                            <rect width="11" height="10.9" fill="#002868" />
                            <polygon points="5.5,2 6.3,4.3 8.7,4.3 6.7,5.7 7.4,8 5.5,6.6 3.6,8 4.3,5.7 2.3,4.3 4.7,4.3"
                                fill="#fff" />
                        </svg>
                    </span>
                    <span class="lib-banner-text">
                        🇱🇷 Happy Independence Day, Liberia! Wishing our students, staff, and the entire Edmol family
                        a joyful <strong>July 26th</strong> celebrating <strong>179 years of independence</strong>.
                    </span>
                </div>
            </div>
        </div>
        <div class="py-2 bg-primary" style="background-color:#0a2a66 !important;">
            <div class="container">
                <div class="row no-gutters d-flex align-items-start align-items-center px-3 px-md-0">
                    <div class="col-lg-12 d-block">
                        <div class="row d-flex">
                            <div class="col-md-5 pr-4 d-flex topper align-items-center">
                                <div class="icon bg-fifth mr-2 d-flex justify-content-center align-items-center"><span
                                        class="icon-map"></span></div>
                                <span class="text">New Matadi, Opposite Don-Bossco Youth-Center Monrovia, Liberia West
                                    Africa </span>
                            </div>
                            <div class="col-md pr-4 d-flex topper align-items-center">
                                <div class="icon bg-secondary mr-2 d-flex justify-content-center align-items-center"><span
                                        class="icon-paper-plane"></span></div>
                                <span class="text">emmmbhs@gmail.com</span>
                            </div>
                            <div class="col-md pr-4 d-flex topper align-items-center">
                                <div class="icon bg-tertiary mr-2 d-flex justify-content-center align-items-center"><span
                                        class="icon-phone2"></span></div>
                                <span class="text">+231555472972 / +231776597201</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-white ftco_navbar ftco-navbar-light" id="ftco-navbar">
            <div class="container d-flex align-items-center">
                <a class="navbar-brand" href="{{ url('/') }}">Edmol Baptist School</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                    aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="oi oi-menu"></span> Menu
                </button>
                <div class="collapse navbar-collapse" id="ftco-nav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a href="{{ url('/') }}" class="nav-link pl-0">Home</a>
                        </li>
                        <li class="nav-item"><a href="{{ url('/about-us') }}" class="nav-link">About Us</a></li>
                        <li class="nav-item"><a href="{{ url('/teachers') }}" class="nav-link">Teacher</a></li>
                        <li class="nav-item"><a href="{{ url('/courses') }}" class="nav-link">Courses</a></li>
                        <li class="nav-item"><a href="{{ url('/fees-structure') }}" class="nav-link">Fees-structure</a></li>
                        <li class="nav-item"><a href="{{ url('/blog') }}" class="nav-link">Blog</a></li>
                        <li class="nav-item"><a href="{{ url('/contact-us') }}" class="nav-link">Contact-Us</a></li>
                        <li class="nav-item ml-lg-4">
                            <a href="{{ route('login') }}" class="nav-link login-ghost" id="loginBtn">
                                <span class="login-text">Login to Portal</span>
                                <span class="login-arrow">→</span>
                                <span class="login-spinner" style="display:none;"></span> <!-- CSS spinner -->
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- END nav -->
        <div class="contact-page-wrapper">

            <section class="hero-wrap hero-wrap-2"
                style="background-image: url('{{ asset('kiddos-school-master/images/class-room-teacher-image.jpg') }}');">

                <div class="overlay"></div>
                <div class="container">
                    <div class="row no-gutters slider-text align-items-center justify-content-center">
                        <div class="col-md-9 ftco-animate text-center">
                            <h1 class="mb-2 bread">Contact Us</h1>
                            <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/') }}">Home <i
                                            class="ion-ios-arrow-forward"></i></a></span> <span>Contact <i
                                        class="ion-ios-arrow-forward"></i></span></p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="ftco-section contact-section">
                <div class="container">
                    <div class="row d-flex mb-5 contact-info">

                        <div class="col-md-3 d-flex">
                            <div class="bg-light align-self-stretch box p-4 text-center">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <h3 class="mb-4">Address</h3>
                                <p>New Matadi, Opposite Don-Bossco Youth-Center Monrovia, Liberia</p>
                            </div>
                        </div>

                        <div class="col-md-3 d-flex">
                            <div class="bg-light align-self-stretch box p-4 text-center">
                                <div class="contact-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <h3 class="mb-4">Contact Number</h3>
                                <p><a href="tel://231555472972">+231 555472972</a></p>
                                <p><a href="tel://231776597201">+231 776597201</a></p>
                            </div>
                        </div>

                        <div class="col-md-3 d-flex">
                            <div class="bg-light align-self-stretch box p-4 text-center">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h3 class="mb-4">Email Address</h3>
                                <p><a href="mailto:info@yoursite.com">emmmbhs@gmail.com</a></p>
                            </div>
                        </div>

                        <div class="col-md-3 d-flex">
                            <div class="bg-light align-self-stretch box p-4 text-center">
                                <div class="contact-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <h3 class="mb-4">Website</h3>
                                <p><a href="https://www.edmolmbhs.com">www.edmolmbhs.com</a></p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <section class="ftco-section ftco-no-pt ftco-no-pb contact-section">
                <div class="container">
                    <div class="row d-flex align-items-stretch no-gutters">
                        <div class="col-md-6 p-4 p-md-5 order-md-last bg-light">
                            <form action="#">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Name">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Email">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Subject">
                                </div>
                                <div class="form-group">
                                    <textarea name="" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 d-flex align-items-stretch">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </section>


            <footer class="ftco-footer ftco-bg-dark ftco-section">
                <div class="container">
                    <div class="row mb-5">
                        <div class="col-md-6 col-lg-3">
                            <div class="ftco-footer-widget mb-5">
                                <h2 class="ftco-heading-2">Have a Questions?</h2>
                                <div class="block-23 mb-3">
                                    <ul>
                                        <li><span class="icon icon-map-marker"></span><span class="text">New Matadi,
                                                Opposite Don-Bossco Youth-Center Monrovia, Liberia </span></li>
                                        <li><a href="#"><span class="icon icon-phone"></span><span
                                                    class="text">+231555472972 / +231776597201</span></a></li>
                                        <li><a href="#"><span class="icon icon-envelope"></span><span
                                                    class="text">emmmbhs@gmail.com</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="ftco-footer-widget mb-5">
                                <h2 class="ftco-heading-2">Recent Blog</h2>
                                <div class="block-21 mb-4 d-flex">
                                    <a class="blog-img mr-4"
                                        style="background-image: url('{{ asset('kiddos-school-master/images/blog_post3.jpg') }}');"></a>
                                    <div class="text">
                                        <h3 class="heading"><a href="#">Even the all-powerful Pointing has no
                                                control about</a></h3>
                                        <div class="meta">
                                            <div><a href="#"><span class="icon-calendar"></span> Dec 25, 2018</a>
                                            </div>
                                            <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                                            <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-21 mb-5 d-flex">
                                    <a class="blog-img mr-4"
                                        style="background-image: url('{{ asset('kiddos-school-master/images/blog_post2.jpg') }}');"></a>
                                    <div class="text">
                                        <h3 class="heading"><a href="#">Even the all-powerful Pointing has no
                                                control about</a></h3>
                                        <div class="meta">
                                            <div><a href="#"><span class="icon-calendar"></span> Dec 25, 2018</a>
                                            </div>
                                            <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                                            <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="ftco-footer-widget mb-5 ml-md-4">
                                <h2 class="ftco-heading-2">Links</h2>
                                <ul class="list-unstyled">
                                    <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Home</a>
                                    </li>
                                    <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>About</a>
                                    </li>
                                    <li><a href="#"><span
                                                class="ion-ios-arrow-round-forward mr-2"></span>Services</a></li>
                                    <li><a href="#"><span
                                                class="ion-ios-arrow-round-forward mr-2"></span>Deparments</a></li>
                                    <li><a href="#"><span
                                                class="ion-ios-arrow-round-forward mr-2"></span>Contact</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="ftco-footer-widget mb-5">
                                <h2 class="ftco-heading-2">Subscribe Us!</h2>
                                <form action="#" class="subscribe-form">
                                    <div class="form-group">
                                        <input type="text" class="form-control mb-2 text-center"
                                            placeholder="Enter email address">
                                        <input type="submit" value="Subscribe" class="form-control submit px-3">
                                    </div>
                                </form>
                            </div>
                            <div class="ftco-footer-widget mb-5">
                                <h2 class="ftco-heading-2 mb-0">Connect With Us</h2>
                                <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-3">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p style="color:#bec8d1;">
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                Copyright &copy;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                All rights reserved | Edmol-Baptish-School
                                <span style="margin:0 5px;">🎓</span>
                                Developed by:<a href="https://potiphargvaye.gt.tc" target="_blank"
                                    style="color:#001f3f; text-decoration:none;">
                                    Potiphar G Vaye
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
        </div>
        </footer>



        <!-- loader -->
        <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
                <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                    stroke="#eeeeee" />
                <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                    stroke-miterlimit="10" stroke="#F96D00" />
            </svg></div>
        <!-- WhatsApp Floating Button -->
        <a href="https://wa.me/250794241623" target="_blank" class="whatsapp-float" aria-label="Message us on WhatsApp">
            <i class="fab fa-whatsapp"></i>
            <span class="whatsapp-tooltip">Message us on WhatsApp</span>
        </a>

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery-migrate-3.0.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.easing.1.3.js"></script>
        <script src="js/jquery.waypoints.min.js"></script>
        <script src="js/jquery.stellar.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/jquery.magnific-popup.min.js"></script>
        <script src="js/aos.js"></script>
        <script src="js/jquery.animateNumber.min.js"></script>
        <script src="js/scrollax.min.js"></script>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> <!-- Map script -->
        <script src="js/main.js"></script>


        <script>
            document.addEventListener("DOMContentLoaded", function() {

                /* 📍 School Location */
                const schoolLat = 6.3202;
                const schoolLng = -10.8016;

                /* 🗺️ Initialize Map */
                const map = L.map("map", {
                    center: [schoolLat, schoolLng],
                    zoom: 15,
                    scrollWheelZoom: false // UX: prevent accidental zoom
                });

                map.on("click", function() {
                    map.scrollWheelZoom.enable();
                });

                map.on("mouseout", function() {
                    map.scrollWheelZoom.disable();
                });

                /* 🌍 Street Map (Default) */
                const streetMap = L.tileLayer(
                    "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                        attribution: "&copy; OpenStreetMap contributors"
                    }
                );

                /* 🛰️ Satellite Map */
                const satelliteMap = L.tileLayer(
                    "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
                        attribution: "Tiles &copy; Esri"
                    }
                );

                /* ✅ Load default map */
                streetMap.addTo(map);

                /* 🔀 Layer Switch Control */
                const baseMaps = {
                    "Street View": streetMap,
                    "Satellite View": satelliteMap
                };

                L.control.layers(baseMaps, null, {
                    position: "topright"
                }).addTo(map);

                /* 📌 Marker */
                const marker = L.marker([schoolLat, schoolLng]).addTo(map);

                marker.bindPopup(`
      <strong>New Matadi Baptist School</strong><br>
      Monrovia, Liberia<br><br>
      <a href="https://www.google.com/maps?q=${schoolLat},${schoolLng}" 
         target="_blank"
         style="color:#0a2a66;font-weight:600;">
         📍 Get Directions
      </a>
    `).openPopup();

            });

            // ==== Redirecting state script =====

            document.addEventListener("DOMContentLoaded", function() {
                const loginBtn = document.getElementById("loginBtn");
                const loginText = loginBtn.querySelector(".login-text");
                const loginArrow = loginBtn.querySelector(".login-arrow");
                const loginSpinner = loginBtn.querySelector(".login-spinner");

                // Reset button state on page load
                function resetLoginButton() {
                    loginText.textContent = "Login to Portal";
                    loginArrow.style.display = "inline-block";
                    loginSpinner.style.display = "none";
                    loginBtn.style.pointerEvents = "auto";
                }

                resetLoginButton(); // run immediately on load

                loginBtn.addEventListener("click", function(e) {
                    e.preventDefault(); // prevent immediate redirect

                    // Disable button so user can't click again
                    loginBtn.style.pointerEvents = "none";

                    // Change text and show spinner
                    loginText.textContent = "Redirecting...";
                    loginSpinner.style.display = "inline-block";
                    loginArrow.style.display = "none";

                    // Optional: Add spinning animation with CSS
                    loginSpinner.style.animation = "spin 1s linear infinite";

                    // Wait 8 seconds then redirect
                    setTimeout(function() {
                        window.location.href = loginBtn.href; // go to login page
                    }, 3000);
                });

                // Optional: reset if user navigates back via browser history
                window.addEventListener("pageshow", function(event) {
                    if (event.persisted) {
                        resetLoginButton();
                    }
                });
            });
        </script>

    </body>


@endsection

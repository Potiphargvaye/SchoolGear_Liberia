@extends('public.layouts.public')

@section('title', 'About Us - Edmol MBHS Monrovia, Liberia')
@section('description', 'Learn about Edmol MBHS history, mission, and academic programs.')
@section('canonical_url', 'https://www.edmolmbhs.com/about-us')

@section('content')

    <!-- ABOUT PAGE CONTENT GOES HERE -->

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
        <div class="about-page">
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
                                    <div class="icon bg-secondary mr-2 d-flex justify-content-center align-items-center">
                                        <span class="icon-paper-plane"></span>
                                    </div>
                                    <span class="text">emmmbhs@gmail.com</span>
                                </div>
                                <div class="col-md pr-4 d-flex topper align-items-center">
                                    <div class="icon bg-tertiary mr-2 d-flex justify-content-center align-items-center">
                                        <span class="icon-phone2"></span>
                                    </div>
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
                            <li class="nav-item"><a href="{{ url('/fees-structure') }}" class="nav-link">Fees-structure</a>
                            </li>
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

            <section class="hero-wrap hero-wrap-2"
                style="background-image: url('{{ asset('kiddos-school-master/images/about_us_student_image (1).jpg') }}');">

                <div class="overlay"></div>
                <div class="container">
                    <div class="row no-gutters slider-text align-items-center justify-content-center">
                        <div class="col-md-9 ftco-animate text-center">
                            <h1 class="mb-2 bread">About Us</h1>
                            <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/') }}">Home <i
                                            class="ion-ios-arrow-forward"></i></a></span> <span>About us <i
                                        class="ion-ios-arrow-forward"></i></span></p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="ftco-section bg-light">
                <div class="container">

                    <!-- Image Card -->
                    <div class="row justify-content-center mb-5">
                        <div class="col-md-8 text-center">
                            <div class="img img-2 d-flex align-items-center justify-content-center"
                                style="background-image: url('{{ asset('logo/edmol-orginal-logo.png') }}'); 
                 height: 350px; 
                 border-radius: 12px;
                 box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                            </div>
                        </div>
                    </div>

                    <!-- Text Content -->
                    <div class="row justify-content-center">
                        <div class="col-md-10 text-center">

                            <h2 class="mb-4">
                                <span>About</span> Edmol Baptist School
                            </h2>

                            <p class="mb-4">
                                Founded in 1994, Edmol Baptist School was established with a clear mission:
                                to provide Christ-centered education that nurtures academic excellence,
                                moral discipline, and leadership development. Over the years, the school
                                has grown into a trusted institution committed to shaping young minds
                                for both intellectual and spiritual success.
                            </p>

                            <a href="{{ asset('storage/documents/GraduationProgram.pdf') }}"
                                class="btn btn-primary px-4 py-3" target="_blank">
                                View School History (PDF)
                            </a>


                        </div>
                    </div>

                </div>
            </section>


            <!-- ======Mission & Vission========= -->
            <section class="ftco-section">
                <div class="container">

                    <div class="row justify-content-center mb-5">
                        <div class="col-md-8 text-center heading-section ftco-animate">
                            <h2 class="mb-4"><span>Our</span> Mission & Vision</h2>
                            <p>Guided by strong values, we remain committed to nurturing learners who excel academically,
                                morally, and socially.</p>
                        </div>
                    </div>

                    <div class="row">

                        <!-- Mission -->
                        <div class="col-md-6 d-flex ftco-animate">
                            <div class="media block-6 d-flex">
                                <div class="icon d-flex align-items-center justify-content-center mr-4">
                                    <span class="flaticon-teacher"></span>
                                </div>
                                <div class="media-body">
                                    <h3 class="heading">Our Mission</h3>
                                    <p>
                                        To provide quality, Christ-centered education that develops intellectual
                                        excellence, moral integrity, and leadership skills in every learner.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Vision -->
                        <div class="col-md-6 d-flex ftco-animate">
                            <div class="media block-6 d-flex">
                                <div class="icon d-flex align-items-center justify-content-center mr-4">
                                    <span class="flaticon-books"></span>
                                </div>
                                <div class="media-body">
                                    <h3 class="heading">Our Vision</h3>
                                    <p>
                                        To be a leading academic institution recognized for producing disciplined,
                                        knowledgeable, and God-fearing leaders who positively impact society.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </section>

            <!-- ===our corde value section====  -->

            <section class="ftco-section bg-light">
                <div class="container">

                    <div class="row justify-content-center mb-5">
                        <div class="col-md-8 text-center heading-section ftco-animate">
                            <h2 class="mb-4"><span>Our</span> Core Values</h2>
                            <p>These principles guide our teaching, leadership, and student development.</p>
                        </div>
                    </div>

                    <div class="row">

                        <!-- Value 1 -->
                        <div class="col-md-3 text-center ftco-animate">
                            <div class="core-value">
                                <span class="icon flaticon-books"></span>
                                <h3>Academic Excellence</h3>
                                <p>We pursue high standards in learning, teaching, and performance.</p>
                            </div>
                        </div>

                        <!-- Value 2 -->
                        <div class="col-md-3 text-center ftco-animate">
                            <div class="core-value">
                                <span class="icon flaticon-teacher"></span>
                                <h3>Integrity</h3>
                                <p>We uphold honesty, discipline, and strong moral character.</p>
                            </div>
                        </div>

                        <!-- Value 3 -->
                        <div class="col-md-3 text-center ftco-animate">
                            <div class="core-value">
                                <span class="icon flaticon-kids"></span>
                                <h3>Respect & Care</h3>
                                <p>We foster love, respect, and responsibility within our community.</p>
                            </div>
                        </div>

                        <!-- Value 4 -->
                        <div class="col-md-3 text-center ftco-animate">
                            <div class="core-value">
                                <span class="icon flaticon-diploma"></span>
                                <h3>Leadership</h3>
                                <p>We prepare learners to lead with confidence and purpose.</p>
                            </div>
                        </div>

                    </div>

                </div>
            </section>


            <!-- ===== Principal / Head Teacher Message ===== -->
            <section class="ftco-section ftco-no-pt ftco-no-pb bg-light">
                <div class="container">
                    <div class="row align-items-center">

                        <!-- Image -->
                        <div class="col-md-6 ftco-animate">
                            <div class="teacher-img"
                                style="background-image: url({{ asset('kiddos-school-master/images/Principal_image.jpg') }}); height: 400px; background-size: cover; background-position: center;">
                            </div>
                        </div>

                        <!-- Text -->
                        <div class="col-md-6 ftco-animate">
                            <div class="text px-4">
                                <h2><span>Message from</span> Our Principal</h2>
                                <p>
                                <p style="color: black ">PST. PHILIP W. DAVIS</p>Welcome to Edmol Baptist School! Our
                                commitment is to provide every student
                                with a nurturing environment where academic excellence, moral integrity,
                                and leadership development thrive. We strive to inspire young minds to
                                become responsible, God-fearing leaders of tomorrow.
                                </p>
                                <a href="#" class="btn btn-primary mt-3">Read More...</a>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <!-- ===== Our Educational Philosophy ===== -->
            <section class="ftco-section bg-light">
                <div class="container">

                    <div class="row justify-content-center mb-4">
                        <div class="col-md-8 text-center heading-section ftco-animate">
                            <h2 class="mb-4"><span>Our</span> Educational Philosophy</h2>
                            <p>
                                At Edmol Baptist School, education goes beyond the classroom.
                                We focus on developing the whole child — academically, morally, and socially.
                            </p>
                        </div>
                    </div>

                    <div class="row">

                        <!-- Pillar 1 -->
                        <div class="col-md-4 text-center ftco-animate">
                            <div class="approach-box p-4">
                                <span class="icon flaticon-books"></span>
                                <h3>Strong Academics</h3>
                                <p>
                                    We deliver a well-structured curriculum that promotes critical thinking,
                                    creativity, and lifelong learning.
                                </p>
                            </div>
                        </div>

                        <!-- Pillar 2 -->
                        <div class="col-md-4 text-center ftco-animate">
                            <div class="approach-box p-4">
                                <span class="icon flaticon-teacher"></span>
                                <h3>Character Development</h3>
                                <p>
                                    We emphasize discipline, integrity, and Christian values
                                    to shape responsible and respectful individuals.
                                </p>
                            </div>
                        </div>

                        <!-- Pillar 3 -->
                        <div class="col-md-4 text-center ftco-animate">
                            <div class="approach-box p-4">
                                <span class="icon flaticon-diploma"></span>
                                <h3>Leadership & Service</h3>
                                <p>
                                    Our students are encouraged to lead with confidence,
                                    serve their communities, and positively impact society.
                                </p>
                            </div>
                        </div>

                    </div>

                </div>
            </section>

            <!-- Parents Testimony -->
            <section class="ftco-section testimony-section bg-light">
                <div class="container">
                    <div class="row justify-content-center mb-5 pb-2">
                        <div class="col-md-8 text-center heading-section ftco-animate">
                            <span class="subheading">Testimonial</span>
                            <h2 class="mb-4"><span>What Parents</span> Says About Us</h2>
                            <p>Separated they live in. A small river named Duden flows by their place and supplies it with
                                the necessary regelialia. It is a paradisematic country</p>
                        </div>
                    </div>
                    <div class="row ftco-animate justify-content-center">
                        <div class="col-md-12">
                            <div class="carousel-testimony owl-carousel">

                                <div class="item">
                                    <div class="testimony-wrap d-flex">
                                        <div class="user-img mr-4"
                                            style="background-image: url('{{ asset('kiddos-school-master/images/parent_image1.jpg') }}')">
                                        </div>
                                        <div class="text ml-2 bg-light">
                                            <span class="quote d-flex align-items-center justify-content-center">
                                                <i class="icon-quote-left"></i>
                                            </span>
                                            <p>Edmol Baptist School has given my daughter a safe and inspiring environment
                                                to grow academically and spiritually.</p>
                                            <p class="name">Mrs. Ayesha Gbollie</p>
                                            <span class="position">Mother</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="testimony-wrap d-flex">
                                        <div class="user-img mr-4"
                                            style="background-image: url('{{ asset('kiddos-school-master/images/parent_image3.jpeg') }}')">
                                        </div>
                                        <div class="text ml-2 bg-light">
                                            <span class="quote d-flex align-items-center justify-content-center">
                                                <i class="icon-quote-left"></i>
                                            </span>
                                            <p>The teachers are dedicated, and my son’s confidence and skills have improved
                                                tremendously since joining the school.</p>
                                            <p class="name">Mr. Emmanuel Kollie</p>
                                            <span class="position">Father</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="testimony-wrap d-flex">
                                        <div class="user-img mr-4"
                                            style="background-image: url('{{ asset('logo/edmol-orginal-logo.png') }}')">
                                        </div>
                                        <div class="text ml-2 bg-light">
                                            <span class="quote d-flex align-items-center justify-content-center">
                                                <i class="icon-quote-left"></i>
                                            </span>
                                            <p>I love the focus on both education and character development. My child is
                                                learning so much beyond textbooks.</p>
                                            <p class="name">Mrs. Fatmata Johnson</p>
                                            <span class="position">Mother</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="testimony-wrap d-flex">
                                        <div class="user-img mr-4"
                                            style="background-image: url('{{ asset('kiddos-school-master/images/parent_image1.jpg') }}')">
                                        </div>
                                        <div class="text ml-2 bg-light">
                                            <span class="quote d-flex align-items-center justify-content-center">
                                                <i class="icon-quote-left"></i>
                                            </span>
                                            <p>Edmol Baptist School is more than a school; it’s a community that nurtures
                                                excellence and discipline..</p>
                                            <p class="name">Mr. George Toe</p>
                                            <span class="position">Father</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="testimony-wrap d-flex">
                                        <div class="user-img mr-4"
                                            style="background-image: url('{{ asset('logo/edmol-orginal-logo.png') }}')">
                                        </div>
                                        <div class="text ml-2 bg-light">
                                            <span class="quote d-flex align-items-center justify-content-center">
                                                <i class="icon-quote-left"></i>
                                            </span>
                                            <p>From academics to sports, my child enjoys every moment here and is thriving
                                                in all aspects.</p>
                                            <p class="name">Ken Bosh</p>
                                            <span class="position">Mother</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="ftco-section ftco-consult ftco-no-pt ftco-no-pb"
                style="background-image: url('{{ asset('logo/edmol-orginal-logo.png') }}');"
                data-stellar-background-ratio="0.5">

                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-md-6 py-5 px-md-5 bg-primary">
                            <div class="heading-section heading-section-white ftco-animate mb-5">
                                <span class="subheading">Register Now!</span>
                                <h2 class="mb-4">Request A Quote</h2>
                                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                                    there live the blind texts.</p>
                            </div>
                            <form action="#" class="appointment-form ftco-animate">
                                <div class="d-md-flex">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="First Name">
                                    </div>
                                    <div class="form-group ml-md-4">
                                        <input type="text" class="form-control" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="d-md-flex">
                                    <div class="form-group">
                                        <div class="form-field">
                                            <div class="select-wrap">
                                                <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                                <select name="" id="" class="form-control">
                                                    <option value="">Select Your Course</option>
                                                    <option value="">Art Lesson</option>
                                                    <option value="">Language Lesson</option>
                                                    <option value="">Music Lesson</option>
                                                    <option value="">Sports</option>
                                                    <option value="">Other Services</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ml-md-4">
                                        <input type="text" class="form-control" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="d-md-flex">
                                    <div class="form-group">
                                        <textarea name="" id="" cols="30" rows="2" class="form-control" placeholder="Message"></textarea>
                                    </div>
                                    <div class="form-group ml-md-4">
                                        <input type="submit" value="Request A Quote"
                                            class="btn btn-secondary py-3 px-4">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>


            <section class="ftco-gallery">
                <div class="container-wrap">
                    <div class="row no-gutters">
                        <div class="col-md-3 ftco-animate">
                            <a href="{{ asset('kiddos-school-master/images/blog_post1.jpg') }}"
                                class="gallery image-popup img d-flex align-items-center"
                                style="background-image: url('{{ asset('kiddos-school-master/images/blog_post1.jpg') }}');">

                                <div class="icon mb-4 d-flex align-items-center justify-content-center">
                                    <span class="icon-instagram"></span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 ftco-animate">
                            <a href="{{ asset('kiddos-school-master/images/blog_post2.jpg') }}"
                                class="gallery image-popup img d-flex align-items-center"
                                style="background-image: url('{{ asset('kiddos-school-master/images/blog_post2.jpg') }}');">

                                <div class="icon mb-4 d-flex align-items-center justify-content-center">
                                    <span class="icon-instagram"></span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 ftco-animate">
                            <a href="{{ asset('kiddos-school-master/images/blog_post3.jpg') }}"
                                class="gallery image-popup img d-flex align-items-center"
                                style="background-image: url('{{ asset('kiddos-school-master/images/blog_post3.jpg') }}');">

                                <div class="icon mb-4 d-flex align-items-center justify-content-center">
                                    <span class="icon-instagram"></span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 ftco-animate">
                            <a href="{{ asset('kiddos-school-master/images/blog_post1.jpg') }}"
                                class="gallery image-popup img d-flex align-items-center"
                                style="background-image: url('{{ asset('kiddos-school-master/images/blog_post1.jpg') }}');">

                                <div class="icon mb-4 d-flex align-items-center justify-content-center">
                                    <span class="icon-instagram"></span>
                                </div>
                            </a>
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
                                    <li><a href="{{ url('/') }}"><span
                                                class="ion-ios-arrow-round-forward mr-2"></span>Home</a></li>
                                    <li><a href="{{ url('/about-us') }}"><span
                                                class="ion-ios-arrow-round-forward mr-2"></span>About</a></li>
                                    <li><a href="{{ url('/courses') }}"><span
                                                class="ion-ios-arrow-round-forward mr-2"></span>Special-Courses</a></li>
                                    <li><a href="{{ url('/fees-structure') }}"><span
                                                class="ion-ios-arrow-round-forward mr-2"></span>Fees-Structure</a></li>
                                    <li><a href="{{ url('/contact') }}"><span
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

        <script scr="js/redirecting-state.js"></script>
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
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
        <script src="js/google-map.js"></script>
        <script src="js/main.js"></script>

        <script>
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

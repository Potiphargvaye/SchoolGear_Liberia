@extends('public.layouts.public')

@section('title', 'Welcome to ED-Mol Memorial Matadi Baptist High School Monrovia, Liberia ')
@section('description', 'Welcome to Edmol MBHS official website. Explore announcements, teachers, and school updates.')
@section('canonical_url', 'https://www.edmolmbhs.com/index')

@section('content')

    <!-- PASTE the <body> content of index.html HERE -->
    <!-- ============================= -->
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
                            <span class="text">New Matadi, Opposite Don-Bossco Youth-Center Monrovia, Liberia West Africa
                            </span>
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
    <!-- END nav slioder background  -->

    <section class="home-slider owl-carousel">
        <div class="slider-item"
            style="background-image: url('{{ asset('kiddos-school-master/images/student_image1.jpeg') }}');">

            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text align-items-center justify-content-center"
                    data-scrollax-parent="true">
                    <div class="col-md-8 text-center ftco-animate">

                        <h1 class="mb-4">Welcome to <span>Edmol Baptist School</span></h1>
                        <h2 class="mb-3">Where Faith, Excellence, and Leadership Meet</h2>
                        <p><a href="{{ url('/registeration-form') }}" class="btn btn-secondary px-4 py-3 mt-3">Register
                                Now!</a></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="slider-item"
            style="background-image: url('{{ asset('kiddos-school-master/images/student_image2.jpeg') }}');">

            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text align-items-center justify-content-center"
                    data-scrollax-parent="true">
                    <div class="col-md-8 text-center ftco-animate">
                        <h1 class="mb-4">Building Bright Minds <span>Rooted in Faith</span></h1>
                        <p><a href="{{ url('/registeration-form') }}" class="btn btn-secondary px-4 py-3 mt-3">Register
                                Now!</a></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="slider-item"
            style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo.png') }}');">

            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text align-items-center justify-content-center"
                    data-scrollax-parent="true">
                    <div class="col-md-8 text-center ftco-animate">
                        <h1 class="mb-4">A Safe Haven <span>For Every Child</span></h1>
                        <p><a href="{{ url('/registeration-form') }}" class="btn btn-secondary px-4 py-3 mt-3">Register
                                Now!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= -->
    <!-- School Announcements Section  -->
    <!-- ============================= -->
    <section class="ftco-announcement py-5" style="background-color:#f4f6fa;">
        <div class="container">

            <div class="row justify-content-center mb-4">
                <div class="col-md-8 text-center ftco-animate">
                    <span class="badge badge-pill"
                        style="background-color:#0a2a66; color:#fff; padding:8px 18px; font-size:14px; letter-spacing:1px;">
                        ANNOUNCEMENTS
                    </span>
                    <h2 class="mt-3 mb-2" style="color:#0a2a66; font-weight:700;">2026 – 2027 Academic Year</h2>
                    <p class="text-muted">Important updates for parents, guardians, and students ahead of the new school
                        year.</p>
                </div>
            </div>

            <div class="row no-gutters">

                <!-- Official Opening -->
                <div class="col-md-6 col-lg-4 d-flex align-self-stretch p-2 announcement-col">
                    <div
                        class="media block-6 d-block text-center bg-primary text-white p-4 rounded shadow-sm w-100 announcement-card">
                        <div class="icon d-flex justify-content-center align-items-center mb-3">
                            <span class="icon-calendar" style="font-size:2rem;"></span>
                        </div>
                        <div class="media-body">
                            <h4 class="heading">Official Opening – 2026/2027</h4>
                            <p class="mb-0">
                                Ed-Mol Memorial Matadi Baptist High School will officially open the
                                <strong>2026–2027 Academic Year on Monday, September 7, 2026.</strong>
                                All students should report to the New Matadi campus, opposite Don Bosco Youth Center.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Registration Open -->
                <div class="col-md-6 col-lg-4 d-flex align-self-stretch p-2 announcement-col">
                    <div
                        class="media block-6 d-block text-center bg-secondary text-white p-4 rounded shadow-sm w-100 announcement-card">
                        <div class="icon d-flex justify-content-center align-items-center mb-3">
                            <span class="icon-edit" style="font-size:2rem;"></span>
                        </div>
                        <div class="media-body">
                            <h4 class="heading">Registration Now Open</h4>
                            <p class="mb-0">
                                Registration for new and returning students runs
                                <strong>July 27 – September 4, 2026.</strong>
                                Visit the Registrar's Office on campus to begin the admission process.
                            </p>
                            <a href="{{ url('/registeration-form') }}" class="btn btn-light btn-sm mt-3">Register Now</a>
                        </div>
                    </div>
                </div>

                <!-- Fees Structure -->
                <div class="col-md-6 col-lg-4 d-flex align-self-stretch p-2 announcement-col">
                    <div
                        class="media block-6 d-block text-center bg-tertiary text-white p-4 rounded shadow-sm w-100 announcement-card">
                        <div class="icon d-flex justify-content-center align-items-center mb-3">
                            <span class="icon-credit-card" style="font-size:2rem;"></span>
                        </div>
                        <div class="media-body">
                            <h4 class="heading">Tuition &amp; Fees</h4>
                            <p class="mb-0">
                                Parents, guardians, and visitors are encouraged to review the
                                <strong>Fees Structure</strong> page for full details on tuition,
                                entrance fees, and payment deadlines for the new academic year.
                            </p>
                            <a href="{{ url('/fees-structure') }}" class="btn btn-light btn-sm mt-3">View Fees
                                Structure</a>
                        </div>
                    </div>
                </div>

                <!-- Grade 12 Notice -->
                <div class="col-md-6 col-lg-4 d-flex align-self-stretch p-2 announcement-col">
                    <div
                        class="media block-6 d-block text-center bg-fifth text-white p-4 rounded shadow-sm w-100 announcement-card">
                        <div class="icon d-flex justify-content-center align-items-center mb-3">
                            <span class="icon-graduation-cap" style="font-size:2rem;"></span>
                        </div>
                        <div class="media-body">
                            <h4 class="heading">Notice: Grade 12 Students</h4>
                            <p class="mb-0">
                                <strong>Special notice to all Grade 12 students:</strong> classes will
                                begin in <strong>August 2026</strong>, ahead of the general school
                                opening, to allow adequate preparation time.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Student Portal Launch -->
                <div class="col-md-6 col-lg-4 d-flex align-self-stretch p-2 announcement-col">
                    <div
                        class="media block-6 d-block text-center bg-quarternary text-white p-4 rounded shadow-sm w-100 announcement-card">
                        <div class="icon d-flex justify-content-center align-items-center mb-3">
                            <span class="icon-laptop" style="font-size:2rem;"></span>
                        </div>
                        <div class="media-body">
                            <h4 class="heading">Student Portal &amp; Admin System</h4>
                            <p class="mb-0">
                                We are proud to announce the grand launch of our official
                                <strong>Student Portal and Admin Management System</strong>, now used
                                for student records and school administration.
                            </p>
                            <a href="{{ route('login') }}" class="btn btn-light btn-sm mt-3">Login to Portal</a>
                        </div>
                    </div>
                </div>

                <!-- Orientation / Classes Begin -->
                <!-- Key Dates (expanded) -->
                <div class="col-md-6 col-lg-4 d-flex align-self-stretch p-2 ftco-animate announcement-col">
                    <div class="media block-6 d-block text-center p-4 rounded shadow-sm w-100 announcement-card"
                        style="background-color:#0a2a66; color:#fff;">
                        <div class="icon d-flex justify-content-center align-items-center mb-3">
                            <span class="icon-clock" style="font-size:2rem;"></span>
                        </div>
                        <div class="media-body">
                            <h4 class="heading">Key Dates to Remember</h4>
                            <ul class="list-unstyled text-left mb-3" style="line-height:1.9;">
                                <li><strong>Registration:</strong> Jul 27 – Sep 4, 2026</li>
                                <li><strong>1st Entrance:</strong> Aug 10, 2026</li>
                                <li><strong>2nd Entrance:</strong> Aug 17, 2026</li>
                                <li><strong>3rd Entrance:</strong> Aug 28, 2026</li>
                                <li><strong>4th Entrance:</strong> Sep 4, 2026</li>
                                <li><strong>Vacation School Begins:</strong> Aug 3, 2026</li>
                                <li><strong>Orientation:</strong> Sep 4, 2026</li>
                                <li><strong>Classes Begin:</strong> Sep 7, 2026</li>
                            </ul>

                            <a href="{{ url('/fees-structure') }}" class="btn btn-light btn-sm">Full Fees &amp;
                                Requirements</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========== End Announcements Section ========== -->

    <section class="ftco-services ftco-no-pb">
        <div class="container-wrap">
            <div class="row no-gutters">
                <div class="col-md-3 d-flex services align-self-stretch pb-4 px-4 ftco-animate bg-primary">
                    <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="flaticon-teacher"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Certified Teachers</h3>
                            <p>Our teachers are trained, committed, and passionate about nurturing academic excellence and
                                Christian character in every student.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex services align-self-stretch pb-4 px-4 ftco-animate bg-tertiary">
                    <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="flaticon-reading"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Special Education</h3>
                            <p>We combine strong academics with Christian values to develop students intellectually,
                                morally, and spiritually.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex services align-self-stretch pb-4 px-4 ftco-animate bg-fifth">
                    <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="flaticon-books"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Book &amp; Library</h3>
                            <p>Students have access to essential textbooks and learning materials that support effective
                                teaching and lifelong learning.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex services align-self-stretch pb-4 px-4 ftco-animate bg-quarternary">
                    <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="flaticon-diploma"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Certification</h3>
                            <p>We prepare students for national examinations and future success, producing graduates who
                                excel in higher education and beyond.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-no-pt ftc-no-pb">
        <div class="container">
            <div class="row">
                <div class="col-md-5 order-md-last wrap-about py-5 wrap-about bg-light">
                    <div class="text px-4 ftco-animate">
                        <h2 class="mb-4">Welcome to Edmol Baptist School</h2>
                        <p>Edmol Baptist School is a Christ-centered academic institution located in New Matadi, Opposite
                            Don Bossco Youuth-Center,Monrovia, Liberia. Established to respond to the growing educational
                            needs of children during a challenging period in our nation’s history, the school has remained
                            committed to academic excellence and moral discipline.</p>
                        <p>From Kindergarten through Senior High School, we provide quality education that nurtures the
                            mind, builds character, and prepares students to become responsible leaders in their families,
                            communities, and nation.</p>

                        <p><a href="#" class="btn btn-secondary px-4 py-3">Read our History..</a></p>
                    </div>
                </div>
                <div class="col-md-7 wrap-about py-5 pr-md-4 ftco-animate">
                    <h2 class="mb-4">What We Offer</h2>
                    <p>At Edmol Baptist School, we focus on holistic education—academic excellence, values, leadership
                        development, and student well-being.</p>
                    <div class="row mt-5">
                        <div class="col-lg-6">
                            <div class="services-2 d-flex">
                                <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                                        class="flaticon-security"></span></div>
                                <div class="text">
                                    <h3>Safety First</h3>
                                    <p>We provide a secure, disciplined, and caring environment where students feel
                                        protected and supported.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="services-2 d-flex">
                                <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                                        class="flaticon-reading"></span></div>
                                <div class="text">
                                    <h3>Regular Classes</h3>
                                    <p>Our dedicated teachers are trained and committed to guiding students with
                                        professionalism and integrity.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="services-2 d-flex">
                                <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                                        class="flaticon-diploma"></span></div>
                                <div class="text">
                                    <h3>Certified Teachers</h3>
                                    <p>Far far away, behind the word mountains, far from the countries Vokalia.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="services-2 d-flex">
                                <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                                        class="flaticon-education"></span></div>
                                <div class="text">
                                    <h3>Sufficient Classrooms</h3>
                                    <p>Spacious and well-managed classrooms create a focused and effective learning
                                        atmosphere.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="services-2 d-flex">
                                <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                                        class="flaticon-jigsaw"></span></div>
                                <div class="text">
                                    <h3>Creative Lessons</h3>
                                    <p>Interactive lessons encourage critical thinking, creativity, and active student
                                        participation.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="services-2 d-flex">
                                <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                                        class="flaticon-kids"></span></div>
                                <div class="text">
                                    <h3>Sports Facilities</h3>
                                    <p>We encourage physical fitness and teamwork through organized sports and friendly
                                        inter-school competitions.</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- introduction section  -->
    <section class="ftco-intro"
        style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo.png') }}');"
        data-stellar-background-ratio="0.5">

        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <h2>Building Character Through Faith and Education</h2>
                    <p class="mb-0">At Edmol Baptist School, we instill strong moral values, discipline, and academic
                        excellence to prepare students for responsible leadership and lifelong success.</p>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <p class="mb-0"><a href="{{ url('/registeration-form') }}"
                            class="btn btn-secondary px-4 py-3">Enroll Your Child</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- teachers images section -->
    <section class="ftco-section ftco-no-pb">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-2">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <h2 class="mb-4"><span>Certified</span> Leaderss</h2>
                    <p>Meet the dedicated leaders who guide Edmol Baptist School with faith, vision, and a commitment to
                        academic excellence and character development for every student.</p>
                </div>
            </div>

            <!-- Pastoral Board Section -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <h2 class="mb-4"><span>Pastoral</span> Board</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('kiddos-school-master/images/Pastor_philip_davis_image.jpeg') }}');">
                            </div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>PST. PHILIP W. DAVIS</h3>
                            <span class="position mb-2">ACTING PRINCIPAL</span>
                            <div class="faded">
                                <p>Pst. Philip W. Davis is dedicated to nurturing academic excellence, Christian values, and
                                    leadership skills in every student. Under his guidance, Edmol Baptist School continues
                                    to grow as a safe and inspiring learning community.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('kiddos-school-master/images/Pastor_joseph_k_flomo_image.jpeg') }}');">
                            </div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>Pst. JOSEPH K. FLOMO SR.</h3>
                            <span class="position mb-2">Assit Pastor MBC</span>
                            <div class="faded">
                                <p>Pst. Joseph K. Flomo Sr. serves as Assistant Pastor at Matadi Baptist Church and is
                                    committed to guiding students in spiritual growth, moral integrity, and community
                                    leadership alongside their academic journey.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- School Board Section -->
            <div class="row justify-content-center mb-4 mt-5">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <h2 class="mb-4"><span>School</span> Board</h2>
                </div>
            </div>

            <div class="row">
                <!-- Keep all 4 school board member cards -->
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('kiddos-school-master/images/Decon_joseph_gborie_image.jpeg') }}');">
                            </div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>Deacon Joseph J. Gborie</h3>
                            <span class="position mb-2">BA, M.Sc - School Board Chairman </span>
                            <div class="faded">
                                <p>Deacon Joseph J. Gborie, BA, M.Sc, leads the school board, supporting the growth and
                                    Christian values of Edmol Baptist School while ensuring academic excellence and student
                                    development.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- second persion -->
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('kiddos-school-master/images/Mr._Samuel_Babajuah_image.jpeg') }}');">
                            </div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>Mr. Samuel B.N. Babajuah</h3>
                            <span class="position mb-2">Board Membber </span>
                            <div class="faded">
                                <p>Mr. Samuel B.N. Babajuah, B.PA and M.Ph, serves as a Board Member, supporting Edmol
                                    Baptist School’s mission, academic excellence, and the development of students’
                                    Christian values and leadership skills.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- third persion -->
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('kiddos-school-master/images/Sis_gboroyonon_williams_image.jpeg') }}');">
                            </div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>Mrs. Gboryonon B.Z. Williams</h3>
                            <span class="position mb-2">Board Member</span>
                            <div class="faded">
                                <p>Mrs. Gboryonon B.Z. Williams, Board Member, supports Edmol Baptist School’s mission by
                                    promoting academic excellence, Christian values, and student growth within the school
                                    community.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- fourth character -->
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('logo/edmol-orginal-logo.png') }}');"></div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>Pst. John K. Sackie</h3>
                            <span class="position mb-2">Board Member</span>
                            <div class="faded">
                                <p>Pst. John K. Sackie, B.Sc, M.Sc, serves as Board Member, helping guide Edmol Baptist
                                    School in financial stewardship, leadership, and fostering a faith-based learning
                                    environment.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Administrators Board Section -->
            <div class="row justify-content-center mb-4 mt-5">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <h2 class="mb-4"><span>Administrators</span> Board</h2>
                </div>
            </div>

            <div class="row">
                <!-- Keep all 4 administrators cards exactly as in your original code -->
                <!-- fourth character -->
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('kiddos-school-master/images/Pastor_philip_davis_image.jpeg') }}');">
                            </div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>PST. PHILIP W. DAVIS</h3>
                            <span class="position mb-2">BA, M.Sc - School Board Chairman </span>
                            <div class="faded">
                                <p>Pst. Philip W. Davis is dedicated to nurturing academic excellence, Christian values, and
                                    leadership skills in every student. Under his guidance, Edmol Baptist School continues
                                    to grow as a safe and inspiring learning community.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- second admin -->
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('kiddos-school-master/images/Mr._ANTHONY_Y._KORHA _image.jpeg') }}');">
                            </div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>Mr. ANTHONY Y. KORHA </h3>
                            <span class="position mb-2">AA EDU. BSC Cand.Acting VPI </span>
                            <div class="faded">
                                <p>Mr. Anthony Y. Korha, AA Edu. and B.Sc Candidate, serves as Acting Vice Principal for
                                    Instruction, contributing to effective administration, academic coordination, and the
                                    overall growth of the school.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- third admin-->
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('kiddos-school-master/images/MR._EMMANUEL _D._WRIGHT _image.jpeg') }}');">
                            </div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>MR. EMMANUEL D. WRIGHT </h3>
                            <span class="position mb-2">BSC Cand.Acting VPSA/DEAN </span>
                            <div class="faded">
                                <p>Mr. Emmanuel D. Wright, B.Sc Candidate, serves as Acting Vice Principal for Student
                                    Affairs and Dean, supporting student development, discipline, and the overall welfare of
                                    the school community.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- fourth character -->
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('kiddos-school-master/images/Hanery_p_say_image.jpeg') }}');">
                            </div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>MR. HENRY P. SAYE </h3>
                            <span class="position mb-2">AA, BBA ACCOUNTING, LTP Cand. Business Manager </span>
                            <div class="faded">
                                <p>Mr. Henry P. Saye, AA, BBA in Accounting and LTP Candidate, serves as Business Manager,
                                    overseeing financial operations and ensuring effective management of the school’s
                                    resources.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- fifth admin -->
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('kiddos-school-master/images/MS._TILTA _WEAH_image.jpeg') }}');">
                            </div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>MS. TILTA WEAH</h3>
                            <span class="position mb-2"> BSC Registrar </span>
                            <div class="faded">
                                <p>Ms. Tilta Weah, BSc, serves as Registrar, responsible for academic records management and
                                    ensuring accurate documentation across all school departments.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- six character -->
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('kiddos-school-master/images/MR._SAMUEL F_ MULBAH_image.jpeg') }}');">
                            </div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>MR. SAMUEL F. MULBAH </h3>
                            <span class="position mb-2">BSC ECONOMICS Secretary </span>
                            <div class="faded">
                                <p>Mr. Samuel F. Mulbah, BSc in Economics, serves as Secretary, supporting administrative
                                    coordination and maintaining effective communication within the school leadership.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- seven character -->
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('kiddos-school-master/images/MR._SHADRACHS.P._TEAH_image.jpeg') }}');">
                            </div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>MR. SHADRACH S.P. TEAH</h3>
                            <span class="position mb-2">AA EDUCATION KG Cord</span>
                            <div class="faded">
                                <p>Mr. Shadrach S.P. Teah, AA in Education, serves as KG Coordinator, overseeing early
                                    childhood programs and ensuring a safe, nurturing, and engaging learning environment for
                                    young students.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- eight character -->
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch"
                                style="background-image: url('{{ asset('kiddos-school-master/images/Brown_HOLT JR_image.jpeg') }}');">
                            </div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3>BROWNELL J. HOLT JR.</h3>
                            <span class="position mb-2">Meet Our Valedictorian </span>
                            <div class="faded">
                                <p>Deacon Joseph J. Gborie, BA, M.Sc, leads the school board, supporting the growth and
                                    Christian values of Edmol Baptist School while ensuring academic excellence and student
                                    development.</p>
                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a>
                                    </li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!--course section -->
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-2">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <h2 class="mb-4"><span>Extra</span> Curriculum Activities</h2>
                    <p>At Edmol Baptist School, we complement academic excellence with engaging extra-curricular activities,
                        promoting creativity, teamwork, and holistic development for all students.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 course d-lg-flex ftco-animate">

                    <div class="img"
                        style="background-image: url({{ asset('kiddos-school-master/images/extracurriculum_image1.jpg') }});">
                    </div>

                    <div class="text bg-light p-4">
                        <h3><a href="#">Arts Lesson</a></h3>
                        <p class="subheading"><span>Class time:</span> 9:00am - 10am</p>
                        <p>Separated they live in. A small river named Duden flows by their place and supplies it with the
                            necessary regelialia. It is a paradisematic country</p>
                    </div>
                </div>
                <div class="col-md-6 course d-lg-flex ftco-animate">
                    <div class="img"
                        style="background-image: url({{ asset('kiddos-school-master/images/extracurriculum_image3.jpg') }});">
                    </div>
                    <div class="text bg-light p-4">
                        <h3><a href="#">Science & Discovery</a></h3>
                        <p class="subheading"><span>Class time:</span> 9:00am - 10am</p>
                        <p>Hands-on experiments and practical lessons help students develop critical thinking and a love for
                            science.</p>
                    </div>
                </div>
                <div class="col-md-6 course d-lg-flex ftco-animate">
                    <div class="img"
                        style="background-image: url({{ asset('kiddos-school-master/images/extracurriculum_image2.jpg') }});">
                    </div>
                    <div class="text bg-light p-4">
                        <h3><a href="#">Music & Performance</a></h3>
                        <p class="subheading"><span>Class time:</span> 9:00am - 10am</p>
                        <p>Students develop rhythm, vocal skills, and musical appreciation through choir, instruments, and
                            performance arts.</p>
                    </div>
                </div>
                <div class="col-md-6 course d-lg-flex ftco-animate">
                    <div class="img"
                        style="background-image: url({{ asset('kiddos-school-master/images/extracurriculum_image4.jpg') }});">
                    </div>
                    <div class="text bg-light p-4">
                        <h3><a href="#">Sports & Team Work</a></h3>
                        <p class="subheading"><span>Class time:</span> 9:00am - 10am</p>
                        <p>We encourage physical fitness and teamwork through football, basketball, athletics, and friendly
                            inter-school competitions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- start  -->


    <!-- end -->
    <section class="ftco-section ftco-counter img" id="section-counter"
        style="background-image: url('{{ asset('kiddos-school-master/images/student_image2.jpeg') }}');"
        data-stellar-background-ratio="0.5">

        <div class="container">
            <div class="row justify-content-center mb-5 pb-2">
                <div class="col-md-8 text-center heading-section heading-section-black ftco-animate">
                    <h2 class="mb-4"><span>32 Years of</span> Experience</h2>
                    <p>Since 1994, Edmol Baptist School has been committed to academic excellence, nurturing students’
                        talents, and shaping responsible leaders in Monrovia and beyond.</p>

                </div>
            </div>
            <div class="row d-md-flex align-items-center justify-content-center">
                <div class="col-lg-10">
                    <div class="row d-md-flex align-items-center">
                        <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18">
                                <div class="icon"><span class="flaticon-doctor"></span></div>
                                <div class="text">
                                    <strong class="number" data-number="18">0</strong>
                                    <span>Certified Teachers</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18">
                                <div class="icon"><span class="flaticon-doctor"></span></div>
                                <div class="text">
                                    <strong class="number" data-number="351">0</strong>
                                    <span>Successful Kids</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18">
                                <div class="icon"><span class="flaticon-doctor"></span></div>
                                <div class="text">
                                    <strong class="number" data-number="564">0</strong>
                                    <span>Happy Parents</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18">
                                <div class="icon"><span class="flaticon-doctor"></span></div>
                                <div class="text">
                                    <strong class="number" data-number="300">0</strong>
                                    <span>Awards Won</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- what parent say about us -->
    <section class="ftco-section testimony-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-2">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <h2 class="mb-4"><span>What Parents</span> Says About Us</h2>
                    <p>it with the necessary regelialia. It is a paradisematic country</p>
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
                                    <p>Edmol Baptist School has given my daughter a safe and inspiring environment to grow
                                        academically and spiritually.</p>
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
                                    <p class="name">Bro Potiphar G Vaye</p>
                                    <span class="position">Father</span>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="testimony-wrap d-flex">
                                <div class="user-img mr-4"
                                    style="background-image: url('{{ asset('logo/edmol-orginal-logo.png') }}')"></div>
                                <div class="text ml-2 bg-light">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                    <p>I love the focus on both education and character development. My child is learning so
                                        much beyond textbooks.</p>
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
                                    <p>Edmol Baptist School is more than a school; it’s a community that nurtures excellence
                                        and discipline..</p>
                                    <p class="name">Mr. George Toe</p>
                                    <span class="position">Father</span>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="testimony-wrap d-flex">
                                <div class="user-img mr-4"
                                    style="background-image: url('{{ asset('logo/edmol-orginal-logo.png') }}')"></div>
                                <div class="text ml-2 bg-light">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                    <p>From academics to sports, my child enjoys every moment here and is thriving in all
                                        aspects.</p>
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
        style="background-image: url('{{ asset('logo/edmol-orginal-logo.png') }}');" data-stellar-background-ratio="0.5">

        <div class="container">
            <div class="row justify-content-end">
                <div class="col-md-6 py-5 px-md-5 bg-primary">
                    <div class="heading-section heading-section-white ftco-animate mb-5">
                        <h2 class="mb-4">Request A Quote</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there
                            live the blind texts.</p>
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
                                <input type="submit" value="Request A Quote" class="btn btn-secondary py-3 px-4">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-2">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <h2 class="mb-4"><span>Our</span> Pricing</h2>
                    <p>Transparent and affordable tuition structure in line with the Liberia Ministry of Education
                        curriculum. For detailed information on fees for other grade levels, kindly click the Read More
                        button.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="pricing-entry bg-light pb-4 text-center">
                        <div>
                            <h3 class="mb-3">Grade 9th</h3>
                            <p><span class="price">LRD$ 40,875</span> <span class="per">Per/Year</span></p>
                        </div>
                        <div class="img"
                            style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                        </div>

                        <div class="px-4">
                            <p>Our fees cover registration, tuition, and computer studies, ensuring quality education,
                                skilled instruction, and essential learning resources..</p>
                        </div>
                        <p class="button text-center"><a href="{{ url('/fees-structure') }}"
                                class="btn btn-primary px-4 py-3">read more..</a></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="pricing-entry bg-light pb-4 text-center">
                        <div>
                            <h3 class="mb-3">Grade 10th</h3>
                            <p><span class="price">LRD$47,500</span> <span class="per">Per/Year</span></p>
                        </div>
                        <div class="img"
                            style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                        </div>
                        <div class="px-4">
                            <p>Our fees cover registration, tuition, and computer studies, ensuring quality education,
                                skilled instruction, and essential learning resources..</p>
                        </div>
                        <p class="button text-center"><a href="{{ url('/fees-structure') }}"
                                class="btn btn-secondary px-4 py-3">read more..</a></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="pricing-entry bg-light active pb-4 text-center">
                        <div>
                            <h3 class="mb-3">Grade 11th</h3>
                            <p><span class="price">LRD$47,500</span> <span class="per">Per/Year</span></p>
                        </div>
                        <div class="img"
                            style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                        </div>

                        <div class="px-4">
                            <p>Our fees cover registration, tuition, and computer studies, ensuring quality education,
                                skilled instruction, and essential learning resources..</p>
                        </div>
                        <p class="button text-center"><a href="{{ url('/fees-structure') }}"
                                class="btn btn-primary px-4 py-3">read more..</a></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="pricing-entry bg-light pb-4 text-center">
                        <div>
                            <h3 class="mb-3">Grade 12th</h3>
                            <p><span class="price">LRD$53,000</span> <span class="per">Per/Year</span></p>
                        </div>
                        <div class="img"
                            style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                        </div>
                        <div class="px-4">
                            <p>Our fees cover registration, tuition, and computer studies, ensuring quality education,
                                skilled instruction, and essential learning resources..</p>
                        </div>
                        <p class="button text-center"><a href="{{ url('/fees-structure') }}"
                                class="btn btn-quarternary px-4 py-3">read more..</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--blog -->
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-2">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <h2 class="mb-4"><span>Recent</span> Blog</h2>
                    <p>Stay updated with recent school events, student achievements, and activities that reflect our
                        commitment to quality education.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4 ftco-animate">
                    <div class="blog-entry">
                        <a href="blog-single.html" class="block-20 d-flex align-items-end"
                            style="background-image: url('{{ asset('kiddos-school-master/images/blog_post1.jpg') }}');">

                            <div class="meta-date text-center p-2">
                                <span class="day">27</span>
                                <span class="mos">January</span>
                                <span class="yr">2019</span>
                            </div>
                        </a>
                        <div class="text bg-white p-4">
                            <h3 class="heading"><a href="#">Inter-School Sports Competition Success</a></h3>
                            <p> Our students proudly represented the school in friendly sports competitions, demonstrating
                                teamwork, discipline, and sportsmanship.</p>
                            <div class="d-flex align-items-center mt-4">
                                <p class="mb-0"><a href="{{ url('/blog') }}" class="btn btn-secondary">Read More
                                        <span class="ion-ios-arrow-round-forward"></span></a></p>
                                <p class="ml-auto mb-0">
                                    <a href="#" class="mr-2">Admin</a>
                                    <a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 ftco-animate">
                    <div class="blog-entry">
                        <a href="blog-single.html" class="block-20 d-flex align-items-end"
                            style="background-image: url('{{ asset('kiddos-school-master/images/blog_post2.jpg') }}');">

                            <div class="meta-date text-center p-2">
                                <span class="day">27</span>
                                <span class="mos">January</span>
                                <span class="yr">2019</span>
                            </div>
                        </a>
                        <div class="text bg-white p-4">
                            <h3 class="heading"><a href="#">Academic Excellence and Student Awards</a></h3>
                            <p>Outstanding students were recognized for academic performance, leadership, and commitment to
                                excellence during the academic year..</p>
                            <div class="d-flex align-items-center mt-4">
                                <p class="mb-0"><a href="{{ url('/blog') }}" class="btn btn-secondary">Read More
                                        <span class="ion-ios-arrow-round-forward"></span></a></p>
                                <p class="ml-auto mb-0">
                                    <a href="#" class="mr-2">Admin</a>
                                    <a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 ftco-animate">
                    <div class="blog-entry">
                        <a href="blog-single.html" class="block-20 d-flex align-items-end"
                            style="background-image: url('{{ asset('kiddos-school-master/images/blog_post3.jpg') }}');">

                            <div class="meta-date text-center p-2">
                                <span class="day">27</span>
                                <span class="mos">January</span>
                                <span class="yr">2019</span>
                            </div>
                        </a>
                        <div class="text bg-white p-4">
                            <h3 class="heading"><a href="#">Creative Arts and Science Activities Day</a></h3>
                            <p>Students showcased creativity and innovation through art displays and practical science
                                activities that encourage critical thinking..</p>
                            <div class="d-flex align-items-center mt-4">
                                <p class="mb-0"><a href="{{ url('/blog') }}" class="btn btn-secondary">Read More
                                        <span class="ion-ios-arrow-round-forward"></span></a></p>
                                <p class="ml-auto mb-0">
                                    <a href="#" class="mr-2">Admin</a>
                                    <a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a>
                                </p>
                            </div>
                        </div>
                    </div>
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
                                <li><span class="icon icon-map-marker"></span><span class="text">New Matadi, Opposite
                                        Don-Bossco Youth-Center Monrovia, Liberia </span></li>
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
                                style="background-image: url('{{ asset('kiddos-school-master/images/blog_post2.jpg') }}');"></a>

                            <div class="text">
                                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control
                                        about</a></h3>
                                <div class="meta">
                                    <div><a href="#"><span class="icon-calendar"></span> Dec 25, 2018</a></div>
                                    <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="block-21 mb-5 d-flex">
                            <a class="blog-img mr-4"
                                style="background-image: url('{{ asset('kiddos-school-master/images/blog_post3.jpg') }}');"></a>

                            <div class="text">
                                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control
                                        about</a></h3>
                                <div class="meta">
                                    <div><a href="#"><span class="icon-calendar"></span> Dec 25, 2018</a></div>
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
                            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
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
    </footer>



    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div>
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
    <script src="js/main.js"></script> -->
    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/250794241623" target="_blank" class="whatsapp-float" aria-label="Message us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

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

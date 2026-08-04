@extends('public.layouts.public')

@section('title', 'Our Teachers - Edmol MBHS')
@section('description', 'Meet qualified teachers of Edmol MBHS school.')
@section('canonical_url', 'https://www.edmolmbhs.com/teachers')

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
        <section class="hero-wrap hero-wrap-2"
            style="background-image: url('{{ asset('kiddos-school-master/images/class-room-teacher-image.jpg') }}');">

            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text align-items-center justify-content-center">
                    <div class="col-md-9 ftco-animate text-center">
                        <h1 class="mb-2 bread">Certified Teachers</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/') }}">Home <i
                                        class="ion-ios-arrow-forward"></i></a></span> <span>Teachers <i
                                    class="ion-ios-arrow-forward"></i></span></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- teachers images section -->
        <section class="ftco-section ftco-no-pb">
            <div class="container">
                <div class="row justify-content-center mb-5 pb-2">
                    <div class="col-md-8 text-center heading-section ftco-animate">
                        <h2 class="mb-4"><span>Certified</span> Leaders</h2>
                        <p>Meet our passionate and highly qualified teachers at Edmol Baptist School—educators who lead with
                            faith, inspire with vision, and are dedicated to nurturing both academic excellence and strong
                            character in every student..</p>
                    </div>
                </div>


                <!-- Administrators Board Section -->
                <div class="row justify-content-center mb-4 mt-5">
                    <div class="col-md-8 text-center heading-section ftco-animate">
                        <h2 class="mb-4"><span>Teachers</span> Board</h2>
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
                                    <p>Pst. Philip W. Davis is dedicated to nurturing academic excellence, Christian values,
                                        and leadership skills in every student. Under his guidance, Edmol Baptist School
                                        continues to grow as a safe and inspiring learning community.</p>
                                    <ul class="ftco-social text-center">
                                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                        </li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-facebook"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-google-plus"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-instagram"></span></a></li>
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
                                        Instruction, contributing to effective administration, academic coordination, and
                                        the overall growth of the school.</p>
                                    <ul class="ftco-social text-center">
                                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                        </li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-facebook"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-google-plus"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-instagram"></span></a></li>
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
                                        Affairs and Dean, supporting student development, discipline, and the overall
                                        welfare of the school community.</p>
                                    <ul class="ftco-social text-center">
                                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                        </li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-facebook"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-google-plus"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-instagram"></span></a></li>
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
                                    <p>Mr. Henry P. Saye, AA, BBA in Accounting and LTP Candidate, serves as Business
                                        Manager, overseeing financial operations and ensuring effective management of the
                                        school’s resources.</p>
                                    <ul class="ftco-social text-center">
                                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                        </li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-facebook"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-google-plus"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-instagram"></span></a></li>
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
                                    <p>Ms. Tilta Weah, BSc, serves as Registrar, responsible for academic records management
                                        and ensuring accurate documentation across all school departments.</p>
                                    <ul class="ftco-social text-center">
                                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                        </li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-facebook"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-google-plus"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-instagram"></span></a></li>
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
                                    <p>Mr. Samuel F. Mulbah, BSc in Economics, serves as Secretary, supporting
                                        administrative coordination and maintaining effective communication within the
                                        school leadership.</p>
                                    <ul class="ftco-social text-center">
                                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                        </li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-facebook"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-google-plus"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-instagram"></span></a></li>
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
                                        childhood programs and ensuring a safe, nurturing, and engaging learning environment
                                        for young students.</p>
                                    <ul class="ftco-social text-center">
                                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                        </li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-facebook"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-google-plus"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-instagram"></span></a></li>
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
                                        Christian values of Edmol Baptist School while ensuring academic excellence and
                                        student development.</p>
                                    <ul class="ftco-social text-center">
                                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                        </li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-facebook"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-google-plus"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-instagram"></span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- School Board Section -->
                <div class="row justify-content-center mb-4 mt-5">
                    <div class="col-md-8 text-center heading-section ftco-animate">
                        <h2 class="mb-4"><span>Class</span> Sponsors</h2>
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
                                        Christian values of Edmol Baptist School while ensuring academic excellence and
                                        student development.</p>
                                    <ul class="ftco-social text-center">
                                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                        </li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-facebook"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-google-plus"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-instagram"></span></a></li>
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
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-facebook"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-google-plus"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-instagram"></span></a></li>
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
                                    <p>Mrs. Gboryonon B.Z. Williams, Board Member, supports Edmol Baptist School’s mission
                                        by promoting academic excellence, Christian values, and student growth within the
                                        school community.</p>
                                    <ul class="ftco-social text-center">
                                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a>
                                        </li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-facebook"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-google-plus"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-instagram"></span></a></li>
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
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-facebook"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-google-plus"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span
                                                    class="icon-instagram"></span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
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
                                    <li><a href="tel:+2 392 3929 210"><span class="icon icon-phone"></span><span
                                                class="text">+231555472972 / +231776597201</span></a></li>
                                    <li><a href="mailto:info@yourdomain.com"><span class="icon icon-envelope"></span><span
                                                class="text">info@yourdomain.com</span></a></li>
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
                                        <div><a href="#"><span class="icon-calendar"></span> Dec 25, 2026</a></div>
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
            </svg></div>z
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

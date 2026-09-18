@extends('public.layouts.public')

@section('title', 'SchoolGear Liberia | Powering Smarter Schools')

@section('description',
    'SchoolGear Liberia is a school management platform helping schools simplify administration,
    manage academic information, and connect their school community through technology.')

@section('content')

    <!-- banner part start-->
    <section class="banner_part">
        <img src="{{ asset('schoolGear_liberia_public_site/img/imagegear1.jpg') }}" alt="banner image"
            class="banner_hero_img" />
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-xl-6">
                    <div class="banner_text">
                        <div class="banner_text_iner">
                            <h5>Built for Schools. Designed for Liberia.</h5>
                            <h1>Run Your School Smarter with SchoolGear Liberia</h1>
                            <p>
                                SchoolGear is an all-in-one school management system that
                                helps Liberian schools simplify admissions, manage students
                                and staff, track academics, handle fees, and keep the entire
                                school connected—all in one place.
                            </p>
                            <a href="{{ route('public.register') }}" class="btn_1">Get Started Free </a>

                            <a href="{{ url('/about-us') }}" class="btn_2">Explore SchoolGear</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner part start-->

    <!-- feature_part start-->
    <section class="feature_part">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xl-3 align-self-center">
                    <div class="single_feature_text">
                        <h2>
                            Everything Your <br />
                            School Needs
                        </h2>
                        <p>
                            One platform to manage your school, empower your staff, and keep
                            student records organized
                        </p>
                        <a href="#" class="btn_1">See Features</a>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <span class="single_feature_icon"><i class="ti-layers"></i></span>
                            <h4>Complete School Management</h4>
                            <p>
                                Manage admissions, students, enrollment, fees, academic years,
                                grades, and subjects from one connected platform
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <span class="single_feature_icon"><i class="ti-new-window"></i></span>
                            <h4>Academic Management</h4>
                            <p>
                                Manage grades, subjects, report cards, and academic records
                                with controlled access and reliable audit trails.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="single_feature">
                        <div class="single_feature_part single_feature_part_2">
                            <span class="single_service_icon style_icon"><i class="ti-light-bulb"></i></span>
                            <h4>Built for Every Role</h4>
                            <p>
                                Give administrators, teachers, and students a dedicated
                                experience designed around what they need to do.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- upcoming_event part start-->

    <!-- learning part start-->
    <section class="learning_part">
        <div class="container">
            <div class="row align-items-sm-center align-items-lg-stretch">
                <div class="col-md-7 col-lg-7">
                    <div class="learning_img">

                        <img src="{{ asset('schoolGear_liberia_public_site/img/image123456.jpg') }}" />
                    </div>
                </div>
                <div class="col-md-5 col-lg-5">
                    <div class="learning_member_text">
                        <h5>About SchoolGear Liberia</h5>
                        <h2>Technology That Makes School Management Easier</h2>
                        <p>
                            Managing a school shouldn't mean juggling paperwork,
                            spreadsheets, and disconnected processes. SchoolGear brings your
                            school's essential operations into one connected system helping
                            your team save time, stay organized, and focus more on what
                            matters: supporting better learning.
                        </p>
                        <ul>
                            <li>
                                <span class="ti-pencil-alt"></span>One Platform for Your
                                School Manage students, academics, staff, fees, and daily
                                operations in one place.
                            </li>
                            <li>
                                <span class="ti-ruler-pencil"></span>Made for the Liberian
                                Education System Practical technology designed around the
                                needs of schools in Liberia.
                            </li>
                        </ul>
                        <a href="#" class="btn_1">Discover SchoolGear</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- learning part end-->

    <!-- member_counter counter start -->
    <section class="member_counter">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="single_member_counter">
                        <span class="counter">3</span>
                        <h4>Months Free Trial</h4>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single_member_counter">
                        <span class="counter">1</span>
                        <h4>Connected Platform</h4>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single_member_counter">
                        <span class="counter">3</span>
                        <h4>Core User Roles</h4>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single_member_counter">
                        <span class="counter">100</span><span class="percent">%</span>
                        <h4>Built for Schools</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- member_counter counter end -->

    <!-- learning part start-->
    <section class="advance_feature learning_part">
        <div class="container">
            <div class="row align-items-sm-center align-items-xl-stretch">
                <div class="col-md-6 col-lg-6">
                    <div class="learning_member_text">
                        <h5>Built for Better Schools</h5>
                        <h2>Turn Everyday School Work Into Simple Digital Processes</h2>
                        <p>
                            From the first student admission to academic records and school
                            reporting, SchoolGear helps schools replace scattered paperwork
                            with organized digital processes that save time, reduce errors,
                            and make important information easier to manage.
                        </p>
                        <div class="row">
                            <div class="col-sm-6 col-md-12 col-lg-6">
                                <div class="learning_member_text_iner">
                                    <span class="ti-pencil-alt"></span>
                                    <h4>Less Paperwork</h4>
                                    <p>
                                        Keep student information, admissions, records, and reports
                                        organized without relying on piles of paperwork.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-12 col-lg-6">
                                <div class="learning_member_text_iner">
                                    <span class="ti-stamp"></span>
                                    <h4>Greater Accountability</h4>
                                    <p>
                                        Give schools clearer records and better visibility into
                                        important academic and administrative activities.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="learning_img">
                        <img src="{{ asset('schoolGear_liberia_public_site/img/image555.jpg') }}" alt="#" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- learning part end-->

    <!--::review_part start::-->
    <section class="testimonial_part">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="section_tittle text-center">
                        <p>What Schools Say</p>
                        <h2>Helping Schools Work Smarter</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="textimonial_iner owl-carousel">
                        <div class="testimonial_slider">
                            <div class="row">
                                <div class="col-lg-8 col-xl-4 col-sm-8 align-self-center">
                                    <div class="testimonial_slider_text">
                                        <p>
                                            SchoolGear gives us a simpler way to manage student
                                            records, academic activities, and everyday school
                                            administration from one place.
                                        </p>
                                        <h4>Hanery S Saye</h4>
                                        <h5>EDMOL Memorial Baptists High School</h5>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-2 col-sm-4">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ asset('schoolGear_liberia_public_site/img/hanery.png') }}"
                                            alt="#" />
                                    </div>
                                </div>
                                <div class="col-xl-4 d-none d-xl-block">
                                    <div class="testimonial_slider_text">
                                        <p>
                                            Having student information, grades, and learning
                                            materials organized in one system makes it much easier
                                            for teachers to manage their work
                                        </p>
                                        <h4>Mrs. Gboryonon B.Z. Williams</h4>
                                        <h5>Board Member EDMOL Memorial Baptists High School</h5>
                                    </div>
                                </div>
                                <div class="col-xl-2 d-none d-xl-block">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ asset('schoolGear_liberia_public_site/img/sisGboryonon.png') }}"
                                            alt="#" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial_slider">
                            <div class="row">
                                <div class="col-lg-8 col-xl-4 col-sm-8 align-self-center">
                                    <div class="testimonial_slider_text">
                                        <p>
                                            SchoolGear makes it easier for students to stay
                                            connected with their school, access their academic
                                            information, and keep track of their learning.
                                        </p>
                                        <h4>Prince Brown</h4>
                                        <h5>Future Focus Academy</h5>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-2 col-sm-4">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ asset('schoolGear_liberia_public_site/img/prince_brown.jpeg') }}"
                                            alt="#" />
                                    </div>
                                </div>
                                <div class="col-xl-4 d-none d-xl-block">
                                    <div class="testimonial_slider_text">
                                        <p>
                                            SchoolGear provides schools with a more organized way to
                                            manage academic records, support teachers, and keep
                                            important school information accessible.
                                        </p>
                                        <h4>Decon Joseph Gborie</h4>
                                        <h5>School Board Member</h5>
                                    </div>
                                </div>
                                <div class="col-xl-2 d-none d-xl-block">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ asset('schoolGear_liberia_public_site/img/deaconjoseph.png') }}"
                                            alt="#" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial_slider">
                            <div class="row">
                                <div class="col-lg-8 col-xl-4 col-sm-8 align-self-center">
                                    <div class="testimonial_slider_text">
                                        <p>
                                            Behold place was a multiply creeping creature his domin
                                            to thiren open void hath herb divided divide creepeth
                                            living shall i call beginning third sea itself set
                                        </p>
                                        <h4>Joseph Massaly</h4>
                                        <h5>Head Of ICT LIPA Liberia</h5>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-2 col-sm-4">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ asset('schoolGear_liberia_public_site/img/Joseph (1).png') }}"
                                            alt="#" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--::blog_part end::-->
    <!--::blog_part start::-->
    <section class="blog_part section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="section_tittle text-center">
                        <p>Why SchoolGear</p>
                        <h2>Everything Your School Needs, In One Place</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-lg-4 col-xl-4">
                    <div class="single-home-blog">
                        <div class="card">
                            <img src="{{ asset('schoolGear_liberia_public_site/img/Kindergarten student-amico.png') }}"
                                alt="Student Admission & Enrollment" />
                            <div class="card-body">
                                <a href="#">
                                    <h5 class="card-title">Student & Admission Management</h5>
                                </a>
                                <p>
                                    Manage applications, admissions, student records,
                                    enrollment, and student information digitally.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-4">
                    <div class="single-home-blog">
                        <div class="card">
                            <img src="{{ asset('schoolGear_liberia_public_site/img/college entrance exam-rafiki.png') }}"
                                alt="Academic and grade management" />
                            <div class="card-body">
                                <a href="#">
                                    <h5 class="card-title">Academic Management</h5>
                                </a>
                                <p>
                                    Manage grades, subjects, teacher assignments, grade entry,
                                    report cards, and academic records with better
                                    accountability eroooooooooooooooo.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-4">
                    <div class="single-home-blog">
                        <div class="card">
                            <img src="{{ asset('schoolGear_liberia_public_site/img/High School-rafiki.png') }}"
                                alt="Academic and grade management" />
                            <div class="card-body">
                                <a href="#">
                                    <h5 class="card-title">
                                        School Communication & Operations
                                    </h5>
                                </a>
                                <p>
                                    Keep administrators, teachers, and students connected
                                    through announcements, learning materials, live classes, and
                                    school activities.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--::blog_part end::-->

@endsection

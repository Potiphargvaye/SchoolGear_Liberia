@extends('public.layouts.public')

@section('title', 'About Us | SchoolGear Liberia')

@section('description',
    'Learn about SchoolGear Liberia, why it was created, the problem it was built to solve, our
    mission, vision, journey, and our goal of helping schools across Liberia embrace better digital management.')

@section('content')

    <!-- breadcrumb start-->
    <section class="breadcrumb breadcrumb_bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb_iner text-center">
                        <div class="breadcrumb_iner_item">
                            <h2>About Us</h2>
                            <p>Home<span>/</span>About Us</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb start-->
    <!-- feature_part start-->
    <section class="feature_part single_feature_padding">
        <div class="container">
            <div class="row">
                <!-- Intro -->
                <div class="col-sm-6 col-xl-3 align-self-center">
                    <div class="single_feature_text">
                        <h2>
                            One Platform <br />
                            For Your School
                        </h2>
                        <p>
                            SchoolGear brings essential school operations together in one
                            organized system, helping schools manage people, records,
                            learning, and daily activities with greater ease.
                        </p>
                        <a href="#" class="btn_1">Explore SchoolGear</a>
                    </div>
                </div>

                <!-- Student & Enrollment Management -->
                <div class="col-sm-6 col-xl-3">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <span class="single_feature_icon">
                                <i class="ti-user"></i>
                            </span>
                            <h4>Student & Enrollment</h4>
                            <p>
                                Manage student admissions, enrollment, profiles, registration
                                information, and student records from one organized system.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Academic Management -->
                <div class="col-sm-6 col-xl-3">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <span class="single_feature_icon">
                                <i class="ti-book"></i>
                            </span>
                            <h4>Academic Management</h4>
                            <p>
                                Organize grades, subjects, student results, academic records,
                                report cards, and teacher assignments with greater accuracy.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Teacher Management -->
                <div class="col-sm-6 col-xl-3">
                    <div class="single_feature">
                        <div class="single_feature_part single_feature_part_2">
                            <span class="single_service_icon style_icon">
                                <i class="ti-blackboard"></i>
                            </span>
                            <h4>Teacher Management</h4>
                            <p>
                                Give teachers the tools and access they need to manage
                                assigned classes, subjects, students, grades, and learning
                                activities.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Student & Staff Attendance -->
                <div class="col-sm-6 col-xl-3">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <span class="single_feature_icon">
                                <i class="ti-calendar"></i>
                            </span>
                            <h4>Student & Staff Attendance</h4>
                            <p>
                                Track daily attendance for students and staff, helping schools
                                maintain accurate attendance records and monitor participation
                                throughout the school year.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Fees & Records -->
                <div class="col-sm-6 col-xl-3">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <span class="single_feature_icon">
                                <i class="ti-wallet"></i>
                            </span>
                            <h4>Fees & Records</h4>
                            <p>
                                Keep student fee information and important administrative
                                records organized, accessible, and easier for schools to
                                manage.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reports & Accountability -->
                <div class="col-sm-6 col-xl-3">
                    <div class="single_feature">
                        <div class="single_feature_part single_feature_part_2">
                            <span class="single_service_icon style_icon">
                                <i class="ti-bar-chart"></i>
                            </span>
                            <h4>Reports & Accountability</h4>
                            <p>
                                Access important school reports and maintain clearer records
                                of academic and administrative activities for better
                                accountability.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Announcements & Communication -->
                <div class="col-sm-6 col-xl-3">
                    <div class="single_feature">
                        <div class="single_feature_part single_feature_part_2">
                            <span class="single_service_icon style_icon">
                                <i class="ti-announcement"></i>
                            </span>
                            <h4>Announcements & Communication</h4>
                            <p>
                                Keep students, teachers, and the school community informed
                                with announcements and important updates shared through one
                                platform.
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
                        <img src="{{ asset('schoolGear_liberia_public_site/img/banner_img.png') }}" alt="banner image" />

                    </div>
                </div>

                <div class="col-md-5 col-lg-5">
                    <div class="learning_member_text">
                        <h5>Our Story</h5>

                        <h2>Built From a Problem We Believe Liberia Can Solve</h2>

                        <p>
                            Growing up in Liberia, I have seen schools continue to manage
                            important daily operations manually, with information scattered
                            across paper records and disconnected processes. SchoolGear was
                            created to help schools move confidently into the digital age
                            with simple technology built around their real needs.
                        </p>

                        <ul>
                            <li>
                                <span class="ti-pencil-alt"></span>
                                <strong>Inspired by a Real School:</strong> SchoolGear began
                                with EDMOL Memorial Baptists High School, where the need for a
                                centralized way to manage school information became clear.
                            </li>

                            <li>
                                <span class="ti-ruler-pencil"></span>
                                <strong>Built for Liberia's Future:</strong> Our vision is to
                                work with schools and the Ministry of Education to make better
                                digital school management accessible across all 15 counties.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- learning part end-->

    <!-- mission vision part start-->
    <section class="mission_vision_part">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 mb-4 mb-lg-0">
                    <div class="mission_vision_text">
                        <span class="ti-target sg-icon"></span>
                        <h5>Our Mission</h5>
                        <h2>Helping Schools Run With Less Paper, More Clarity</h2>
                        <p>
                            Our mission is to give Liberian schools simple, reliable tools
                            to manage their daily operations — from student records to
                            communication — so administrators spend less time on paperwork
                            and more time on what matters: educating students.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="mission_vision_text">
                        <span class="ti-eye sg-icon"></span>
                        <h5>Our Vision</h5>
                        <h2>A Digitally Connected School System Across Liberia</h2>
                        <p>
                            We envision a future where every school in Liberia, across all
                            15 counties, has access to modern school management tools —
                            working alongside the Ministry of Education to make that future
                            a reality.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- mission vision part end-->

    <!-- what schoolgear is part start-->
    <section class="platform_intro_part">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 text-center">
                    <div class="section_tittle text-center">
                        <span class="ti-layout-grid2-alt sg-icon"></span>
                        <h5>What SchoolGear Is</h5>
                        <h2>A School Management Platform Built for Real School Needs</h2>
                        <p>
                            SchoolGear brings the everyday work of running a school —
                            student records, attendance, communication, and administration —
                            into one connected, easy-to-use system. It's built to fit into
                            how Liberian schools actually operate, not to force them into a
                            foreign template.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- what schoolgear is part end-->

    <!-- our journey part start-->
    <section class="journey_part">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="section_tittle">
                        <h5>Our Journey</h5>
                        <h2>From an Idea to a Real School Partner</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="single_journey text-center">
                        <span class="ti-flag sg-icon"></span>
                        <h5>July 2024</h5>
                        <p>
                            SchoolGear was founded to solve a problem seen firsthand in
                            Liberian schools.
                        </p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="single_journey text-center">
                        <span class="ti-check-box sg-icon"></span>
                        <h5>2024</h5>
                        <p>
                            EDMOL Memorial Baptists High School became our first real school
                            partner.
                        </p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="single_journey text-center">
                        <span class="ti-arrow-right sg-icon"></span>
                        <h5>Next Steps</h5>
                        <p>
                            Expanding to serve more schools with the tools they need most.
                        </p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="single_journey text-center">
                        <span class="ti-world sg-icon"></span>
                        <h5>The Road Ahead</h5>
                        <p>
                            Working toward reaching schools across all 15 counties of
                            Liberia.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- our journey part end-->

    <!-- who we serve part start-->
    <section class="audience_part">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="section_tittle">
                        <h5>Who We Serve</h5>
                        <h2>Built for the People Who Run Schools Every Day</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="single_audience text-center">
                        <span class="ti-panel sg-icon"></span>
                        <h5>School Administrators</h5>
                        <p>Centralized records and less time on manual paperwork.</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="single_audience text-center">
                        <span class="ti-agenda sg-icon"></span>
                        <h5>Teachers & Staff</h5>
                        <p>Simple tools for attendance, grading, and communication.</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="single_audience text-center">
                        <span class="ti-user sg-icon"></span>
                        <h5>Students & Parents</h5>
                        <p>Clearer, faster access to school information that matters.</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="single_audience text-center">
                        <span class="ti-briefcase sg-icon"></span>
                        <h5>Ministry & Policy Partners</h5>
                        <p>A path toward consistent digital standards nationwide.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- who we serve part end-->

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

    <!--::review_part start::-->
    <section class="testimonial_part section_padding">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="section_tittle text-center">
                        <p>Our Impact</p>
                        <h2>Trusted by the People We Built SchoolGear For</h2>
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

@endsection

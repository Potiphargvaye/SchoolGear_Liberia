@extends('public.layouts.public')

@section('title', 'Fees Structure - Edmol MBHS')
@section('description', 'View school fees structure and payment information for Edmol MBHS.')
@section('canonical_url', 'https://www.edmolmbhs.com/fees-structure')
@section('content')

    <!-- ABOUT PAGE CONTENT GOES HERE -->

    <body>
        <div class="fees-structure">

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
                style="background-image: url('{{ asset('kiddos-school-master/images/fees-structure-image.jpg') }}');">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row no-gutters slider-text align-items-center justify-content-center">
                        <div class="col-md-9 ftco-animate text-center">
                            <h1 class="mb-2 bread">Fees-Structure</h1>
                            <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/') }}">Home <i
                                            class="ion-ios-arrow-forward"></i></a></span> <span>Pricing <i
                                        class="ion-ios-arrow-forward"></i></span></p>
                        </div>
                    </div>
                </div>
            </section>


            <section class="ftco-section">
                <div class="container">
                    <div class="row justify-content-center mb-5 pb-2">
                        <div class="col-md-8 text-center heading-section ftco-animate">
                            <h2 class="mb-4"><span>Our</span> Fees Structure</h2>

                            <p>
                                At Edmol Baptist School, our fees structure is designed to be transparent,
                                fair, and aligned with the Liberia Ministry of Education curriculum.
                                Fees are structured according to grade level and include registration,
                                tuition, and applicable academic support services.
                            </p>

                            <p class="mt-3">
                                <strong>Entrance Fees:</strong><br>
                                • Kindergarten & Elementary: <strong>L$500</strong><br>
                                • Junior & Senior High School: <strong>L$750</strong><br>
                                • Vacation School: <strong>L$1,500</strong>
                            </p>

                            <p class="mt-3">
                                <strong>Tuition Categories:</strong><br>
                                • Full Tuition-Paying Students<br>
                                • Scholarship / Financial Aid Students<br>
                                • Wards Deduction Students
                            </p>

                            <p class="mt-3">
                                For detailed information on registration and tuition fees by grade level,
                                please refer to the sections below.
                            </p>
                        </div>

                    </div>
                    <div class="row">
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
                                    <p>Our fees cover registration, tuition, and computer studies, ensuring quality
                                        education, skilled instruction, and essential learning resources..</p>
                                </div>
                                <p class="button text-center">
                                    <a href="#" class="btn btn-primary open-fee-modal" data-grade="Grade 12"
                                        data-fee="LRD 53,000.00 "
                                        data-details="
     <div class='table-responsive' style='max-height: 380px; overflow-y: auto;'>
       <table class='table table-bordered table-striped mb-0'>
         <tbody>
           <tr>
             <th>Registration</th>
             <td>LRD 2,500</td>
           </tr>
           <tr >
             <th >Tuition</th>
             <td><strong>LRD  28,500.00</strong></td>
           </tr>
          
           <tr>
             <th>ID Card</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>Badge</th>
             <td>LRD 200</td>
           </tr>
           <tr>
             <th>Breakage</th>
             <td>LRD 500</td>
           </tr>
           <tr>
             <th>Activities</th>
             <td>LRD 300</td>
           </tr>
           <tr>
             <th>Gala</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Computer Fees</th>
             <td>LRD 5,000</td>
           </tr>
           <tr>
             <th>Science Lab Coat</th>
             <td>LRD 3,000</td>
           </tr>
           <tr>                                                  
             <th>Science Lab Fees</th>
             <td>LRD 4,000</td>
           </tr>
           <tr>
             <th>Senior Class Shirt</th>
             <td>LRD 2,000</td>
           </tr>
           <tr>
             <th>First Aid</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Compulsory Saturday Class</th>
             <td>LRD 3,500</td>
           </tr>
           <tr>
             <th>Total</th>
             <td><strong>LRD 53,000.00 </strong></td>
           </tr>
         </tbody>
       </table>
     </div>
     <p class='mt-3 mb-0 text-muted small'>
       Covers registration, tuition, computer studies, assessments, and academic support.
     </p>
   ">
                                        Read more..
                                    </a>
                                </p>
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
                                    <p>Our fees cover registration, tuition, and computer studies, ensuring quality
                                        education, skilled instruction, and essential learning resources..</p>
                                </div>
                                <p class="button text-center">
                                    <a href="#" class="btn btn-primary open-fee-modal" data-grade="Grade 11"
                                        data-fee="LRD 47,500.00 "
                                        data-details="
     <div class='table-responsive' style='max-height: 380px; overflow-y: auto;'>
       <table class='table table-bordered table-striped mb-0'>
         <tbody>
           <tr>
             <th>Registration</th>
             <td>LRD 2,500</td>
           </tr>
           <tr >
             <th >Tuition</th>
             <td><strong>LRD 25,000</strong></td>
           </tr>
           <tr>
             <th>PE</th>
             <td>LRD 2,000</td>
           </tr>
           <tr>
             <th>ID Card</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>Badge</th>
             <td>LRD 200</td>
           </tr>
           <tr>
             <th>Breakage</th>
             <td>LRD 500</td>
           </tr>
           <tr>
             <th>Activities</th>
             <td>LRD 300</td>
           </tr>
           <tr>
             <th>Gala</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Computer Fees</th>
             <td>LRD 5,000</td>
           </tr>
           <tr>
             <th>Science Lab Coat</th>
             <td>LRD 3,000</td>
           </tr>
           <tr>
             <th>Science Lab Fees</th>
             <td>LRD 4,000</td>
           </tr>
           <tr>
             <th>Color House Shirt</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>First Aid</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Total</th>
             <td><strong>LRD 47,500.00</strong></td>
           </tr>
         </tbody>
       </table>
     </div>
     <p class='mt-3 mb-0 text-muted small'>
       Covers registration, tuition, computer studies, assessments, and academic support.
     </p>
   ">
                                        Read more..
                                    </a>
                                </p>
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
                                    <p>Our fees cover registration, tuition, and computer studies, ensuring quality
                                        education, skilled instruction, and essential learning resources..</p>
                                </div>
                                <p class="button text-center">
                                    <a href="#" class="btn btn-primary open-fee-modal" data-grade="Grade 10"
                                        data-fee="LRD 47,500.00 "
                                        data-details="
     <div class='table-responsive' style='max-height: 380px; overflow-y: auto;'>
       <table class='table table-bordered table-striped mb-0'>
         <tbody>
           <tr>
             <th>Registration</th>
             <td>LRD 2,500</td>
           </tr>
           <tr >
             <th >Tuition</th>
             <td><strong>LRD 25,000</strong></td>
           </tr>
           <tr>
             <th>PE</th>
             <td>LRD 2,000</td>
           </tr>
           <tr>
             <th>ID Card</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>Badge</th>
             <td>LRD 200</td>
           </tr>
           <tr>
             <th>Breakage</th>
             <td>LRD 500</td>
           </tr>
           <tr>
             <th>Activities</th>
             <td>LRD 300</td>
           </tr>
           <tr>
             <th>Gala</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Computer Fees</th>
             <td>LRD 5,000</td>
           </tr>
           <tr>
             <th>Science Lab Coat</th>
             <td>LRD 3,000</td>
           </tr>
           <tr>
             <th>Science Lab Fees</th>
             <td>LRD 4,000</td>
           </tr>
           <tr>
             <th>Color House Shirt</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>First Aid</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Total</th>
             <td><strong>LRD 47,500.00</strong></td>
           </tr>
         </tbody>
       </table>
     </div>
     <p class='mt-3 mb-0 text-muted small'>
       Covers registration, tuition, computer studies, assessments, and academic support.
     </p>
   ">
                                        Read more..
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 ftco-animate">
                            <div class="pricing-entry bg-light pb-4 text-center">
                                <div>
                                    <h3 class="mb-3">Grade 9th</h3>
                                    <p><span class="price">LRD$40,875</span> <span class="per">Per/Year</span></p>
                                </div>
                                <div class="img"
                                    style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                                </div>

                                <div class="px-4">
                                    <p>Our fees cover registration, tuition, and computer studies, ensuring quality
                                        education, skilled instruction, and essential learning resources..</p>
                                </div>
                                <p class="button text-center">
                                    <a href="#" class="btn btn-primary open-fee-modal" data-grade="Grade 9"
                                        data-fee="LRD 40,875.00 "
                                        data-details="
     <div class='table-responsive' style='max-height: 380px; overflow-y: auto;'>
       <table class='table table-bordered table-striped mb-0'>
         <tbody>
           <tr>
             <th>Registration</th>
             <td>LRD 2,500</td>
           </tr>
           <tr >
             <th >Tuition</th>
             <td><strong>LRD 23,125.00</strong></td>
           </tr>
           <tr>
             <th>PE</th>
             <td>LRD 2,000</td>
           </tr>
           <tr>
             <th>ID Card</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>Badge</th>
             <td>LRD 200</td>
           </tr>
           <tr>
             <th>Breakage</th>
             <td>LRD 500</td>
           </tr>
           <tr>
             <th>Activities</th>
             <td>LRD 300</td>
           </tr>
           <tr>
             <th>Gala</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Computer Fees</th>
             <td>LRD 5,000</td>
           </tr>
        
           <tr>
             <th>Color House Shirt</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>First Aid</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Compulsory Saturday Class</th>
             <td>LRD 2,500</td>
           </tr>
           <tr>
             <th>Total</th>
             <td><strong>LRD 40,875.00</strong></td>
           </tr>
         </tbody>
       </table>
     </div>
     <p class='mt-3 mb-0 text-muted small'>
       Covers registration, tuition, computer studies, assessments, and academic support.
     </p>
   ">
                                        Read more..
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Our Fees Structure -->

            <section class="ftco-section">
                <div class="container">
                    <div class="row justify-content-center mb-5 pb-2">
                        <div class="col-md-8 text-center heading-section ftco-animate">
                            <h2 class="mb-4"><span>Jenior </span>High</h2>
                            <p>Transparent and affordable tuition structure in line with the Liberia Ministry of Education
                                curriculum. For detailed information on fees for other grade levels, kindly click the Read
                                More button.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-3 ftco-animate">
                            <div class="pricing-entry bg-light pb-4 text-center">
                                <div>
                                    <h3 class="mb-3">Grade 8th</h3>
                                    <p><span class="price">LRD$38,375</span> <span class="per">Per/Year</span></p>
                                </div>
                                <div class="img"
                                    style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                                </div>

                                <div class="px-4">
                                    <p>Our fees cover registration, tuition, and computer studies, ensuring quality
                                        education, skilled instruction, and essential learning resources..</p>
                                </div>
                                <p class="button text-center">
                                    <a href="#" class="btn btn-primary open-fee-modal" data-grade="Grade 8"
                                        data-fee="LRD 38,375.00"
                                        data-details="
     <div class='table-responsive' style='max-height: 380px; overflow-y: auto;'>
       <table class='table table-bordered table-striped mb-0'>
         <tbody>      
           <tr>
             <th>Registration</th>
             <td>LRD 2,500</td>
           </tr>
           <tr> 
             <th >Tuition</th>
             <td><strong>LRD 23,125.00</strong></td>
           </tr>
           <tr>
             <th>PE</th>
             <td>LRD 2,000</td>
           </tr>
           <tr>
             <th>ID Card</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>Badge</th>
             <td>LRD 200</td>
           </tr>
           <tr>
             <th>Breakage</th>
             <td>LRD 500</td>
           </tr>
           <tr>
             <th>Activities</th>
             <td>LRD 300</td>
           </tr>
           <tr>
             <th>Gala</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Computer Fees</th>
             <td>LRD 5,000</td>
           </tr>
        
           <tr>
             <th>Color House Shirt</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>First Aid</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Compulsory Saturday Class</th>
             <td>N/A</td>
           </tr>
           <tr>
             <th>Total</th>
             <td><strong>LRD 38,375.00</strong></td>
           </tr>
         </tbody>
       </table>
     </div>
     <p class='mt-3 mb-0 text-muted small'>
       Covers registration, tuition, computer studies, assessments, and academic support.
     </p>
   ">
                                        Read more..
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 ftco-animate">
                            <div class="pricing-entry bg-light pb-4 text-center">
                                <div>
                                    <h3 class="mb-3">Grade 7th</h3>
                                    <p><span class="price">LRD$38,375</span> <span class="per">Per/Year</span></p>
                                </div>
                                <div class="img"
                                    style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                                </div>
                                <div class="px-4">
                                    <p>Our fees cover registration, tuition, and computer studies, ensuring quality
                                        education, skilled instruction, and essential learning resources..</p>
                                </div>
                                <p class="button text-center">
                                    <a href="#" class="btn btn-primary open-fee-modal" data-grade="Grade 7"
                                        data-fee="LRD 38,375.00"
                                        data-details="
     <div class='table-responsive' style='max-height: 380px; overflow-y: auto;'>
       <table class='table table-bordered table-striped mb-0'>
         <tbody>      
           <tr>
             <th>Registration</th>
             <td>LRD 2,500</td>
           </tr>
           <tr> 
             <th >Tuition</th>
             <td><strong>LRD 23,125.00</strong></td>
           </tr>
           <tr>
             <th>PE</th>
             <td>LRD 2,000</td>
           </tr>
           <tr>
             <th>ID Card</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>Badge</th>
             <td>LRD 200</td>
           </tr>
           <tr>
             <th>Breakage</th>
             <td>LRD 500</td>
           </tr>
           <tr>
             <th>Activities</th>
             <td>LRD 300</td>
           </tr>
           <tr>
             <th>Gala</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Computer Fees</th>
             <td>LRD 5,000</td>
           </tr>
        
           <tr>
             <th>Color House Shirt</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>First Aid</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Compulsory Saturday Class</th>
             <td>N/A</td>
           </tr>
           <tr>
             <th>Total</th>
             <td><strong>LRD 38,375.00</strong></td>
           </tr>
         </tbody>
       </table>
     </div>
     <p class='mt-3 mb-0 text-muted small'>
       Covers registration, tuition, computer studies, assessments, and academic support.
     </p>
   ">
                                        Read more..
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 ftco-animate">
                            <div class="pricing-entry bg-light active pb-4 text-center">
                                <div>
                                    <h3 class="mb-3">Grade 6th</h3>
                                    <p><span class="price">LRD$40,875</span> <span class="per">Per/Year</span></p>
                                </div>
                                <div class="img"
                                    style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                                </div>

                                <div class="px-4">
                                    <p>Our fees cover registration, tuition, and computer studies, ensuring quality
                                        education, skilled instruction, and essential learning resources..</p>
                                </div>
                                <p class="button text-center">
                                    <a href="#" class="btn btn-primary open-fee-modal" data-grade="Grade 6"
                                        data-fee="LRD 40,875.00"
                                        data-details="
     <div class='table-responsive' style='max-height: 380px; overflow-y: auto;'>
       <table class='table table-bordered table-striped mb-0'>
         <tbody>      
           <tr>
             <th>Registration</th>
             <td>LRD 2,250</td>
           </tr>
           <tr> 
             <th >Tuition</th>
             <td><strong>LRD 21,625.00</strong></td>
           </tr>
           <tr>
             <th>PE</th>
             <td>N/A</td>
           </tr>
           <tr>
             <th>Track Suit</th>
             <td>4,000</td>
           </tr>
           <tr>
             <th>ID Card</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>Badge</th>
             <td>LRD 200</td>
           </tr>
           <tr>
             <th>Breakage</th>
             <td>LRD 500</td>
           </tr>
           <tr>
             <th>Activities</th>
             <td>LRD 300</td>
           </tr>
           <tr>
             <th>Gala</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Computer Fees</th>
             <td>LRD 5,000</td>
           </tr>
        
           <tr>
             <th>Color House Shirt</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>First Aid</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Compulsory Saturday Class</th>
             <td>2,000</td>
           </tr>
           <tr>
             <th>Total</th>
             <td><strong>LRD 40,875.00</strong></td>
           </tr>
         </tbody>
       </table>
     </div>
     <p class='mt-3 mb-0 text-muted small'>
       Covers registration, tuition, computer studies, assessments, and academic support.
     </p>
   ">
                                        Read more..
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 ftco-animate">
                            <div class="pricing-entry bg-light pb-4 text-center">
                                <div>
                                    <h3 class="mb-3">Grade 5th</h3>
                                    <p><span class="price">LRD$39,875</span> <span class="per">Per/Year</span></p>
                                </div>
                                <div class="img"
                                    style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                                </div>
                                <div class="px-4">
                                    <p>Our fees cover registration, tuition, and computer studies, ensuring quality
                                        education, skilled instruction, and essential learning resources..</p>
                                </div>
                                <p class="button text-center">
                                    <a href="#" class="btn btn-primary open-fee-modal" data-grade="Grade 5"
                                        data-fee="LRD 39,875.00"
                                        data-details="
     <div class='table-responsive' style='max-height: 380px; overflow-y: auto;'>
       <table class='table table-bordered table-striped mb-0'>
         <tbody>      
           <tr>
             <th>Registration</th>
             <td>LRD 2,250</td>
           </tr>
           <tr> 
             <th >Tuition</th>
             <td><strong>LRD 21,625.00</strong></td>
           </tr>
           <tr>
             <th>PE</th>
             <td>N/A</td>
           </tr>
           <tr>
             <th>Track Suit</th>
             <td>4,000</td>
           </tr>
           <tr>
             <th>ID Card</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>Badge</th>
             <td>LRD 200</td>
           </tr>
           <tr>
             <th>Breakage</th>
             <td>LRD 500</td>
           </tr>
           <tr>
             <th>Activities</th>
             <td>LRD 300</td>
           </tr>
           <tr>
             <th>Gala</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Computer Fees</th>
             <td>N/A</td>
           </tr>
        
           <tr>
             <th>Color House Shirt</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>First Aid</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Compulsory Study Class</th>
             <td>6,000.00</td>
           </tr>
           <tr>
             <th>Total</th>
             <td><strong>LRD  39,875.00 </strong></td>
           </tr>
         </tbody>
       </table>
     </div>
     <p class='mt-3 mb-0 text-muted small'>
       Covers registration, tuition, computer studies, assessments, and academic support.
     </p>
   ">
                                        Read more..
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Our Fees Structure -->

            <section class="ftco-section">
                <div class="container">
                    <div class="row justify-content-center mb-5 pb-2">
                        <div class="col-md-8 text-center heading-section ftco-animate">
                            <h2 class="mb-4"><span>Jenior </span>High</h2>
                            <p>Transparent and affordable tuition structure in line with the Liberia Ministry of Education
                                curriculum. For detailed information on fees for other grade levels, kindly click the Read
                                More button.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-3 ftco-animate">
                            <div class="pricing-entry bg-light pb-4 text-center">
                                <div>
                                    <h3 class="mb-3">Grade 4th</h3>
                                    <p><span class="price">LRD$39,875</span> <span class="per">Per/Year</span></p>
                                </div>
                                <div class="img"
                                    style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                                </div>

                                <div class="px-4">
                                    <p>Grade 4 tuition includes registration, structured academic instruction, and essential
                                        learning materials to support student growth..</p>
                                </div>

                                <p class="button text-center">
                                    <a href="#" class="btn btn-primary open-fee-modal" data-grade="Grade 4"
                                        data-fee="LRD 39,875.00"
                                        data-details="
     <div class='table-responsive' style='max-height: 380px; overflow-y: auto;'>
       <table class='table table-bordered table-striped mb-0'>
         <tbody>      
           <tr>
             <th>Registration</th>
             <td>LRD 2,250</td>
           </tr>
           <tr> 
             <th >Tuition</th>
             <td><strong>LRD 21,625.00</strong></td>
           </tr>
           <tr>
             <th>PE</th>
             <td>N/A</td>
           </tr>
           <tr>
             <th>Track Suit</th>
             <td>4,000</td>
           </tr>
           <tr>
             <th>ID Card</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>Badge</th>
             <td>LRD 200</td>
           </tr>
           <tr>
             <th>Breakage</th>
             <td>LRD 500</td>
           </tr>
           <tr>
             <th>Activities</th>
             <td>LRD 300</td>
           </tr>
           <tr>
             <th>Gala</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Computer Fees</th>
             <td>N/A</td>
           </tr>
        
           <tr>
             <th>Color House Shirt</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>First Aid</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Compulsory Study Class</th>
             <td>6,000.00</td>
           </tr>
           <tr>
             <th>Total</th>
             <td><strong>LRD  39,875.00 </strong></td>
           </tr>
         </tbody>
       </table>
     </div>
     <p class='mt-3 mb-0 text-muted small'>
       Covers registration, tuition, computer studies, assessments, and academic support.
     </p>
   ">
                                        Read more..
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 ftco-animate">
                            <div class="pricing-entry bg-light pb-4 text-center">
                                <div>
                                    <h3 class="mb-3">Grade 3th</h3>
                                    <p><span class="price">LRD$37,625</span> <span class="per">Per/Year</span></p>
                                </div>
                                <div class="img"
                                    style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                                </div>
                                <div class="px-4">
                                    <p>Grade 3 tuition covers registration, classroom instruction, and essential resources
                                        that reinforce academic development..</p>
                                </div>
                                <p class="button text-center">
                                    <a href="#" class="btn btn-primary open-fee-modal" data-grade="Grade 3"
                                        data-fee="LRD 37,625.00"
                                        data-details="
     <div class='table-responsive' style='max-height: 380px; overflow-y: auto;'>
       <table class='table table-bordered table-striped mb-0'>
         <tbody>      
           <tr>
             <th>Registration</th>
             <td>LRD 2,250</td>
           </tr>
           <tr> 
             <th >Tuition</th>
             <td><strong>LRD 19,375.00</strong></td>
           </tr>
           <tr>
             <th>PE</th>
             <td>N/A</td>
           </tr>
           <tr>
             <th>Track Suit</th>
             <td>4,000</td>
           </tr>
           <tr>
             <th>ID Card</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>Badge</th>
             <td>LRD 200</td>
           </tr>
           <tr>
             <th>Breakage</th>
             <td>LRD 500</td>
           </tr>
           <tr>
             <th>Activities</th>
             <td>LRD 300</td>
           </tr>
           <tr>
             <th>Gala</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Computer Fees</th>
             <td>N/A</td>
           </tr>
        
           <tr>
             <th>Color House Shirt</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>First Aid</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Compulsory Study Class</th>
             <td>6,000.00</td>
           </tr>
           <tr>
             <th>Total</th>
             <td><strong>LRD 37,625.00 </strong></td>
           </tr>
         </tbody>
       </table>
     </div>
     <p class='mt-3 mb-0 text-muted small'>
       Covers registration, tuition, computer studies, assessments, and academic support.
     </p>
   ">
                                        Read more..
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 ftco-animate">
                            <div class="pricing-entry bg-light active pb-4 text-center">
                                <div>
                                    <h3 class="mb-3">Grade 2th</h3>
                                    <p><span class="price">LRD$37,625</span> <span class="per">Per/Year</span></p>
                                </div>
                                <div class="img"
                                    style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                                </div>

                                <div class="px-4">
                                    <p>Grade 2 tuition includes registration, structured academic instruction, and learning
                                        materials that support steady progress..</p>
                                </div>
                                <p class="button text-center">
                                    <a href="#" class="btn btn-primary open-fee-modal" data-grade="Grade 2"
                                        data-fee="LRD 37,625.00"
                                        data-details="
     <div class='table-responsive' style='max-height: 380px; overflow-y: auto;'>
       <table class='table table-bordered table-striped mb-0'>
         <tbody>      
           <tr>
             <th>Registration</th>
             <td>LRD 2,250</td>
           </tr>
           <tr> 
             <th >Tuition</th>
             <td><strong>LRD 19,375.00</strong></td>
           </tr>
           <tr>
             <th>PE</th>
             <td>N/A</td>
           </tr>
           <tr>
             <th>Track Suit</th>
             <td>4,000</td>
           </tr>
           <tr>
             <th>ID Card</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>Badge</th>
             <td>LRD 200</td>
           </tr>
           <tr>
             <th>Breakage</th>
             <td>LRD 500</td>
           </tr>
           <tr>
             <th>Activities</th>
             <td>LRD 300</td>
           </tr>
           <tr>
             <th>Gala</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Computer Fees</th>
             <td>N/A</td>
           </tr>
        
           <tr>
             <th>Color House Shirt</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>First Aid</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Compulsory Study Class</th>
             <td>6,000.00</td>
           </tr>
           <tr>
             <th>Total</th>
             <td><strong>LRD 37,625.00 </strong></td>
           </tr>
         </tbody>
       </table>
     </div>
     <p class='mt-3 mb-0 text-muted small'>
       Covers registration, tuition, computer studies, assessments, and academic support.
     </p>
   ">
                                        Read more..
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 ftco-animate">
                            <div class="pricing-entry bg-light pb-4 text-center">
                                <div>
                                    <h3 class="mb-3">Grade 1st</h3>
                                    <p><span class="price">LRD$37,625</span> <span class="per">Per/Year</span></p>
                                </div>
                                <div class="img"
                                    style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                                </div>
                                <div class="px-4">
                                    <p>Grade 1 tuition includes registration, core academic instruction, and essential
                                        learning resources for strong foundations..</p>
                                </div>
                                <p class="button text-center">
                                    <a href="#" class="btn btn-primary open-fee-modal" data-grade="Grade 1"
                                        data-fee="LRD 37,625.00"
                                        data-details="
     <div class='table-responsive' style='max-height: 380px; overflow-y: auto;'>
       <table class='table table-bordered table-striped mb-0'>
         <tbody>      
           <tr>
             <th>Registration</th>
             <td>LRD 2,250</td>
           </tr>
           <tr> 
             <th >Tuition</th>
             <td><strong>LRD 19,375.00</strong></td>
           </tr>
           <tr>
             <th>PE</th>
             <td>N/A</td>
           </tr>
           <tr>
             <th>Track Suit</th>
             <td>4,000</td>
           </tr>
           <tr>
             <th>ID Card</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>Badge</th>
             <td>LRD 200</td>
           </tr>
           <tr>
             <th>Breakage</th>
             <td>LRD 500</td>
           </tr>
           <tr>
             <th>Activities</th>
             <td>LRD 300</td>
           </tr>
           <tr>
             <th>Gala</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Computer Fees</th>
             <td>N/A</td>
           </tr>
        
           <tr>
             <th>Color House Shirt</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>First Aid</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Compulsory Study Class</th>
             <td>6,000.00</td>
           </tr>
           <tr>
             <th>Total</th>
             <td><strong>LRD 37,625.00 </strong></td>
           </tr>
         </tbody>
       </table>
     </div>
     <p class='mt-3 mb-0 text-muted small'>
       Covers registration, tuition, computer studies, assessments, and academic support.
     </p>
   ">
                                        Read more..
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>



            <!-- Our Fees Structure -->

            <section class="ftco-section">
                <div class="container">
                    <div class="row justify-content-center mb-5 pb-2">
                        <div class="col-md-8 text-center heading-section ftco-animate">
                            <h2 class="mb-4"><span>Jenior </span>High</h2>
                            <p>Transparent and affordable tuition structure in line with the Liberia Ministry of Education
                                curriculum. For detailed information on fees for other grade levels, kindly click the Read
                                More button.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-3 ftco-animate">
                            <div class="pricing-entry bg-light pb-4 text-center">
                                <div>
                                    <h3 class="mb-3">K-Gs</h3>
                                    <p><span class="price">LRD$36,250.00 </span> <span class="per">Per/Year</span></p>
                                </div>
                                <div class="img"
                                    style="background-image: url('{{ asset('kiddos-school-master/images/edmol-orginal-logo (2).png') }}');">
                                </div>

                                <div class="px-4">
                                    <p>KG tuition covers registration, foundational instruction, and learning materials to
                                        support early childhood development...</p>
                                </div>
                                <p class="button text-center">
                                    <a href="#" class="btn btn-primary open-fee-modal" data-grade="Grade K -Gs"
                                        data-fee="LRD 36,250.00 "
                                        data-details="
     <div class='table-responsive' style='max-height: 380px; overflow-y: auto;'>
       <table class='table table-bordered table-striped mb-0'>
         <tbody>      
           <tr>
             <th>Registration</th>
             <td>LRD 2,000</td>
           </tr>
           <tr> 
             <th >Tuition</th>
             <td><strong>LRD 18,250.00</strong></td>
           </tr>
           <tr>
             <th>PE</th>
             <td>N/A</td>
           </tr>
           <tr>
             <th>Track Suit</th>
             <td>4,000</td>
           </tr>
           <tr>
             <th>ID Card</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>Badge</th>
             <td>LRD 200</td>
           </tr>
           <tr>
             <th>Breakage</th>
             <td>LRD 500</td>
           </tr>
           <tr>
             <th>Activities</th>
             <td>LRD 300</td>
           </tr>
           <tr>
             <th>Gala</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Computer Fees</th>
             <td>N/A</td>
           </tr>
        
           <tr>
             <th>Color House Shirt</th>
             <td>LRD 1,500</td>
           </tr>
           <tr>
             <th>First Aid</th>
             <td>LRD 1,000</td>
           </tr>
           <tr>
             <th>Compulsory Study Class</th>
             <td>6,000.00</td>
           </tr>
           <tr>
             <th>Total</th>
             <td><strong>LRD 36,250.00  </strong></td>
           </tr>
         </tbody>
       </table>
     </div>
     <p class='mt-3 mb-0 text-muted small'>
       Covers registration, tuition, computer studies, assessments, and academic support.
     </p>
   ">
                                        Read more..
                                    </a>
                                </p>
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
        <!-- jsPDF CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


        <!-- ===== Fee Details Modal ===== -->
        <div id="feeModal" class="fee-modal">
            <div class="fee-modal-content">
                <span class="fee-close">&times;</span>

                <!-- MODAL CONTENT -->
                <h3 id="modalGrade" class="modal-title"></h3>
                <p class="modal-fee" id="modalFee"></p>

                <div class="modal-body" id="modalDetails"></div>

                <div class="modal-actions">
                    <button id="downloadBtn" onclick="downloadSheet()">⬇️ Download PDF</button>
                </div>

            </div>
        </div>

        <!-- WhatsApp Floating Button -->
        <a href="https://wa.me/250794241623" target="_blank" class="whatsapp-float" aria-label="Message us on WhatsApp">
            <i class="fab fa-whatsapp"></i>
            <span class="whatsapp-tooltip">Message us on WhatsApp</span>
        </a>

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                const modal = document.getElementById("feeModal");
                const gradeEl = document.getElementById("modalGrade");
                const feeEl = document.getElementById("modalFee");
                const detailsEl = document.getElementById("modalDetails");
                const closeBtn = document.querySelector(".fee-close");

                document.querySelectorAll(".open-fee-modal").forEach(button => {
                    button.addEventListener("click", function(e) {
                        e.preventDefault();

                        gradeEl.textContent = this.dataset.grade;
                        feeEl.textContent = "Total Annual Fee: " + this.dataset.fee;
                        detailsEl.innerHTML = this.dataset.details;

                        modal.style.display = "flex";
                        document.body.style.overflow = "hidden";
                    });
                });

                closeBtn.addEventListener("click", closeModal);
                window.addEventListener("click", e => {
                    if (e.target === modal) closeModal();
                });

                function closeModal() {
                    modal.style.display = "none";
                    document.body.style.overflow = "auto";
                }

            });

            function downloadSheet() {
                alert("PDF download will be connected later.");
            }
        </script>



        <script>
            function downloadSheet() {
                const button = document.getElementById("downloadBtn");
                const grade = document.getElementById("modalGrade").textContent;
                const fee = document.getElementById("modalFee").textContent;
                const details = document.getElementById("modalDetails").innerHTML;

                // Loading effect
                button.style.opacity = "0.9";
                button.classList.add("loading");
                button.innerHTML = `⬇️ Generating PDF <span class="spinner">⏳</span>`;

                setTimeout(() => {

                    const {
                        jsPDF
                    } = window.jspdf;

                    const doc = new jsPDF({
                        orientation: "portrait",
                        unit: "pt",
                        format: "a4"
                    });

                    const margin = 40;
                    let yPos = 60;

                    const pageWidth = doc.internal.pageSize.getWidth();

                    // ================================
                    // WATERMARK LOGO
                    // ================================  
                    // Watermark
                    const logo = new Image();
                    logo.src = "/kiddos-school-master/images/edmol-orginal-logo.png";

                    // apply transparency
                    doc.setGState(new doc.GState({
                        opacity: 0.08
                    }));

                    doc.addImage(logo, "JPEG", 140, 200, 300, 300);

                    // reset transparency
                    doc.setGState(new doc.GState({
                        opacity: 1
                    }));
                    // ================================
                    // SCHOOL HEADER
                    // ================================

                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(18);
                    doc.setTextColor("#0a1f44");

                    doc.text(
                        "EDMOL MEMORIAL MATADI BAPTIST HIGH SCHOOL",
                        pageWidth / 2,
                        yPos, {
                            align: "center"
                        }
                    );

                    yPos += 18;

                    doc.setFont("helvetica", "normal");
                    doc.setFontSize(11);
                    doc.setTextColor("#000");

                    doc.text(
                        "New Matadi Estate Drive, Opposite Don Bosco Youth Center",
                        pageWidth / 2,
                        yPos, {
                            align: "center"
                        }
                    );

                    yPos += 14;

                    doc.text(
                        "P.O. Box: 4330 Monrovia, Liberia",
                        pageWidth / 2,
                        yPos, {
                            align: "center"
                        }
                    );

                    yPos += 14;

                    doc.text(
                        "Email: emmmbhs@gmail.com | 0777-151-394 | 0771-761-098 | 0555-472-972",
                        pageWidth / 2,
                        yPos, {
                            align: "center"
                        }
                    );

                    yPos += 25;

                    // Divider
                    doc.setDrawColor("#0a1f44");
                    doc.setLineWidth(1);
                    doc.line(margin, yPos, pageWidth - margin, yPos);

                    yPos += 30;

                    // ================================
                    // DOCUMENT TITLE
                    // ================================

                    doc.setFontSize(16);
                    doc.setTextColor("#0a1f44");
                    doc.setFont("helvetica", "bold");

                    doc.text("OFFICIAL SCHOOL FEES STRUCTURE", pageWidth / 2, yPos, {
                        align: "center"
                    });

                    yPos += 30;

                    // Grade title
                    doc.setFontSize(14);
                    doc.setTextColor("#000");

                    doc.text(`${grade} - ${fee}`, margin, yPos);

                    yPos += 25;

                    // ================================
                    // CONVERT TABLE
                    // ================================

                    const tempDiv = document.createElement("div");
                    tempDiv.innerHTML = details;

                    const tableRows = Array.from(tempDiv.querySelectorAll("tr")).map(tr =>
                        Array.from(tr.children).map(td => td.textContent.trim())
                    );

                    doc.setFontSize(11);

                    tableRows.forEach(row => {
                        const line = row.join("   |   ");
                        doc.text(line, margin, yPos);
                        yPos += 18;
                    });

                    // ================================
                    // FOOTER
                    // ================================

                    yPos += 40;

                    doc.setFontSize(10);
                    doc.setTextColor("#444");

                    doc.text(
                        `Generated on: ${new Date().toLocaleDateString()} ${new Date().toLocaleTimeString()}`,
                        margin,
                        yPos
                    );

                    yPos += 15;

                    doc.text(
                        "This document is system-generated and valid without a stamp.",
                        margin,
                        yPos
                    );


                    // ================================
                    // DIGITAL SIGNATURE AREA
                    // ================================

                    yPos += 40;

                    doc.line(pageWidth - 220, yPos, pageWidth - 60, yPos);

                    yPos += 12;

                    doc.setFontSize(10);

                    doc.text(
                        "School Administration",
                        pageWidth - 140,
                        yPos, {
                            align: "center"
                        }
                    );

                    yPos += 14;

                    doc.text(
                        "Authorized Digital Signature",
                        pageWidth - 140,
                        yPos, {
                            align: "center"
                        }
                    );

                    // Save PDF
                    doc.save(`${grade.replace(/\s+/g,'_')}_Fees_Structure.pdf`);

                    // Reset button
                    button.classList.remove("loading");
                    button.innerHTML = "⬇️ Download PDF";

                }, 600);
            }
            //==== Redirecting stste script =======

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

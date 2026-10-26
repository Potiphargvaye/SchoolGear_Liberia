@extends('public.layouts.public')

@section('title', 'School Management System in Liberia | SchoolGear Liberia')

@section('description')
    SchoolGear Liberia is school administration software for Liberian schools: manage admissions, student records, fees,
    grades and report cards in one platform.
@endsection

@push('json-ld')
    @php
        $structuredHost = preg_replace('/^www\./i', '', parse_url(config('app.url'), PHP_URL_HOST));
        $structuredUrl = 'https://' . $structuredHost;
        $organizationData = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'SchoolGear Liberia',
            'url' => $structuredUrl,
            'telephone' => '+231 77 012 3498',
            'address' => 'Airfield, Sinkor, Monrovia, Liberia',
        ];
        if (file_exists(public_path('logo/download.png'))) {
            $organizationData['logo'] = $structuredUrl . '/logo/download.png';
        }
        $websiteData = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'SchoolGear Liberia',
            'url' => $structuredUrl,
        ];
        $applicationData = [
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => 'SchoolGear Liberia',
            'url' => $structuredUrl,
            'applicationCategory' => 'EducationalApplication',
            'operatingSystem' => 'Web',
            'description' =>
                'School management tools for admissions, enrollment, fees, grades, report cards, and student records.',
        ];
    @endphp
    <script type="application/ld+json">@json($organizationData)</script>
    <script type="application/ld+json">@json($websiteData)</script>
    <script type="application/ld+json">@json($applicationData)</script>
@endpush

@push('styles')
    <link rel="stylesheet"
        href="{{ asset('schoolGear_liberia_public_site/css/sg-home.css') }}?v={{ @filemtime(public_path('schoolGear_liberia_public_site/css/sg-home.css')) }}">
@endpush

@section('content')
    <main class="sg-home">
        <section class="sg-home-hero" aria-labelledby="sg-home-title">
            <div class="container">
                <div class="sg-home-hero-panel">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-6">
                            <div class="sg-home-hero-copy">
                                <p class="sg-home-eyebrow sg-home-hero-eyebrow">Built for Schools. Designed for Liberia.</p>
                                <h1 id="sg-home-title">Run Your School Smarter with SchoolGear Liberia</h1>
                                <p class="sg-home-hero-lead">SchoolGear is an all-in-one school management system that helps
                                    Liberian schools simplify admissions, manage students and staff, track academics, handle
                                    fees, and keep the entire school connected all in one place.</p>
                                <div class="sg-home-actions">
                                    <a href="{{ route('public.register') }}" class="sg-home-button sg-home-button-light">Get
                                        Started Free</a>
                                    <a href="{{ url('/book-demo') }}" class="sg-home-button sg-home-button-outline">Book a
                                        Live Demo</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="sg-home-preview" data-sg-home-preview>
                                <div class="sg-home-preview-heading"><span class="sg-home-preview-label">A look inside
                                        SchoolGear</span><span class="sg-home-preview-status"><i aria-hidden="true"></i>
                                        Product preview</span></div>
                                <div class="sg-home-preview-window" role="region" aria-roledescription="carousel"
                                    aria-label="Illustration of the SchoolGear dashboard, grade entry sheet and fees screens, using sample data">
                                    <article class="sg-home-preview-slide is-active" data-preview-slide aria-hidden="false"
                                        aria-label="1 of 3: Dashboard overview">
                                        <div class="sg-home-appbar"><span class="sg-home-app-mark" aria-hidden="true"><i
                                                    class="ti-layers"></i></span><strong>School overview</strong><span
                                                class="sg-home-app-chip">Sample</span></div>
                                        <div class="sg-home-app-layout">
                                            <aside class="sg-home-app-sidebar" aria-label="Sample navigation">
                                                <span class="is-current"><i class="ti-dashboard"
                                                        aria-hidden="true"></i><b>Overview</b></span>
                                                <span><i class="ti-user" aria-hidden="true"></i><b>Students</b></span>
                                                <span><i class="ti-book" aria-hidden="true"></i><b>Academics</b></span>
                                                <span><i class="ti-wallet" aria-hidden="true"></i><b>Fees</b></span>
                                                <span><i class="ti-lock" aria-hidden="true"></i><b>Roles &amp;
                                                        Permissions</b></span>
                                                <span><i class="ti-calendar" aria-hidden="true"></i><b>Attendance</b></span>
                                                <span><i class="ti-pencil-alt" aria-hidden="true"></i><b>Grade
                                                        Entry</b></span>
                                                <span><i class="ti-id-badge" aria-hidden="true"></i><b>Enrollment</b></span>
                                                <span><i class="ti-clipboard" aria-hidden="true"></i><b>Report
                                                        Cards</b></span>
                                            </aside>
                                            <div class="sg-home-app-main">
                                                <p class="sg-home-preview-kicker">Dashboard overview</p>
                                                <div class="sg-home-preview-stats">
                                                    <div><span>Students</span><strong>120</strong><small>Sample</small>
                                                    </div>
                                                    <div><span>Grades</span><strong>8</strong><small>Sample</small></div>
                                                    <div><span>Fees</span><strong>24</strong><small>Sample</small></div>
                                                </div>
                                                <div class="sg-home-preview-dashboard-lower">
                                                    <div class="sg-home-mini-chart">
                                                        <div class="sg-home-preview-title">Academic progress
                                                            <span>Sample</span>
                                                        </div><svg viewBox="0 0 300 90" role="img"
                                                            aria-label="Illustrative upward line chart">
                                                            <path
                                                                d="M12 72 C45 63 54 69 83 52 S124 59 151 39 S194 47 220 27 S267 35 288 12"
                                                                fill="none" stroke="#5B3DE0" stroke-width="4"
                                                                stroke-linecap="round" />
                                                            <path
                                                                d="M12 72 C45 63 54 69 83 52 S124 59 151 39 S194 47 220 27 S267 35 288 12 L288 86 L12 86Z"
                                                                fill="rgba(91,61,224,.11)" />
                                                            <circle cx="151" cy="39" r="5" fill="#38BDF8" />
                                                            <circle cx="288" cy="12" r="5" fill="#38BDF8" />
                                                        </svg>
                                                        <div class="sg-home-chart-legend">
                                                            <span>Earlier</span><span>Current</span>
                                                        </div>
                                                    </div>
                                                    <div class="sg-home-preview-announcements">
                                                        <div class="sg-home-preview-title">Announcements</div>
                                                        <p><i aria-hidden="true"></i> School update <small>Sample
                                                                item</small></p>
                                                        <p><i aria-hidden="true"></i> Class notice <small>Sample
                                                                item</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    <article class="sg-home-preview-slide" data-preview-slide aria-hidden="true"
                                        aria-label="2 of 3: Grade entry sheet">
                                        <div class="sg-home-appbar"><span class="sg-home-app-mark" aria-hidden="true"><i
                                                    class="ti-layers"></i></span><strong>Academic records</strong><span
                                                class="sg-home-app-chip">Sample</span></div>
                                        <div class="sg-home-grade-screen">
                                            <p class="sg-home-preview-kicker">Grade entry sheet</p>
                                            <p class="sg-home-grade-context">Grade 5 <span>•</span> Sample subject</p>
                                            <div class="sg-home-grade-table-wrap">
                                                <table class="sg-home-grade-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Student</th>
                                                            <th>1st Period</th>
                                                            <th>2nd Period</th>
                                                            <th>Exam</th>
                                                            <th>Total</th>
                                                            <th>Grade</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>Mary</th>
                                                            <td>20</td>
                                                            <td>20</td>
                                                            <td>50</td>
                                                            <td>90</td>
                                                            <td>A</td>
                                                        </tr>
                                                        <tr>
                                                            <th>John</th>
                                                            <td>18</td>
                                                            <td>19</td>
                                                            <td>45</td>
                                                            <td>82</td>
                                                            <td>B</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Blessing</th>
                                                            <td>16</td>
                                                            <td>18</td>
                                                            <td>42</td>
                                                            <td>76</td>
                                                            <td>B</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <p class="sg-home-grade-note"><span aria-hidden="true"></span> Highlighted cell
                                                shown as an editable field</p>
                                        </div>
                                    </article>
                                    <article class="sg-home-preview-slide" data-preview-slide aria-hidden="true"
                                        aria-label="3 of 3: Fees overview">
                                        <div class="sg-home-appbar"><span class="sg-home-app-mark" aria-hidden="true"><i
                                                    class="ti-layers"></i></span><strong>Fee management</strong><span
                                                class="sg-home-app-chip">Sample</span></div>
                                        <div class="sg-home-fees-screen">
                                            <p class="sg-home-preview-kicker">Fees overview</p>
                                            <div class="sg-home-fees-total"><span>Fee records <small>Sample
                                                        data</small></span><strong>24 <small>items</small></strong></div>
                                            <div class="sg-home-fee-row"><span class="sg-home-fee-icon"><i
                                                        class="ti-wallet"
                                                        aria-hidden="true"></i></span><span><b>Assigned</b><small>Sample
                                                        fee record</small></span><strong>12</strong></div>
                                            <div class="sg-home-fee-row"><span
                                                    class="sg-home-fee-icon sg-home-fee-icon-green"><i class="ti-check"
                                                        aria-hidden="true"></i></span><span><b>Recorded</b><small>Sample
                                                        payment record</small></span><strong>8</strong></div>
                                            <div class="sg-home-fee-row"><span
                                                    class="sg-home-fee-icon sg-home-fee-icon-gold"><i class="ti-time"
                                                        aria-hidden="true"></i></span><span><b>Pending</b><small>Sample fee
                                                        record</small></span><strong>4</strong></div>
                                        </div>
                                    </article>
                                </div>
                                <div class="sg-home-preview-controls" aria-label="Product preview controls"><button
                                        type="button" class="sg-home-preview-control" data-preview-prev
                                        aria-label="Previous product preview"><i class="ti-arrow-left"
                                            aria-hidden="true"></i></button>
                                    <div class="sg-home-preview-dots" data-preview-dots
                                        aria-label="Choose product preview"></div><button type="button"
                                        class="sg-home-preview-control" data-preview-next
                                        aria-label="Next product preview"><i class="ti-arrow-right"
                                            aria-hidden="true"></i></button><button type="button"
                                        class="sg-home-preview-control sg-home-preview-toggle" data-preview-toggle
                                        aria-label="Pause product preview" aria-pressed="false"><i
                                            class="ti-control-pause" aria-hidden="true"></i></button>
                                </div>
                                <p class="sg-home-preview-caption">Sample data for illustration</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="sg-home-stats-section" aria-label="SchoolGear platform overview">
            <div class="container">
                <div class="row sg-home-stats-card">
                    <div class="col-6 col-lg-3">
                        <div class="sg-home-stat"><span class="counter sg-home-stat-number">3</span>
                            <p class="sg-home-stat-label">Months Free Trial</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="sg-home-stat"><span class="counter sg-home-stat-number">1</span>
                            <p class="sg-home-stat-label">Connected Platform</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="sg-home-stat"><span class="counter sg-home-stat-number">3</span>
                            <p class="sg-home-stat-label">Core User Roles</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="sg-home-stat"><span class="counter sg-home-stat-number">100</span><span
                                class="percent sg-home-stat-number">%</span>
                            <p class="sg-home-stat-label">Built for Schools</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="sg-home-section sg-home-features" aria-labelledby="sg-home-features-title">
            <div class="container">
                <div class="row align-items-end sg-home-section-heading">
                    <div class="col-12 col-lg-5">
                        <p class="sg-home-eyebrow">One connected platform</p>
                        <h2 id="sg-home-features-title">Everything Your School Needs</h2>
                    </div>
                    <div class="col-12 col-lg-7">
                        <p class="sg-home-section-lead">One platform to manage your school, empower your staff, and keep
                            student records organized.</p><a href="{{ url('/about-us') }}" class="sg-home-inline-link">See
                            Features <span aria-hidden="true">→</span></a>
                    </div>
                </div>
                <div class="row sg-home-feature-grid">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <article class="sg-home-feature-card"><span class="sg-home-icon"><i class="ti-layers"
                                    aria-hidden="true"></i></span>
                            <h3>Complete School Management</h3>
                            <p>Manage admissions, students, enrollment, fees, academic years, grades, and subjects from one
                                connected platform.</p>
                        </article>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <article class="sg-home-feature-card"><span class="sg-home-icon"><i class="ti-new-window"
                                    aria-hidden="true"></i></span>
                            <h3>Academic Management</h3>
                            <p>Manage grades, subjects, report cards, and academic records with controlled access and
                                reliable audit trails.</p>
                        </article>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <article class="sg-home-feature-card"><span class="sg-home-icon"><i class="ti-user"
                                    aria-hidden="true"></i></span>
                            <h3>Built for Every Role</h3>
                            <p>Give administrators, teachers, and students a dedicated experience designed around what they
                                need to do.</p>
                        </article>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <article class="sg-home-feature-card sg-home-feature-card-tinted"><span class="sg-home-icon"><i
                                    class="ti-world" aria-hidden="true"></i></span>
                            <h3>Designed for Liberia</h3>
                            <p>Practical technology designed around the needs of schools in Liberia.</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section class="sg-home-section sg-home-story" aria-labelledby="sg-home-story-title">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <div class="sg-home-story-image"><img
                                src="{{ asset('schoolGear_liberia_public_site/img/image123456.jpg') }}"
                                alt="School technology illustration with connected student, learning and security symbols"
                                width="1536" height="1024" loading="lazy"></div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="sg-home-story-copy">
                            <p class="sg-home-eyebrow">About SchoolGear Liberia</p>
                            <h2 id="sg-home-story-title">Technology That Makes School Management Easier</h2>
                            <p>Managing a school shouldn't mean juggling paperwork, spreadsheets, and disconnected
                                processes. SchoolGear brings your school's essential operations into one connected system
                                helping your team save time, stay organized, and focus more on what matters: supporting
                                better learning.</p>
                            <ul class="sg-home-check-list">
                                <li><span class="ti-check" aria-hidden="true"></span><span><strong>One Platform for Your
                                            School</strong><br>Manage students, academics, staff, fees, and daily operations
                                        in one place.</span></li>
                                <li><span class="ti-check" aria-hidden="true"></span><span><strong>Made for the Liberian
                                            Education System</strong><br>Practical technology designed around the needs of
                                        schools in Liberia.</span></li>
                            </ul><a href="{{ route('public.register') }}"
                                class="sg-home-button sg-home-button-primary">Discover SchoolGear</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="sg-home-section sg-home-process" aria-labelledby="sg-home-process-title">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <div class="sg-home-process-copy">
                            <p class="sg-home-eyebrow">Built for Better Schools</p>
                            <h2 id="sg-home-process-title">Turn Everyday School Work Into Simple Digital Processes</h2>
                            <p>From the first student admission to academic records and school reporting, SchoolGear helps
                                schools replace scattered paperwork with organized digital processes that save time, reduce
                                errors, and make important information easier to manage.</p>
                            <div class="row sg-home-benefit-grid">
                                <div class="col-12 col-sm-6">
                                    <article class="sg-home-benefit-card"><span class="sg-home-icon"><i
                                                class="ti-pencil-alt" aria-hidden="true"></i></span>
                                        <h3>Less Paperwork</h3>
                                        <p>Keep student information, admissions, records, and reports organized without
                                            relying on piles of paperwork.</p>
                                    </article>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <article class="sg-home-benefit-card"><span class="sg-home-icon"><i class="ti-stamp"
                                                aria-hidden="true"></i></span>
                                        <h3>Greater Accountability</h3>
                                        <p>Give schools clearer records and better visibility into important academic and
                                            administrative activities.</p>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="sg-home-story-image sg-home-process-image"><img
                                src="{{ asset('schoolGear_liberia_public_site/img/image555.jpg') }}"
                                alt="Illustration of a school community with an example dashboard and calendar interface"
                                width="1536" height="1024" loading="lazy"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="sg-home-section sg-home-testimonials" aria-labelledby="sg-home-testimonials-title">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <p class="sg-home-eyebrow">What Schools Say</p>
                        <h2 id="sg-home-testimonials-title">What schools and board members say</h2>
                        <p class="sg-home-section-lead">Perspectives from people who have worked with SchoolGear.</p>
                    </div>
                </div>
                <div class="sg-home-testimonial-carousel" data-home-carousel aria-label="SchoolGear testimonials">
                    <div class="row sg-home-testimonial-track" data-carousel-track tabindex="0">
                        <div class="col-12 col-md-6 col-lg-4 sg-home-testimonial-slide">
                            <article class="sg-home-testimonial-card">
                                <blockquote><span class="sg-home-quote-text">SchoolGear gives us a simpler way to manage
                                        student records, academic activities, and everyday school administration from one
                                        place.</span><button class="sg-home-quote-toggle" type="button"
                                        aria-expanded="false" hidden>Read more</button></blockquote>
                                <div class="sg-home-person"><img
                                        src="{{ asset('schoolGear_liberia_public_site/img/hanery.png') }}"
                                        alt="Hanery S Saye" width="1024" height="1024" loading="lazy"><span
                                        class="sg-home-initials" aria-hidden="true" hidden>HS</span>
                                    <div class="sg-home-person-copy">
                                        <h3>Hanery S Saye</h3>
                                        <p>EDMOL Memorial Baptists High School</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 sg-home-testimonial-slide">
                            <article class="sg-home-testimonial-card">
                                <blockquote><span class="sg-home-quote-text">Having student information, grades, and
                                        learning materials organized in one system makes it much easier for teachers to
                                        manage their work</span><button class="sg-home-quote-toggle" type="button"
                                        aria-expanded="false" hidden>Read more</button></blockquote>
                                <div class="sg-home-person"><img
                                        src="{{ asset('schoolGear_liberia_public_site/img/sisGboryonon.png') }}"
                                        alt="Mrs. Gboryonon B.Z. Williams" width="1056" height="992"
                                        loading="lazy"><span class="sg-home-initials" aria-hidden="true" hidden>GW</span>
                                    <div class="sg-home-person-copy">
                                        <h3>Mrs. Gboryonon B.Z. Williams</h3>
                                        <p>Board Member, EDMOL Memorial Baptists High School</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 sg-home-testimonial-slide">
                            <article class="sg-home-testimonial-card">
                                <blockquote><span class="sg-home-quote-text">SchoolGear makes it easier for students to
                                        stay connected with their school, access their academic information, and keep track
                                        of their learning.</span><button class="sg-home-quote-toggle" type="button"
                                        aria-expanded="false" hidden>Read more</button></blockquote>
                                <div class="sg-home-person"><img
                                        src="{{ asset('schoolGear_liberia_public_site/img/prince_brown.jpeg') }}"
                                        alt="Prince Brown" width="646" height="614" loading="lazy"><span
                                        class="sg-home-initials" aria-hidden="true" hidden>PB</span>
                                    <div class="sg-home-person-copy">
                                        <h3>Prince Brown</h3>
                                        <p>Staff</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 sg-home-testimonial-slide">
                            <article class="sg-home-testimonial-card">
                                <blockquote><span class="sg-home-quote-text">SchoolGear provides schools with a more
                                        organized way to manage academic records, support teachers, and keep important
                                        school information accessible.</span><button class="sg-home-quote-toggle"
                                        type="button" aria-expanded="false" hidden>Read more</button></blockquote>
                                <div class="sg-home-person"><img
                                        src="{{ asset('schoolGear_liberia_public_site/img/deaconjoseph.png') }}"
                                        alt="Decon Joseph Gborie" width="1056" height="992" loading="lazy"><span
                                        class="sg-home-initials" aria-hidden="true" hidden>DG</span>
                                    <div class="sg-home-person-copy">
                                        <h3>Decon Joseph Gborie</h3>
                                        <p>School Board Member</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="sg-home-carousel-controls"><button class="sg-home-carousel-button" data-carousel-prev
                            type="button" aria-label="Previous testimonial"><i class="ti-arrow-left"
                                aria-hidden="true"></i></button>
                        <div class="sg-home-carousel-dots" data-carousel-dots aria-label="Choose testimonial group"></div>
                        <button class="sg-home-carousel-button" data-carousel-next type="button"
                            aria-label="Next testimonial"><i class="ti-arrow-right" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </section>

        <section class="sg-home-section sg-home-why" aria-labelledby="sg-home-why-title">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <p class="sg-home-eyebrow">Why SchoolGear</p>
                        <h2 id="sg-home-why-title">Everything Your School Needs, In One Place</h2>
                        <p class="sg-home-section-lead">Connected tools for the daily work of school administration,
                            academics, and communication.</p>
                    </div>
                </div>
                <div class="row sg-home-why-grid">
                    <div class="col-12 col-md-6 col-lg-4">
                        <article class="sg-home-why-card">
                            <div class="sg-home-why-image"><img
                                    src="{{ asset('schoolGear_liberia_public_site/img/Kindergarten student-amico.png') }}"
                                    alt="Teacher guiding young students through a classroom activity" width="1600"
                                    height="1600" loading="lazy"></div>
                            <div class="sg-home-why-copy"><span class="sg-home-icon"><i class="ti-user"
                                        aria-hidden="true"></i></span>
                                <h3>Student &amp; Admission Management</h3>
                                <p>Manage applications, admissions, student records, enrollment, and student information
                                    digitally.</p>
                            </div>
                        </article>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <article class="sg-home-why-card">
                            <div class="sg-home-why-image"><img
                                    src="{{ asset('schoolGear_liberia_public_site/img/college entrance exam-rafiki.png') }}"
                                    alt="Student sitting an examination with school books nearby" width="1600"
                                    height="1600" loading="lazy"></div>
                            <div class="sg-home-why-copy"><span class="sg-home-icon"><i class="ti-pencil-alt"
                                        aria-hidden="true"></i></span>
                                <h3>Academic Management</h3>
                                <p>Manage grades, subjects, teacher assignments, grade entry, report cards, and academic
                                    records with better accountability.</p>
                            </div>
                        </article>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <article class="sg-home-why-card">
                            <div class="sg-home-why-image"><img
                                    src="{{ asset('schoolGear_liberia_public_site/img/High School-rafiki.png') }}"
                                    alt="High school students standing together outside their school" width="1600"
                                    height="1600" loading="lazy"></div>
                            <div class="sg-home-why-copy"><span class="sg-home-icon"><i class="ti-announcement"
                                        aria-hidden="true"></i></span>
                                <h3>School Communication &amp; Operations</h3>
                                <p>Keep administrators, teachers, and students connected through announcements, learning
                                    materials, and school activities.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section class="sg-home-final-cta" aria-labelledby="sg-home-final-title">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-7">
                        <p class="sg-home-eyebrow">A clearer way to organize school work</p>
                        <h2 id="sg-home-final-title">Bring your school’s daily work together</h2>
                        <p>SchoolGear brings student information, academics, fees, and school communication into one
                            connected platform.</p>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="sg-home-final-actions"><a class="sg-home-button sg-home-button-light"
                                href="{{ route('public.register') }}">Start your free trial</a><a
                                class="sg-home-final-link" href="{{ url('/book-demo') }}">Book a Demo <span
                                    aria-hidden="true">→</span></a></div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        (function() {
            'use strict';

            function initHomePreview() {
                var preview = document.querySelector('[data-sg-home-preview]');
                if (!preview || preview.dataset.initialized === 'true') return;
                preview.dataset.initialized = 'true';
                var slides = Array.prototype.slice.call(preview.querySelectorAll('[data-preview-slide]'));
                var dots = preview.querySelector('[data-preview-dots]');
                var previous = preview.querySelector('[data-preview-prev]');
                var next = preview.querySelector('[data-preview-next]');
                var toggle = preview.querySelector('[data-preview-toggle]');
                var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                var active = 0;
                var timer = null;
                var paused = reduceMotion;
                var hovering = false;
                var touching = false;

                function stop() {
                    window.clearInterval(timer);
                    timer = null;
                }

                function paint(index) {
                    active = (index + slides.length) % slides.length;
                    slides.forEach(function(slide, i) {
                        var selected = i === active;
                        slide.classList.toggle('is-active', selected);
                        slide.setAttribute('aria-hidden', selected ? 'false' : 'true');
                        dots.children[i].setAttribute('aria-current', selected ? 'true' : 'false');
                    });
                }

                function start() {
                    stop();
                    if (reduceMotion || paused || hovering || touching || preview.contains(document.activeElement))
                        return;
                    timer = window.setInterval(function() {
                        paint(active + 1);
                    }, 5000);
                }

                function syncToggle() {
                    toggle.setAttribute('aria-label', paused ? 'Play product preview' : 'Pause product preview');
                    toggle.setAttribute('aria-pressed', paused ? 'true' : 'false');
                    toggle.innerHTML = '<i class="' + (paused ? 'ti-control-play' : 'ti-control-pause') +
                        '" aria-hidden="true"></i>';
                }
                slides.forEach(function(_, index) {
                    var dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = 'sg-home-preview-dot';
                    dot.setAttribute('aria-label', 'Show product preview ' + (index + 1));
                    dot.addEventListener('click', function() {
                        paint(index);
                        start();
                    });
                    dots.appendChild(dot);
                });
                previous.addEventListener('click', function() {
                    paint(active - 1);
                    start();
                });
                next.addEventListener('click', function() {
                    paint(active + 1);
                    start();
                });
                toggle.addEventListener('click', function() {
                    paused = !paused;
                    syncToggle();
                    start();
                });
                preview.addEventListener('mouseenter', function() {
                    hovering = true;
                    stop();
                });
                preview.addEventListener('mouseleave', function() {
                    hovering = false;
                    start();
                });
                preview.addEventListener('focusin', stop);
                preview.addEventListener('focusout', function() {
                    window.setTimeout(start, 0);
                });
                preview.addEventListener('touchstart', function() {
                    touching = true;
                    stop();
                }, {
                    passive: true
                });
                preview.addEventListener('touchend', function() {
                    window.setTimeout(function() {
                        touching = false;
                        start();
                    }, 5000);
                }, {
                    passive: true
                });
                paint(0);
                syncToggle();
                start();
            }

            function initHomeTestimonials() {
                var carousel = document.querySelector('[data-home-carousel]');
                if (!carousel || carousel.dataset.initialized === 'true') return;
                carousel.dataset.initialized = 'true';
                var track = carousel.querySelector('[data-carousel-track]');
                var slides = Array.prototype.slice.call(carousel.querySelectorAll('.sg-home-testimonial-slide'));
                var dots = carousel.querySelector('[data-carousel-dots]');
                var previous = carousel.querySelector('[data-carousel-prev]');
                var next = carousel.querySelector('[data-carousel-next]');
                var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                var active = 0;
                var timer = null;
                var hovering = false;
                var touching = false;
                var userPaused = false;

                function visibleCount() {
                    return window.innerWidth >= 992 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
                }

                function pageStarts() {
                    var perPage = visibleCount(),
                        lastStart = Math.max(0, slides.length - perPage),
                        starts = [];
                    for (var i = 0; i < lastStart; i += perPage) starts.push(i);
                    if (!starts.length || starts[starts.length - 1] !== lastStart) starts.push(lastStart);
                    return starts;
                }

                function currentPage(starts) {
                    var page = 0;
                    starts.forEach(function(start, i) {
                        if (active >= start) page = i;
                    });
                    return page;
                }

                function stop() {
                    window.clearInterval(timer);
                    timer = null;
                }

                function update() {
                    var left = track.getBoundingClientRect().left,
                        nearest = Infinity;
                    slides.forEach(function(slide, i) {
                        var d = Math.abs(slide.getBoundingClientRect().left - left);
                        if (d < nearest) {
                            nearest = d;
                            active = i;
                        }
                    });
                    var current = currentPage(pageStarts());
                    Array.prototype.forEach.call(dots.children, function(dot, i) {
                        if (i === current) dot.setAttribute('aria-current', 'true');
                        else dot.removeAttribute('aria-current');
                    });
                }

                function goToPage(page) {
                    var starts = pageStarts();
                    page = (page + starts.length) % starts.length;
                    active = starts[page];
                    var left = track.getBoundingClientRect().left,
                        slideLeft = slides[active].getBoundingClientRect().left;
                    track.scrollTo({
                        left: track.scrollLeft + slideLeft - left,
                        behavior: reduceMotion ? 'auto' : 'smooth'
                    });
                    update();
                }

                function start() {
                    stop();
                    if (reduceMotion || userPaused || hovering || touching || carousel.contains(document.activeElement))
                        return;
                    timer = window.setInterval(function() {
                        goToPage(currentPage(pageStarts()) + 1);
                    }, 6000);
                }

                function syncQuoteToggles() {
                    var desktop = window.matchMedia('(min-width: 992px)').matches;
                    slides.forEach(function(slide) {
                        var quote = slide.querySelector('blockquote'),
                            text = slide.querySelector('.sg-home-quote-text'),
                            button = slide.querySelector('.sg-home-quote-toggle');
                        if (!desktop) {
                            quote.classList.remove('sg-home-quote-expanded');
                            button.hidden = true;
                            button.setAttribute('aria-expanded', 'false');
                            button.textContent = 'Read more';
                            return;
                        }
                        if (quote.classList.contains('sg-home-quote-expanded')) {
                            button.hidden = false;
                            button.setAttribute('aria-expanded', 'true');
                            button.textContent = 'Read less';
                            return;
                        }
                        button.hidden = text.scrollHeight <= text.clientHeight + 1;
                        button.setAttribute('aria-expanded', 'false');
                        button.textContent = 'Read more';
                    });
                }

                function renderDots() {
                    var starts = pageStarts();
                    if (dots.children.length !== starts.length) {
                        dots.textContent = '';
                        starts.forEach(function(_, index) {
                            var dot = document.createElement('button');
                            dot.type = 'button';
                            dot.className = 'sg-home-carousel-dot';
                            dot.setAttribute('aria-label', 'Go to testimonial group ' + (index + 1));
                            dot.addEventListener('click', function() {
                                goToPage(index);
                            });
                            dots.appendChild(dot);
                        });
                    }
                    update();
                }
                slides.forEach(function(slide) {
                    var button = slide.querySelector('.sg-home-quote-toggle');
                    button.addEventListener('click', function() {
                        var expanded = button.getAttribute('aria-expanded') !== 'true';
                        slide.querySelector('blockquote').classList.toggle('sg-home-quote-expanded',
                            expanded);
                        button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                        button.textContent = expanded ? 'Read less' : 'Read more';
                    });
                    var image = slide.querySelector('img');
                    image.addEventListener('error', function() {
                        image.hidden = true;
                        image.nextElementSibling.hidden = false;
                    });
                });
                previous.addEventListener('click', function() {
                    goToPage(currentPage(pageStarts()) - 1);
                });
                next.addEventListener('click', function() {
                    goToPage(currentPage(pageStarts()) + 1);
                });
                track.addEventListener('scroll', update, {
                    passive: true
                });
                carousel.addEventListener('mouseenter', function() {
                    hovering = true;
                    stop();
                });
                carousel.addEventListener('mouseleave', function() {
                    hovering = false;
                    start();
                });
                carousel.addEventListener('focusin', stop);
                carousel.addEventListener('focusout', function() {
                    window.setTimeout(start, 0);
                });
                carousel.addEventListener('touchstart', function() {
                    touching = true;
                    stop();
                }, {
                    passive: true
                });
                carousel.addEventListener('touchend', function() {
                    window.setTimeout(function() {
                        touching = false;
                        start();
                    }, 6000);
                }, {
                    passive: true
                });
                window.addEventListener('resize', function() {
                    renderDots();
                    syncQuoteToggles();
                }, {
                    passive: true
                });
                renderDots();
                syncQuoteToggles();
                start();
            }
            if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function() {
                initHomePreview();
                initHomeTestimonials();
            });
            else {
                initHomePreview();
                initHomeTestimonials();
            }
        })();
    </script>
@endsection

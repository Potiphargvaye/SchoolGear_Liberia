@extends('public.layouts.public')

@section('title', 'About Our School Management Platform | SchoolGear Liberia')

@section('description')
    Learn about SchoolGear Liberia, a school management platform for Liberian schools to organize student records,
    admissions, fees, grades and administration.
@endsection

@php
    $aboutFaqs = [
        [
            'question' => 'What is SchoolGear Liberia?',
            'answer' => 'SchoolGear Liberia is a web-based school management platform for organizing school administration and academic information.',
        ],
        [
            'question' => 'What can a school manage with SchoolGear?',
            'answer' => 'Schools can organize admissions, enrollment, student records, fees, grades, report cards, attendance, and announcements.',
        ],
        [
            'question' => 'Who can use SchoolGear?',
            'answer' => 'School administrators, teachers, and students can use SchoolGear with access based on their roles.',
        ],
        [
            'question' => 'Is each school’s data kept separate?',
            'answer' => 'SchoolGear is a multi-school platform. School records are scoped to the relevant school account in the application.',
        ],
        [
            'question' => 'How does the free trial work?',
            'answer' => 'The school registration page offers a 3-month free trial. It says no credit card is required, full setup and training support are included, and describes it as a real 3-month implementation window, not a limited demo.',
        ],
        [
            'question' => 'How can I see SchoolGear before signing up?',
            'answer' => 'Use the Book a Demo page to request a consultation and see the platform.',
        ],
        [
            'question' => 'Is SchoolGear only for schools in Monrovia?',
            'answer' => 'SchoolGear is a web platform built for Liberian schools. The team is based in Monrovia and is working toward reaching schools across Liberia.',
        ],
    ];
    $aboutFaqStructuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(static function (array $faq): array {
            return [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'],
                ],
            ];
        }, $aboutFaqs),
    ];
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/sg-about.css') }}?v={{ @filemtime(public_path('schoolGear_liberia_public_site/css/sg-about.css')) }}">
@endpush

@push('json-ld')
    <script type="application/ld+json">@json($aboutFaqStructuredData)</script>
@endpush

@section('content')
<main class="sg-about">
    <section class="sg-about-hero">
        <div class="container sg-about-hero-panel">
            <div class="row">
                <div class="col-12 col-lg-9 sg-about-hero-copy">
                    <nav class="sg-about-breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span><span>About Us</span>
                    </nav>
                    <h1>About SchoolGear Liberia</h1>
                    <p class="sg-about-hero-subtitle">We’re building practical digital tools around the everyday work of schools in Liberia.</p>
                    <div class="sg-about-hero-actions">
                        <a class="sg-about-button sg-about-button-light" href="{{ url('/book-demo') }}">Book a Consultation</a>
                        <a class="sg-about-button sg-about-button-outline" href="{{ url('/school-registration') }}">Register Your School</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sg-about-stats" aria-label="SchoolGear at a glance">
        <div class="container">
            <div class="row sg-about-stats-card">
                <div class="col-6 col-lg-3"><div class="sg-about-stat"><span class="counter sg-about-counter">3</span><span class="sg-about-stat-label">Months Free Trial</span></div></div>
                <div class="col-6 col-lg-3"><div class="sg-about-stat"><span class="counter">1</span><span class="sg-about-stat-label">Connected Platform</span></div></div>
                <div class="col-6 col-lg-3"><div class="sg-about-stat"><span class="counter">3</span><span class="sg-about-stat-label">Core User Roles</span></div></div>
                <div class="col-6 col-lg-3"><div class="sg-about-stat"><span class="counter">100</span><span class="percent sg-about-percent">%</span><span class="sg-about-stat-label">Built for Schools</span></div></div>
            </div>
        </div>
    </section>

    <section class="sg-about-section sg-about-capabilities" aria-labelledby="sg-about-capabilities-title">
        <div class="container">
            <div class="row align-items-end sg-about-section-heading">
                <div class="col-12 col-lg-8">
                    <p class="sg-about-eyebrow">What SchoolGear Is</p>
                    <h2 id="sg-about-capabilities-title">One Platform For Your School</h2>
                    <p class="sg-about-lead">SchoolGear brings essential school operations together in one organized system, helping schools manage people, records, learning, and daily activities with greater ease.</p>
                    <p class="sg-about-lead">SchoolGear brings the everyday work of running a school — student records, attendance, communication, and administration — into one connected, easy-to-use system. It’s built to fit into how Liberian schools actually operate, not to force them into a foreign template.</p>
                </div>
            </div>
            <div class="row sg-about-feature-grid">
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-feature-card"><span class="sg-about-icon"><i class="ti-user" aria-hidden="true"></i></span><h3>Student &amp; Enrollment</h3><p>Manage student admissions, enrollment, profiles, registration information, and student records from one organized system.</p></article></div>
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-feature-card"><span class="sg-about-icon"><i class="ti-book" aria-hidden="true"></i></span><h3>Academic Management</h3><p>Organize grades, subjects, student results, academic records, report cards, and teacher assignments with greater accuracy.</p></article></div>
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-feature-card"><span class="sg-about-icon"><i class="ti-blackboard" aria-hidden="true"></i></span><h3>Teacher Management</h3><p>Give teachers the tools and access they need to manage assigned classes, subjects, students, grades, and learning activities.</p></article></div>
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-feature-card"><span class="sg-about-icon"><i class="ti-calendar" aria-hidden="true"></i></span><h3>Student &amp; Staff Attendance</h3><p>Track daily attendance for students and staff, helping schools maintain accurate attendance records and monitor participation throughout the school year.</p></article></div>
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-feature-card"><span class="sg-about-icon"><i class="ti-wallet" aria-hidden="true"></i></span><h3>Fees &amp; Records</h3><p>Keep student fee information and important administrative records organized, accessible, and easier for schools to manage.</p></article></div>
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-feature-card"><span class="sg-about-icon"><i class="ti-bar-chart" aria-hidden="true"></i></span><h3>Reports &amp; Accountability</h3><p>Access important school reports and maintain clearer records of academic and administrative activities for better accountability.</p></article></div>
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-feature-card"><span class="sg-about-icon"><i class="ti-announcement" aria-hidden="true"></i></span><h3>Announcements &amp; Communication</h3><p>Keep students, teachers, and the school community informed with announcements and important updates shared through one platform.</p></article></div>
                <div class="col-12 col-sm-6 col-lg-3"><div class="sg-about-feature-cta"><span class="sg-about-icon"><i class="ti-comments" aria-hidden="true"></i></span><h3>See how it fits your school</h3><p>Talk with us about the work your school wants to organize.</p><a class="sg-about-text-link" href="{{ url('/book-demo') }}">Book a Consultation <span aria-hidden="true">→</span></a></div></div>
            </div>
        </div>
    </section>

    <section class="sg-about-section sg-about-story" aria-labelledby="sg-about-story-title">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-6"><div class="sg-about-story-image"><img src="{{ asset('schoolGear_liberia_public_site/img/banner_img.png') }}" alt="Students raising their hands during a classroom lesson" width="1000" height="667" loading="lazy"></div></div>
                <div class="col-12 col-md-6"><div class="sg-about-story-copy"><p class="sg-about-eyebrow">Our Story</p><h2 id="sg-about-story-title">Built From a Problem We Believe Liberia Can Solve</h2><p>Growing up in Liberia, I have seen schools continue to manage important daily operations manually, with information scattered across paper records and disconnected processes. SchoolGear was created to help schools move confidently into the digital age with simple technology built around their real needs.</p><p>SchoolGear began with EDMOL Memorial Baptists High School, where the need for a centralized way to manage school information became clear.</p><p>Our vision is to work with schools and the Ministry of Education to make better digital school management accessible across all 15 counties.</p></div></div>
            </div>
            <div class="row sg-about-mission-row">
                <div class="col-12 col-md-6"><article class="sg-about-value-card"><span class="sg-about-icon"><i class="ti-target" aria-hidden="true"></i></span><p class="sg-about-eyebrow">Our Mission</p><h3>Helping Schools Run With Less Paper, More Clarity</h3><p>Our mission is to give Liberian schools simple, reliable tools to manage their daily operations — from student records to communication — so administrators spend less time on paperwork and more time on what matters: educating students.</p></article></div>
                <div class="col-12 col-md-6"><article class="sg-about-value-card"><span class="sg-about-icon"><i class="ti-eye" aria-hidden="true"></i></span><p class="sg-about-eyebrow">Our Vision</p><h3>A Digitally Connected School System Across Liberia</h3><p>We envision a future where every school in Liberia, across all 15 counties, has access to modern school management tools — working alongside the Ministry of Education to make that future a reality.</p></article></div>
            </div>
        </div>
    </section>

    <section class="sg-about-section sg-about-audiences" aria-labelledby="sg-about-audiences-title">
        <div class="container">
            <div class="row"><div class="col-12 col-lg-8"><p class="sg-about-eyebrow">Who We Serve</p><h2 id="sg-about-audiences-title">Built for the People Who Run Schools Every Day</h2></div></div>
            <div class="row sg-about-audience-grid">
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-audience-card"><span class="sg-about-icon"><i class="ti-panel" aria-hidden="true"></i></span><h3>School Administrators</h3><p>Centralized records and less time on manual paperwork.</p></article></div>
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-audience-card"><span class="sg-about-icon"><i class="ti-agenda" aria-hidden="true"></i></span><h3>Teachers &amp; Staff</h3><p>Simple tools for attendance, grading, and communication.</p></article></div>
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-audience-card"><span class="sg-about-icon"><i class="ti-user" aria-hidden="true"></i></span><h3>Students &amp; Parents</h3><p>Clearer, faster access to school information that matters.</p></article></div>
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-audience-card"><span class="sg-about-icon"><i class="ti-briefcase" aria-hidden="true"></i></span><h3>Ministry &amp; Policy Partners</h3><p>A path toward consistent digital standards nationwide.</p></article></div>
            </div>
        </div>
    </section>

    <section class="sg-about-section sg-about-journey" aria-labelledby="sg-about-journey-title">
        <div class="container">
            <div class="row"><div class="col-12 col-lg-8"><p class="sg-about-eyebrow">Our Journey</p><h2 id="sg-about-journey-title">From an Idea to a Real School Partner</h2></div></div>
            <div class="row sg-about-journey-track">
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-milestone"><span class="sg-about-milestone-icon ti-flag" aria-hidden="true"></span><h3>July 2024</h3><p>SchoolGear was founded to solve a problem seen firsthand in Liberian schools.</p></article></div>
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-milestone"><span class="sg-about-milestone-icon ti-check-box" aria-hidden="true"></span><h3>2024</h3><p>EDMOL Memorial Baptists High School became our first real school partner.</p></article></div>
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-milestone"><span class="sg-about-milestone-icon ti-arrow-right" aria-hidden="true"></span><h3>Next Steps</h3><p>Expanding to serve more schools with the tools they need most.</p></article></div>
                <div class="col-12 col-sm-6 col-lg-3"><article class="sg-about-milestone"><span class="sg-about-milestone-icon ti-world" aria-hidden="true"></span><h3>The Road Ahead</h3><p>Working toward reaching schools across all 15 counties of Liberia.</p></article></div>
            </div>
        </div>
    </section>

    <section class="sg-about-section sg-about-testimonials" aria-labelledby="sg-about-testimonials-title">
        <div class="container">
            <div class="row"><div class="col-12 col-lg-8"><p class="sg-about-eyebrow">Our Impact</p><h2 id="sg-about-testimonials-title">What schools and board members say</h2><p class="sg-about-lead">Perspectives from people who have worked with SchoolGear.</p></div></div>
            <div class="sg-about-testimonial-carousel" aria-label="SchoolGear testimonials">
                <div class="row sg-about-testimonial-track" tabindex="0">
                    <div class="col-12 col-md-6 col-lg-4 sg-about-testimonial-slide"><article class="sg-about-testimonial-card"><blockquote><span class="sg-about-quote-text">SchoolGear gives us a simpler way to manage student records, academic activities, and everyday school administration from one place.</span><button class="sg-about-quote-toggle" type="button" aria-expanded="false" hidden>Read more</button></blockquote><div class="sg-about-person"><img src="{{ asset('schoolGear_liberia_public_site/img/hanery.png') }}" alt="Hanery S Saye" width="1024" height="1024" loading="lazy"><span class="sg-about-initials" aria-hidden="true" hidden>HS</span><div><h3>Hanery S Saye</h3><p>EDMOL Memorial Baptists High School</p></div></div></article></div>
                    <div class="col-12 col-md-6 col-lg-4 sg-about-testimonial-slide"><article class="sg-about-testimonial-card"><blockquote><span class="sg-about-quote-text">Having student information, grades, and learning materials organized in one system makes it much easier for teachers to manage their work</span><button class="sg-about-quote-toggle" type="button" aria-expanded="false" hidden>Read more</button></blockquote><div class="sg-about-person"><img src="{{ asset('schoolGear_liberia_public_site/img/sisGboryonon.png') }}" alt="Mrs. Gboryonon B.Z. Williams" width="1056" height="992" loading="lazy"><span class="sg-about-initials" aria-hidden="true" hidden>GW</span><div><h3>Mrs. Gboryonon B.Z. Williams</h3><p>Board Member, EDMOL Memorial Baptists High School</p></div></div></article></div>
                    <div class="col-12 col-md-6 col-lg-4 sg-about-testimonial-slide"><article class="sg-about-testimonial-card"><blockquote><span class="sg-about-quote-text">SchoolGear makes it easier for students to stay connected with their school, access their academic information, and keep track of their learning.</span><button class="sg-about-quote-toggle" type="button" aria-expanded="false" hidden>Read more</button></blockquote><div class="sg-about-person"><img src="{{ asset('schoolGear_liberia_public_site/img/prince_brown.jpeg') }}" alt="Prince Brown" width="646" height="614" loading="lazy"><span class="sg-about-initials" aria-hidden="true" hidden>PB</span><div><h3>Prince Brown</h3><p>Future Focus Academy</p></div></div></article></div>
                    <div class="col-12 col-md-6 col-lg-4 sg-about-testimonial-slide"><article class="sg-about-testimonial-card"><blockquote><span class="sg-about-quote-text">SchoolGear provides schools with a more organized way to manage academic records, support teachers, and keep important school information accessible.</span><button class="sg-about-quote-toggle" type="button" aria-expanded="false" hidden>Read more</button></blockquote><div class="sg-about-person"><img src="{{ asset('schoolGear_liberia_public_site/img/deaconjoseph.png') }}" alt="Decon Joseph Gborie" width="1056" height="992" loading="lazy"><span class="sg-about-initials" aria-hidden="true" hidden>DG</span><div><h3>Decon Joseph Gborie</h3><p>School Board Member</p></div></div></article></div>
                </div>
                <div class="sg-about-carousel-controls"><button class="sg-about-carousel-button sg-about-previous" type="button" aria-label="Previous testimonial"><i class="ti-arrow-left" aria-hidden="true"></i></button><div class="sg-about-carousel-dots" aria-label="Choose testimonial"></div><button class="sg-about-carousel-button sg-about-next" type="button" aria-label="Next testimonial"><i class="ti-arrow-right" aria-hidden="true"></i></button></div>
            </div>
        </div>
    </section>

    <section class="sg-about-section sg-about-contact" aria-labelledby="sg-about-contact-title">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-12 col-lg-6"><p class="sg-about-eyebrow">Team &amp; Get in Touch</p><h2 id="sg-about-contact-title">Built in Liberia, shaped by the schools we work with</h2><p>SchoolGear was founded in July 2024 and is based in Monrovia. We work directly with school staff and use feedback from their day-to-day work to improve the platform.</p><p>We are working toward reaching schools across Liberia, building with the needs of school communities in mind.</p></div>
                <div class="col-12 col-lg-6"><div class="row sg-about-contact-cards"><div class="col-12 col-md-6"><article class="sg-about-contact-card"><span class="sg-about-icon"><i class="ti-email" aria-hidden="true"></i></span><h3>Get in touch</h3><p><a href="mailto:potiphargvaye@gmail.com">potiphargvaye@gmail.com</a></p><p><a href="tel:+231770123498">+231 77 012 3498</a></p><a class="sg-about-button sg-about-button-primary" href="{{ url('/contact-us') }}">Contact Us</a></article></div><div class="col-12 col-md-6"><article class="sg-about-contact-card"><span class="sg-about-icon"><i class="ti-plus" aria-hidden="true"></i></span><h3>Register Your School</h3><p>Start a 3-month free trial with SchoolGear and set up your school account.</p><a class="sg-about-button sg-about-button-primary" href="{{ url('/school-registration') }}">Start free trial</a></article></div></div></div>
            </div>
        </div>
    </section>

    <section class="sg-about-section sg-about-faq" aria-labelledby="sg-about-faq-title">
        <div class="container">
            <div class="row"><div class="col-12 col-lg-8"><p class="sg-about-eyebrow">Questions &amp; Answers</p><h2 id="sg-about-faq-title">Frequently Asked Questions</h2></div></div>
            <div class="row"><div class="col-12 col-lg-9"><div class="sg-about-faq-list">
                @foreach ($aboutFaqs as $index => $faq)
                    <details class="sg-about-faq-item" @if ($index === 0) open @endif>
                        <summary><h3>{{ $faq['question'] }}</h3><span class="sg-about-faq-mark" aria-hidden="true"></span></summary>
                        <div class="sg-about-faq-answer"><p>{{ $faq['answer'] }}</p></div>
                    </details>
                @endforeach
            </div></div></div>
        </div>
    </section>

    <section class="sg-about-final-cta" aria-labelledby="sg-about-final-title">
        <div class="container"><div class="row align-items-center"><div class="col-12 col-lg-7"><p class="sg-about-eyebrow">A clearer way to organize school work</p><h2 id="sg-about-final-title">Bring your school’s daily work together</h2></div><div class="col-12 col-lg-5"><div class="sg-about-final-actions"><a class="sg-about-button sg-about-button-light" href="{{ url('/school-registration') }}">Start your free trial</a><a class="sg-about-final-link" href="{{ url('/book-demo') }}">Book a Demo <span aria-hidden="true">→</span></a></div></div></div></div>
    </section>
</main>

<script>
(function () {
    'use strict';

    function initAboutTestimonials() {
        var carousel = document.querySelector('.sg-about-testimonial-carousel');
        if (!carousel || carousel.dataset.initialized === 'true') return;
        carousel.dataset.initialized = 'true';

        var track = carousel.querySelector('.sg-about-testimonial-track');
        var slides = Array.prototype.slice.call(carousel.querySelectorAll('.sg-about-testimonial-slide'));
        var dots = carousel.querySelector('.sg-about-carousel-dots');
        var previous = carousel.querySelector('.sg-about-previous');
        var next = carousel.querySelector('.sg-about-next');
        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var active = 0;
        var timer = null;
        var hovering = false;
        var touching = false;

        function visibleCount() {
            if (window.innerWidth >= 992) return 3;
            if (window.innerWidth >= 768) return 2;
            return 1;
        }
        function pageStarts() {
            var perPage = visibleCount();
            var lastStart = Math.max(0, slides.length - perPage);
            var starts = [];
            for (var i = 0; i < lastStart; i += perPage) starts.push(i);
            if (!starts.length || starts[starts.length - 1] !== lastStart) starts.push(lastStart);
            return starts;
        }
        function currentPage(starts) {
            var page = 0;
            starts.forEach(function (start, index) { if (active >= start) page = index; });
            return page;
        }
        function pause() { window.clearInterval(timer); timer = null; }
        function start() {
            if (!reduceMotion && !timer && !hovering && !touching && !carousel.contains(document.activeElement)) {
                timer = window.setInterval(function () { goToPage(currentPage(pageStarts()) + 1); }, 6000);
            }
        }
        function syncQuoteToggles() {
            var desktop = window.matchMedia('(min-width: 992px)').matches;
            slides.forEach(function (slide) {
                var quote = slide.querySelector('blockquote');
                var text = slide.querySelector('.sg-about-quote-text');
                var toggle = slide.querySelector('.sg-about-quote-toggle');
                if (!quote || !text || !toggle) return;
                if (!desktop) {
                    quote.classList.remove('sg-about-quote-expanded');
                    toggle.hidden = true;
                    toggle.setAttribute('aria-expanded', 'false');
                    toggle.textContent = 'Read more';
                    return;
                }
                if (quote.classList.contains('sg-about-quote-expanded')) {
                    toggle.hidden = false;
                    toggle.setAttribute('aria-expanded', 'true');
                    toggle.textContent = 'Read less';
                    return;
                }
                toggle.hidden = text.scrollHeight <= text.clientHeight + 1;
                toggle.setAttribute('aria-expanded', 'false');
                toggle.textContent = 'Read more';
            });
        }
        function update() {
            var trackLeft = track.getBoundingClientRect().left;
            var nearest = Infinity;
            slides.forEach(function (slide, index) {
                var distance = Math.abs(slide.getBoundingClientRect().left - trackLeft);
                if (distance < nearest) { nearest = distance; active = index; }
            });
            var page = currentPage(pageStarts());
            Array.prototype.forEach.call(dots.children, function (dot, index) {
                if (index === page) dot.setAttribute('aria-current', 'true');
                else dot.removeAttribute('aria-current');
            });
        }
        function goToPage(page) {
            var starts = pageStarts();
            page = (page + starts.length) % starts.length;
            active = starts[page];
            var trackLeft = track.getBoundingClientRect().left;
            var slideLeft = slides[active].getBoundingClientRect().left;
            track.scrollTo({ left: track.scrollLeft + slideLeft - trackLeft, behavior: reduceMotion ? 'auto' : 'smooth' });
            update();
        }
        function renderDots() {
            var starts = pageStarts();
            if (dots.children.length !== starts.length) {
                dots.textContent = '';
                starts.forEach(function (start, index) {
                    var dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = 'sg-about-carousel-dot';
                    dot.setAttribute('aria-label', 'Go to testimonial group ' + (index + 1));
                    dot.addEventListener('click', function () { goToPage(index); });
                    dots.appendChild(dot);
                });
            }
            update();
        }

        slides.forEach(function (slide) {
            var toggle = slide.querySelector('.sg-about-quote-toggle');
            toggle.addEventListener('click', function () {
                var expanded = toggle.getAttribute('aria-expanded') !== 'true';
                slide.querySelector('blockquote').classList.toggle('sg-about-quote-expanded', expanded);
                toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                toggle.textContent = expanded ? 'Read less' : 'Read more';
                if (!expanded) syncQuoteToggles();
            });
            var image = slide.querySelector('img');
            image.addEventListener('error', function () {
                image.hidden = true;
                image.nextElementSibling.hidden = false;
            });
        });

        previous.addEventListener('click', function () { goToPage(currentPage(pageStarts()) - 1); });
        next.addEventListener('click', function () { goToPage(currentPage(pageStarts()) + 1); });
        track.addEventListener('scroll', update, { passive: true });
        carousel.addEventListener('mouseenter', function () { hovering = true; pause(); });
        carousel.addEventListener('mouseleave', function () { hovering = false; start(); });
        carousel.addEventListener('focusin', pause);
        carousel.addEventListener('focusout', function () { window.setTimeout(start, 0); });
        carousel.addEventListener('touchstart', function () { touching = true; pause(); }, { passive: true });
        carousel.addEventListener('touchend', function () {
            window.setTimeout(function () { touching = false; start(); }, 6000);
        }, { passive: true });
        window.addEventListener('resize', function () { renderDots(); syncQuoteToggles(); }, { passive: true });
        renderDots();
        syncQuoteToggles();
        start();
    }

    if (document.readyState === 'complete') initAboutTestimonials();
    else window.addEventListener('load', initAboutTestimonials, { once: true });
})();
</script>
@endsection

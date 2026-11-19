@extends('public.layouts.public')

@section('title', 'Pricing for School Software in Liberia | SchoolGear Liberia')

@section('description', 'SchoolGear Liberia pricing: $2.00 per junior and senior high student, $1.50 per elementary student, $2.00 per staff user. All features and a 31-day free trial.')

@php
    $pricingPlans = [
        [
            'name' => 'Free Trial',
            'price' => '$0 for 31 days',
            'unit' => 'No payment needed. Every feature is switched on.',
            'class' => 'sg-pricing-plan-trial',
            'badge' => 'Start here',
            'features' => [
                'Every SchoolGear feature, nothing locked',
                'Student records, admissions, and enrollment',
                'Grade entry and report cards with a verification QR code',
                'Attendance, fees, and announcements',
                'Staff accounts with roles and permissions',
                'Training for your staff',
                'Technical support by phone, 24 hours a day, 6 days a week',
                'Continuous updates based on your feedback',
            ],
            'button' => 'Start your free trial',
        ],
        [
            'name' => 'Junior & Senior High',
            'price' => '$2.00 per student / year',
            'staff' => '$2.00 per active staff user / year',
            'unit' => 'For students enrolled in the current academic year.',
            'features' => [
                'Every SchoolGear feature included',
                'Grade entry in the Liberian format: six periods, two exams, semester and yearly averages',
                'Junior and senior high report cards, with a verification QR code on every card',
                'Attendance, fees, student portal, and announcements',
                'Roles and permissions for all your staff',
                'Training and technical support, available 24/6',
                'Continuous updates based on your feedback',
            ],
            'button' => 'Get started',
        ],
        [
            'name' => 'Elementary & Kindergarten',
            'price' => '$1.50 per student / year',
            'staff' => '$2.00 per active staff user / year',
            'unit' => 'For students enrolled in the current academic year.',
            'features' => [
                'Every SchoolGear feature included',
                'Elementary and kindergarten report cards, with a verification QR code on every card',
                'Admissions, enrollment, grade entry, attendance, and fees',
                'Student portal and announcements',
                'Roles and permissions for all your staff',
                'Training and technical support, available 24/6',
                'Continuous updates based on your feedback',
            ],
            'button' => 'Get started',
        ],
    ];

    $featureGroups = [
        ['icon' => 'ti-user', 'title' => 'Students and records', 'items' => ['Online admissions with applicant photo and records', 'Student login accounts created automatically, with a welcome email', 'Enrollment, class assignment, and promotion to the next class', 'Student profiles and records, with Excel export', 'Academic years and class management']],
        ['icon' => 'ti-pencil-alt', 'title' => 'Grades and report cards', 'items' => ['Grade entry in the Liberian format: six periods, two exams, semester and yearly averages', 'Subject management and teacher assignments by class and subject', 'Grade locking to protect finished grades', 'Full grade audit trail: who changed what, and when', 'Report cards ready to print, for each school level', 'A verification QR code on every report card, so anyone can confirm it is genuine']],
        ['icon' => 'ti-calendar', 'title' => 'Attendance', 'items' => ['Attendance by date, period, and subject', "Summaries, reports, and each student's history", 'Printable attendance reports', 'Attendance locking and an audit trail']],
        ['icon' => 'ti-wallet', 'title' => 'Fees', 'items' => ['Fee categories and fees assigned to each student', 'Payment recording, printable receipts, and statements', 'Fees overview: collected versus assigned']],
        ['icon' => 'ti-id-badge', 'title' => 'Student portal', 'items' => ['Students sign in with their registration ID', 'Grades by period and semester', 'Attendance in a monthly calendar', 'Their own profile, with password change']],
        ['icon' => 'ti-lock', 'title' => 'Staff users', 'items' => ['Role-based staff accounts, with login details sent by email', 'Custom roles and permissions (registrar, teacher, accountant, or any role your school needs)', 'Teachers: grade entry for assigned classes and subjects, and attendance marking from a phone', 'Registrar: admissions, enrollment, and promotions', 'Accounts staff: fees, payments, and receipts', 'Administrators: dashboard, reports, report card printing, audit trails, announcements, and branding']],
        ['icon' => 'ti-settings', 'title' => 'School management', 'items' => ['Dashboard with enrollment, fees, and attendance at a glance', 'Academic year switcher', 'Announcements and notifications', "Your school's logo and name on documents", "Each school's data kept separate", 'Works on phones, tablets, and computers']],
        ['icon' => 'ti-headphone-alt', 'title' => 'Support and updates', 'items' => ['Training for your staff', 'Technical support by phone, 24 hours a day, 6 days a week', 'Walk-in help at our office: New Matadi, Opposite Don Bosco Youth Center, Monrovia, Liberia, West Africa (Mon to Fri, 9am to 5pm)', 'Continuous updates based on your feedback']],
    ];
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/sg-pricing.css') }}?v={{ @filemtime(public_path('schoolGear_liberia_public_site/css/sg-pricing.css')) }}">
@endpush

@section('content')
    <main class="sg-pricing">
        <section class="sg-pricing-hero">
            <div class="container">
                <div class="sg-pricing-hero-panel">
                    <p class="sg-pricing-breadcrumb"><a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span><span>Pricing</span></p>
                    <h1>Simple pricing, based on your school's level</h1>
                    <p class="sg-pricing-hero-subtitle">Every plan includes every feature. You pay for the students enrolled this academic year and for your active staff users. The student rate depends on their level. All prices are in US dollars.</p>
                    <div class="sg-pricing-actions">
                        <a class="sg-pricing-button sg-pricing-button-light" href="{{ route('public.register') }}">Start your free trial</a>
                        <a class="sg-pricing-button sg-pricing-button-outline" href="{{ url('/contact-us') }}">Contact us</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="sg-pricing-section sg-pricing-plans" aria-labelledby="sg-pricing-plans-title">
            <div class="container">
                <div class="sg-pricing-section-heading">
                    <p class="sg-pricing-eyebrow">Choose your school's level</p>
                    <h2 id="sg-pricing-plans-title">One clear rate for every school</h2>
                </div>
                <div class="row sg-pricing-plan-grid">
                    @foreach ($pricingPlans as $plan)
                        <div class="col-lg-4 col-md-6 sg-pricing-plan-col">
                            <article class="sg-pricing-plan-card {{ $plan['class'] ?? '' }}">
                                @if (!empty($plan['badge'])) <span class="sg-pricing-badge">{{ $plan['badge'] }}</span> @endif
                                <h3>{{ $plan['name'] }}</h3>
                                <p class="sg-pricing-plan-price">{{ $plan['price'] }}</p>
                                @if (!empty($plan['staff'])) <p class="sg-pricing-plan-staff">{{ $plan['staff'] }}</p> @endif
                                <p class="sg-pricing-plan-unit">{{ $plan['unit'] }}</p>
                                <ul class="sg-pricing-check-list">
                                    @foreach ($plan['features'] as $feature)<li><span aria-hidden="true"><i class="ti-check"></i></span>{{ $feature }}</li>@endforeach
                                </ul>
                                <a class="sg-pricing-button sg-pricing-button-primary" href="{{ route('public.register') }}">{{ $plan['button'] }}</a>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="sg-pricing-section sg-pricing-included" aria-labelledby="sg-pricing-included-title">
            <div class="container">
                <div class="sg-pricing-section-heading">
                    <p class="sg-pricing-eyebrow">Everything your school needs</p>
                    <h2 id="sg-pricing-included-title">EVERYTHING IS INCLUDED IN EVERY PLAN</h2>
                    <p class="sg-pricing-lead">One system, one price per student. Nothing is locked behind a higher plan.</p>
                </div>
                <div class="row sg-pricing-feature-grid">
                    @foreach ($featureGroups as $group)
                        <div class="col-lg-3 col-md-6 sg-pricing-feature-col">
                            <article class="sg-pricing-feature-card">
                                <span class="sg-pricing-icon" aria-hidden="true"><i class="{{ $group['icon'] }}"></i></span>
                                <h3>{{ $group['title'] }}</h3>
                                <ul class="sg-pricing-mini-list">
                                    @foreach ($group['items'] as $item)<li><span aria-hidden="true"><i class="ti-check"></i></span>{{ $item }}</li>@endforeach
                                </ul>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="sg-pricing-section sg-pricing-billing" aria-labelledby="sg-pricing-billing-title">
            <div class="container">
                <div class="row align-items-start">
                    <div class="col-lg-5 sg-pricing-billing-copy">
                        <p class="sg-pricing-eyebrow">Simple, predictable billing</p>
                        <h2 id="sg-pricing-billing-title">How billing works</h2>
                        <ul class="sg-pricing-billing-list">
                            <li><strong>Students:</strong> every student enrolled in the current academic year, billed at their own level's rate.</li>
                            <li><strong>Staff:</strong> every active staff account, including owners and administrators, at $2.00 each per year.</li>
                            <li><strong>When we count:</strong> once per academic year, at the end of the enrollment period.</li>
                            <li><strong>How you pay:</strong> in two installments, one at the start of each semester, using the payment method that suits your school.</li>
                            <li><strong>Minimum:</strong> $100 per school per year.</li>
                            <li>Every plan includes every feature, training, and 24/6 phone support.</li>
                        </ul>
                    </div>
                    <div class="col-lg-7">
                        <div class="sg-pricing-estimator" data-estimator hidden>
                            <div class="sg-pricing-estimator-heading"><p class="sg-pricing-eyebrow">Estimate only</p><h3>Estimate your annual price</h3></div>
                            <div class="row">
                                <div class="col-md-4"><label for="sg-pricing-jhs">Junior and senior high students</label><input id="sg-pricing-jhs" type="number" min="0" step="1" inputmode="numeric" value="0"></div>
                                <div class="col-md-4"><label for="sg-pricing-elementary">Elementary and kindergarten students</label><input id="sg-pricing-elementary" type="number" min="0" step="1" inputmode="numeric" value="0"></div>
                                <div class="col-md-4"><label for="sg-pricing-staff">Active staff users</label><input id="sg-pricing-staff" type="number" min="0" step="1" inputmode="numeric" value="0"></div>
                            </div>
                            <div class="sg-pricing-estimate-result" aria-live="polite">
                                <p><span>Students subtotal</span><strong data-result="students">$0.00</strong></p>
                                <p><span>Staff subtotal</span><strong data-result="staff">$0.00</strong></p>
                                <p class="sg-pricing-total"><span>Annual total</span><strong data-result="total">$100.00</strong></p>
                                <p class="sg-pricing-minimum-note" data-result="note">The $100 minimum applies.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="sg-pricing-contact-strip" aria-labelledby="sg-pricing-contact-title">
            <div class="container"><div class="sg-pricing-contact-card"><div><p class="sg-pricing-eyebrow">Talk to SchoolGear</p><h2 id="sg-pricing-contact-title">Ready to talk through your school's needs?</h2><p><strong>Phone:</strong> <a href="tel:+231770123498">+231 77 012 3498</a><br><strong>Address:</strong> New Matadi, Opposite Don Bosco Youth Center, Monrovia, Liberia, West Africa</p></div><div class="sg-pricing-contact-actions"><a class="sg-pricing-button sg-pricing-button-primary" href="{{ url('/contact-us') }}">Contact us</a><a class="sg-pricing-button sg-pricing-button-secondary" href="{{ url('/book-demo') }}">Book a Demo</a></div></div></div>
        </section>

        <section class="sg-pricing-final-cta"><div class="container"><p class="sg-pricing-eyebrow">Try it in your school</p><h2>Start with 31 days free</h2><p>Every feature is switched on from day one. No payment needed to start.</p><a class="sg-pricing-button sg-pricing-button-accent" href="{{ route('public.register') }}">Start your free trial</a></div></section>
    </main>
@endsection

@push('scripts')
    <script>
        (() => {
            const root = document.querySelector('[data-estimator]');
            if (!root) return;
            root.hidden = false;
            const fields = { jhs: root.querySelector('#sg-pricing-jhs'), elementary: root.querySelector('#sg-pricing-elementary'), staff: root.querySelector('#sg-pricing-staff') };
            const money = value => `$${value.toFixed(2)}`;
            const read = field => Math.max(0, Number.isFinite(Number(field.value)) ? Math.floor(Number(field.value)) : 0);
            const update = () => {
                const jhs = read(fields.jhs), elementary = read(fields.elementary), staff = read(fields.staff);
                const students = (jhs * 2) + (elementary * 1.5), staffTotal = staff * 2, subtotal = students + staffTotal, total = Math.max(100, subtotal);
                root.querySelector('[data-result="students"]').textContent = money(students);
                root.querySelector('[data-result="staff"]').textContent = money(staffTotal);
                root.querySelector('[data-result="total"]').textContent = money(total);
                root.querySelector('[data-result="note"]').hidden = subtotal >= 100;
            };
            Object.values(fields).forEach(field => field.addEventListener('input', update));
            update();
        })();
    </script>
@endpush

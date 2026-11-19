@extends('public.layouts.public')

@section('title', 'Contact Us for School Software | SchoolGear Liberia')

@section('description')
    Contact SchoolGear Liberia about our school management software, request a demo or ask about setting up your school.
    We're based in Monrovia, Liberia.
@endsection

@push('styles')
    <link rel="stylesheet"
        href="{{ asset('schoolGear_liberia_public_site/css/sg-contact.css') }}?v={{ @filemtime(public_path('schoolGear_liberia_public_site/css/sg-contact.css')) }}">
@endpush

@section('content')
    <main class="sg-contact">
        <section class="sg-contact-hero" aria-labelledby="sg-contact-title">
            <div class="container">
                <p class="sg-contact-breadcrumb"><a href="{{ url('/') }}">Home</a> <span>/</span> Contact us</p>
                <div class="sg-contact-hero-panel">
                    <p class="sg-contact-eyebrow">Questions? We’re here to help.</p>
                    <h1 id="sg-contact-title">Contact SchoolGear</h1>
                    <p class="sg-contact-hero-subtitle">Questions about SchoolGear, a demo, or setting up your school? Reach us any way that suits you.</p>
                    <div class="sg-contact-actions">
                        <a class="sg-contact-button sg-contact-button-accent" href="tel:+231770123498"><i class="ti-mobile" aria-hidden="true"></i> Call us</a>
                        <a class="sg-contact-button sg-contact-button-outline" href="#sg-contact-form"><i class="ti-email" aria-hidden="true"></i> Send a message</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="sg-contact-section" aria-labelledby="sg-contact-details-title">
            <div class="container">
                <div class="sg-contact-section-heading">
                    <p class="sg-contact-eyebrow">Reach out directly</p>
                    <h2 id="sg-contact-details-title">Let’s talk about your school</h2>
                </div>
                <div class="row sg-contact-card-row">
                    <div class="col-12 col-md-6 col-xl-3"><article class="sg-contact-card"><span class="sg-contact-card-icon"><i class="ti-mobile" aria-hidden="true"></i></span><h3>Phone</h3><a href="tel:+231770123498">+231 77 012 3498</a><p>Call our team directly.</p></article></div>
                    <div class="col-12 col-md-6 col-xl-3"><article class="sg-contact-card"><span class="sg-contact-card-icon"><i class="ti-email" aria-hidden="true"></i></span><h3>Email</h3><a href="mailto:info@schoolgearliberia.com">info@schoolgearliberia.com</a><p>Send us your questions anytime.</p></article></div>
                    <div class="col-12 col-md-6 col-xl-3"><article class="sg-contact-card"><span class="sg-contact-card-icon"><i class="ti-home" aria-hidden="true"></i></span><h3>Office</h3><p>New Matadi, Opposite Don Bosco Youth Center, Monrovia, Liberia, West Africa</p><a href="https://www.google.com/maps/search/?api=1&amp;query=New%20Matadi%2C%20Opposite%20Don%20Bosco%20Youth%20Center%2C%20Monrovia%2C%20Liberia%2C%20West%20Africa" target="_blank" rel="noopener noreferrer">Get directions <span aria-hidden="true">→</span></a></article></div>
                    <div class="col-12 col-md-6 col-xl-3"><article class="sg-contact-card"><span class="sg-contact-card-icon"><i class="ti-time" aria-hidden="true"></i></span><h3>Office hours</h3><p>Mon to Fri, 9am to 5pm</p><span class="sg-contact-card-note">Liberia time</span></article></div>
                </div>
                <a class="sg-contact-facebook" href="https://www.facebook.com/profile.php?id=61595077418489" target="_blank" rel="noopener noreferrer" aria-label="Follow us on Facebook"><i class="ti-facebook" aria-hidden="true"></i> Follow us on Facebook</a>
            </div>
        </section>

        <section class="sg-contact-section sg-contact-form-section" aria-labelledby="sg-contact-form-title">
            <div class="container"><div class="row align-items-start">
                <div class="col-12 col-lg-8"><div class="sg-contact-form-card">
                    <p class="sg-contact-eyebrow">Send a message</p><h2 id="sg-contact-form-title">Tell us how we can help</h2>
                    <div class="sg-contact-js-form" data-sg-contact-form-shell>
                        <form id="sg-contact-form" data-sg-contact-form novalidate>
                            <div class="row">
                                <div class="col-12 col-md-6"><label for="sg-contact-name">Name</label><input id="sg-contact-name" name="name" type="text" required autocomplete="name"></div>
                                <div class="col-12 col-md-6"><label for="sg-contact-email">Email</label><input id="sg-contact-email" name="email" type="email" required autocomplete="email"></div>
                                <div class="col-12 col-md-6"><label for="sg-contact-phone">Phone <span>(optional)</span></label><input id="sg-contact-phone" name="phone" type="tel" autocomplete="tel"></div>
                                <div class="col-12 col-md-6"><label for="sg-contact-subject">Subject</label><select id="sg-contact-subject" name="subject" required autocomplete="off"><option value="" selected disabled>Choose a subject</option><option>Request a demo</option><option>Setting up my school</option><option>Pricing</option><option>Technical support</option><option>Something else</option></select></div>
                                <div class="col-12"><label for="sg-contact-message">Message</label><textarea id="sg-contact-message" name="message" rows="6" required autocomplete="off"></textarea></div>
                            </div>
                            <button class="sg-contact-button sg-contact-button-primary" type="submit">Open email app <i class="ti-arrow-right" aria-hidden="true"></i></button>
                            <p class="sg-contact-form-note">This opens your email app so you can send your message.</p>
                        </form>
                    </div>
                    <div class="sg-contact-no-js" data-sg-contact-no-js><p>Use one of these options to contact us directly.</p><div class="sg-contact-actions"><a class="sg-contact-button sg-contact-button-primary" href="mailto:info@schoolgearliberia.com">Email us</a><a class="sg-contact-button sg-contact-button-secondary" href="tel:+231770123498">Call us</a></div></div>
                </div></div>
                <div class="col-12 col-lg-4"><aside class="sg-contact-side-card"><span class="sg-contact-side-icon"><i class="ti-comments" aria-hidden="true"></i></span><h3>Book a Demo</h3><p>See how SchoolGear can fit the daily work of your school.</p><a href="{{ url('/book-demo') }}">Book a Demo <span aria-hidden="true">→</span></a><hr><h3>Register Your School</h3><p>Every feature is switched on for 31 days. No payment needed to start.</p><a href="{{ url('/school-registration') }}">Register your school <span aria-hidden="true">→</span></a></aside></div>
            </div></div>
        </section>

        <section class="sg-contact-section sg-contact-map-section" aria-labelledby="sg-contact-map-title">
            <div class="container"><div class="sg-contact-section-heading"><p class="sg-contact-eyebrow">Visit us</p><h2 id="sg-contact-map-title">Find our office</h2></div>
                <div class="sg-contact-map-card"><span class="sg-contact-map-icon"><i class="ti-location-pin" aria-hidden="true"></i></span><h3>New Matadi</h3><p>Opposite Don Bosco Youth Center, Monrovia, Liberia, West Africa</p><p class="sg-contact-map-note">Map coordinates will be added when the exact latitude and longitude are provided.</p><div class="sg-contact-actions"><a class="sg-contact-button sg-contact-button-primary" href="https://www.google.com/maps/search/?api=1&amp;query=New%20Matadi%2C%20Opposite%20Don%20Bosco%20Youth%20Center%2C%20Monrovia%2C%20Liberia%2C%20West%20Africa" target="_blank" rel="noopener noreferrer">Open in Google Maps</a><a class="sg-contact-button sg-contact-button-secondary" href="https://www.google.com/maps/dir/?api=1&amp;destination=New%20Matadi%2C%20Opposite%20Don%20Bosco%20Youth%20Center%2C%20Monrovia%2C%20Liberia%2C%20West%20Africa" target="_blank" rel="noopener noreferrer">Get directions</a></div></div>
            </div>
        </section>

        <section class="sg-contact-cta" aria-labelledby="sg-contact-cta-title"><div class="container"><p class="sg-contact-eyebrow">Try it in your school</p><h2 id="sg-contact-cta-title">Start with 31 days free</h2><p>Every feature is switched on from day one. No payment needed to start.</p><a class="sg-contact-button sg-contact-button-accent" href="{{ route('public.register') }}">Start your free trial</a></div></section>
    </main>

    <script>
        (function () {
            var shell = document.querySelector('[data-sg-contact-form-shell]');
            var fallback = document.querySelector('[data-sg-contact-no-js]');
            var form = document.querySelector('[data-sg-contact-form]');
            if (!shell || !fallback || !form) return;
            shell.classList.add('is-enabled');
            fallback.hidden = true;
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                if (!form.checkValidity()) { form.reportValidity(); return; }
                var data = new FormData(form);
                var subject = data.get('subject') + ' - SchoolGear Liberia contact';
                var body = 'Name: ' + data.get('name') + '\nEmail: ' + data.get('email') + '\nPhone: ' + (data.get('phone') || 'Not provided') + '\n\nMessage:\n' + data.get('message');
                window.location.href = 'mailto:info@schoolgearliberia.com?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);
            });
        }());
    </script>
@endsection

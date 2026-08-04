


@extends('public.layouts.public')

@section('title', 'Reset Password - Edmol MBHS Portal')
@section('description', 'Access the Edmol MBHS student and staff portal. Login to check results, fees, and school information.')
@section('canonical_url', 'https://www.edmolmbhs.com/login')

@section('content') 

<body> 
	  <div class="py-2 bg-primary" style="background-color:#0a2a66 !important;">
    	<div class="container">
    		<div class="row no-gutters d-flex align-items-start align-items-center px-3 px-md-0">
	    		<div class="col-lg-12 d-block">
		    		<div class="row d-flex">
			    		<div class="col-md-5 pr-4 d-flex topper align-items-center">
			    			<div class="icon bg-fifth mr-2 d-flex justify-content-center align-items-center"><span class="icon-map"></span></div>
						    <span class="text">New Matadi, Opposite Don-Bossco Youth-Center Monrovia, Liberia West Africa </span>
					    </div>
					    <div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon bg-secondary mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
						    <span class="text">emmmbhs@gmail.com</span>
					    </div>
					    <div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon bg-tertiary mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
						    <span class="text">+231555472972 / +231776597201</span>
					    </div>
				    </div>
			    </div>
		    </div>
		  </div>
    </div>
     <nav class="navbar navbar-expand-lg navbar-light bg-white ftco_navbar ftco-navbar-light" id="ftco-navbar">
	    <div class="container d-flex align-items-center">
	    	<a class="navbar-brand" href="index.html">Edmol Baptist School</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	       <ul class="navbar-nav ml-auto">
	        	<li class="nav-item active">
            <a href="{{ url('/') }}" class="nav-link pl-0">Home</a></li>
	        	<li class="nav-item"><a href="{{ url('/about-us') }}" class="nav-link">About Us</a></li>
            <li class="nav-item"><a href="{{ url('/teachers') }}" class="nav-link">Teacher</a></li>
            <li class="nav-item"><a href="{{ url('/courses') }}" class="nav-link">Courses</a></li>
            <li class="nav-item"><a href="{{ url('/fees-structure') }}" class="nav-link">Fees-structure</a></li>
            <li class="nav-item"><a href="{{ url('/blog') }}" class="nav-link">Blog</a></li>
            <li class="nav-item"><a href="{{ url('/contact-us') }}" class="nav-link">Contact-Us</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->


<section class="school-login-section" style="min-height: 80vh; display:flex; align-items:center; justify-content:center; position:relative;">

    <!-- floating background (reuse your login effect) -->
    <div class="floating-icons" id="floatingIcons"></div>

    <div class="login-card glass-card" style="width:100%; max-width:450px; z-index:10;">

        <div class="login-header text-center">
            <img 
                src="{{ asset('logo/edmol-orginal-logo.png') }}"  
                alt="School Logo"
                class="login-logo"
                style="width:80px;height:80px;border-radius:50%;object-fit:cover;"
            >

            <h2>Reset Password</h2>
            <p>Set a new secure password for your account</p>
        </div>

        {{-- ERROR MESSAGES --}}
        @if ($errors->any())
            <div class="alert alert-danger" style="font-size:14px;">
                <ul style="margin:0;padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}" id="resetForm">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- EMAIL --}}
            <div class="form-group">
                <label>Email</label>
                <input 
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $request->email) }}"
                    readonly
                    required
                >
            </div>

            {{-- NEW PASSWORD --}}
            <div class="form-group password-group">
                <label>New Password</label>
                <div class="password-wrapper">
                    <input 
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        required
                    >
                    <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
                </div>
            </div>

            {{-- CONFIRM PASSWORD --}}
            <div class="form-group password-group">
                <label>Confirm Password</label>
                <div class="password-wrapper">
                    <input 
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-control"
                        required
                    >
                    <span class="toggle-password" onclick="togglePassword('password_confirmation')">👁️</span>
                </div>

                <p id="password-match-message" class="text-sm mt-2 hidden"></p>
            </div>

            {{-- BUTTON --}}
            <button type="submit" class="login-btn" id="resetBtn">
                <span class="btn-text">Reset Password</span>
                <span class="btn-spinner"></span>
            </button>

        </form>
    </div>
</section>

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/250794241623" 
   target="_blank" 
   class="whatsapp-float" 
   aria-label="Message us on WhatsApp">
  <i class="fab fa-whatsapp"></i>
  <span class="whatsapp-tooltip">Message us on WhatsApp</span>
</a>


  <!-- loader --> 
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


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
function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}

const password = document.getElementById('password');
const confirmPassword = document.getElementById('password_confirmation');
const message = document.getElementById('password-match-message');

function checkPasswords() {

    if (!confirmPassword.value) {
        message.classList.add('hidden');
        return;
    }

    message.classList.remove('hidden');

    if (password.value === confirmPassword.value) {
        message.textContent = '✓ Passwords match';
        
        message.style.color = '#22c55e'; // GREEN (Tailwind green-500)
        message.style.fontWeight = '600';
        message.style.textShadow = '0px 1px 2px rgba(0,0,0,0.3)';
        
    } else {
        message.textContent = '✗ Passwords do not match';
        
        message.style.color = '#ef4444'; // RED (Tailwind red-500)
        message.style.fontWeight = '600';
        message.style.textShadow = '0px 1px 2px rgba(0,0,0,0.3)';
    }
}

password.addEventListener('input', checkPasswords);
confirmPassword.addEventListener('input', checkPasswords);

const resetForm = document.getElementById('resetForm');
const resetBtn = document.getElementById('resetBtn');

resetForm.addEventListener('submit', function () {

    // prevent double click
    resetBtn.disabled = true;

    // activate loading UI
    resetBtn.classList.add('loading');

    // change text
    resetBtn.querySelector('.btn-text').textContent = "Processing...";
});
</script>
  </body>


@endsection

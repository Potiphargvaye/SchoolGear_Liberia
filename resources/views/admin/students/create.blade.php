@extends('public.layouts.public')

@section('title', 'Contact-us')

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
						    <span class="text">+250794241623</span>
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
	<div class="contact-page-wrapper">

  <section class="hero-wrap hero-wrap-2" style="background-image: url('{{ asset('kiddos-school-master/images/class-room-teacher-image.jpg') }}');">

    <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-2 bread">Contact Us</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Contact <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>


		<h1>Registeratinon form come here!</h1>






        <!-- ================= STUDENT REGISTRATION FORM ================= -->
<section class="container my-5">
    <div class="card shadow-lg p-4">

        <h2 class="text-center mb-2">
            ED MOL MEMORIAL MATADI BAPTIST HIGH SCHOOL
        </h2>

        <p class="text-center text-muted mb-4">
            Student Registration Form – Academic Year 2025 / 2026
        </p>

        <!-- Progress Bar -->
        <div class="progress mb-4" style="height: 10px; border-radius: 5px; overflow: hidden;">
            <div id="progressBar" class="progress-bar bg-primary" style="width: 20%; transition: width 0.4s;"></div>
        </div>

       <form 
    action="{{ route('admin.students.store') }}" 
    method="POST" 
    enctype="multipart/form-data"
    id="registrationForm"
>
    @csrf



            <!-- ================= STEP 1: Personal Info ================= -->
            <div class="form-step active">
                <h4 class="mb-3">
                    <i class="fas fa-user mr-2 text-primary"></i>
                    Personal Information
                </h4>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" class="form-control form-control-lg required" name="name" placeholder="John Doe">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Age *</label>
                        <input type="number" class="form-control form-control-lg required" name="age" placeholder="e.g., 15">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Gender *</label>
                        <select class="form-control form-control-lg required" name="gender">
                            <option value="">Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>
                </div>

                <button type="button" class="btn btn-primary next-btn mt-3">
                    Next <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>

            <!-- ================= STEP 2: Academic Info ================= -->
            <div class="form-step">
                <h4 class="mb-3">
                    <i class="fas fa-school mr-2 text-success"></i>
                    Academic Information
                </h4>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Class Applying For *</label>
                        <select class="form-control form-control-lg required" name="class_applying_for">
                            <option value="">Select Class</option>
                            <option>KG</option>
                            <option>Grade 1</option>
                            <option>Grade 2</option>
                            <option>Grade 3</option>
                            <option>Grade 4</option>
                            <option>Grade 5</option>
                            <option>Grade 6</option>
                            <option>Grade 7</option>
                            <option>Grade 8</option>
                            <option>Grade 9</option>
                            <option>Grade 10</option>
                            <option>Grade 11</option>
                            <option>Grade 12</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date of Admission *</label>
                        <input type="date" class="form-control form-control-lg required" name="date_of_admission">
                    </div>
                </div>

                <button type="button" class="btn btn-secondary prev-btn mt-3">
                    <i class="fas fa-arrow-left mr-1"></i> Previous
                </button>
                <button type="button" class="btn btn-primary next-btn mt-3">
                    Next <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>

            <!-- ================= STEP 3: Guardian Info ================= -->
            <div class="form-step">
                <h4 class="mb-3">
                    <i class="fas fa-user-tie mr-2 text-warning"></i>
                    Parent / Guardian Information
                </h4>

                <div class="mb-3">
                    <label class="form-label">Parent / Guardian Phone *</label>
                    <input type="tel" class="form-control form-control-lg required" name="parent_phone" placeholder="e.g. 0777-151-394">
                </div>

                <button type="button" class="btn btn-secondary prev-btn mt-3">
                    <i class="fas fa-arrow-left mr-1"></i> Previous
                </button>
                <button type="button" class="btn btn-primary next-btn mt-3">
                    Next <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>

            <!-- ================= STEP 4: Required Documents ================= -->
            <div class="form-step">
                <h4 class="mb-3">
                    <i class="fas fa-file-upload mr-2 text-info"></i>
                    Required Documents
                </h4>

                <div class="mb-3">
                    <label class="form-label">Transcript (PDF / Image)</label>
                    <input type="file" class="form-control form-control-lg" name="transcript">
                </div>

                <div class="mb-3">
                    <label class="form-label">Recommendation Letter</label>
                    <input type="file" class="form-control form-control-lg" name="recommendation_letter">
                </div>

                <!-- ================= New Fields ================= -->
                <div class="mb-3">
                    <label class="form-label">Student Type *</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="student_type" value="New" required>
                        <label class="form-check-label">New Student</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="student_type" value="Old" required>
                        <label class="form-check-label">Old Student</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Last School Attended *</label>
                    <input type="text" class="form-control form-control-lg required" name="last_school_attended" placeholder="Enter last school attended">
                </div>

                <button type="button" class="btn btn-secondary prev-btn mt-3">
                    <i class="fas fa-arrow-left mr-1"></i> Previous
                </button>
                <button type="button" class="btn btn-primary next-btn mt-3">
                    Next <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>

            <!-- ================= STEP 5: Review & Submit ================= -->
            <div class="form-step">
                <h4 class="mb-3">
                    <i class="fas fa-check-circle mr-2 text-success"></i>
                    Review & Submit
                </h4>

                <div id="reviewSummary" class="mb-3">
                    <!-- Summary will be dynamically populated here -->
                </div>

                <button type="button" class="btn btn-secondary prev-btn mt-3">
                    <i class="fas fa-arrow-left mr-1"></i> Previous
                </button>
                <button type="submit" class="btn btn-success mt-3">
                    Submit Registration
                </button>
            </div>

        </form>
    </div>
</section>

<!-- ================= CSS ================= -->
<style>
    .form-step {
        display: none;
        animation: fadeIn 0.4s ease-in-out;
    }
    .form-step.active {
        display: block;
    }

    input.form-control-lg, select.form-control-lg {
        height: 50px;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        border: 1px solid #ced4da;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    input.form-control-lg:focus, select.form-control-lg:focus {
        border-color: #0a2a66;
        box-shadow: 0 0 5px rgba(10,42,102,0.3);
        outline: none;
    }

    label.form-label {
        font-weight: 500;
        margin-bottom: 0.3rem;
        display: block;
        color: #333;
    }

    h4 i {
        font-size: 1.2rem;
        vertical-align: middle;
    }

    @keyframes fadeIn {
        0% {opacity: 0; transform: translateY(10px);}
        100% {opacity: 1; transform: translateY(0);}
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    @media (max-width: 767px) {
        input.form-control-lg, select.form-control-lg {
            height: 45px;
            font-size: 0.9rem;
        }
        h4 {
            font-size: 1.1rem;
        }
    }

    #reviewSummary p {
        margin: 0.25rem 0;
    }
</style>



<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>


		
    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-6 col-lg-3">
            <div class="ftco-footer-widget mb-5">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">New Matadi, Opposite Don-Bossco Youth-Center Monrovia, Liberia </span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+250794241623</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">emmmbhs@gmail.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="ftco-footer-widget mb-5">
              <h2 class="ftco-heading-2">Recent Blog</h2>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url(images/image_1.jpg);"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                  <div class="meta">
                    <div><a href="#"><span class="icon-calendar"></span> Dec 25, 2018</a></div>
                    <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                  </div>
                </div>
              </div>
              <div class="block-21 mb-5 d-flex">
                <a class="blog-img mr-4" style="background-image: url(images/image_2.jpg);"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
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
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Home</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>About</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Services</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Deparments</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Contact</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="ftco-footer-widget mb-5">
            	<h2 class="ftco-heading-2">Subscribe Us!</h2>
              <form action="#" class="subscribe-form">
                <div class="form-group">
                  <input type="text" class="form-control mb-2 text-center" placeholder="Enter email address">
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

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
	</div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
<!-- WhatsApp Floating Button -->
<a href="https://wa.me/250794241623" 
   target="_blank" 
   class="whatsapp-float" 
   aria-label="Message us on WhatsApp">
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> <!-- Map script -->
  <script src="js/main.js"></script>
    

<!-- ================= JAVASCRIPT ================= -->
<script>
    const steps = document.querySelectorAll('.form-step');
    const progressBar = document.getElementById('progressBar');
    const form = document.getElementById('registrationForm');
    const reviewSummary = document.getElementById('reviewSummary');
    let currentStep = 0;

    function updateStep() {
        steps.forEach((step, index) => {
            step.classList.toggle('active', index === currentStep);
        });
        progressBar.style.width = ((currentStep + 1) / steps.length) * 100 + '%';

        // Populate review summary if final step
        if (currentStep === steps.length -1) {
            populateSummary();
        }
    }

    function populateSummary() {
        const data = new FormData(form);
        reviewSummary.innerHTML = '';
        for (let [key, value] of data.entries()) {
            if(value) {
                reviewSummary.innerHTML += `<p><strong>${key.replace(/_/g,' ')}:</strong> ${value}</p>`;
            }
        }
    }

    document.querySelectorAll('.next-btn').forEach(button => {
        button.addEventListener('click', () => {
            const requiredInputs = steps[currentStep].querySelectorAll('.required');
            let valid = true;

            requiredInputs.forEach(input => {
                if ((input.type === 'radio' && !steps[currentStep].querySelector(`input[name="${input.name}"]:checked`)) ||
                    (!['radio','file'].includes(input.type) && !input.value.trim())) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (valid && currentStep < steps.length - 1) {
                currentStep++;
                updateStep();
            }
        });
    });

    document.querySelectorAll('.prev-btn').forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                updateStep();
            }
        });
    });

    // Submit Feedback
    form.addEventListener('submit', e => {
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.innerText = 'Submitting...';
        submitButton.disabled = true;
    });

    updateStep();

    
</script>

  </body>  
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - WKG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: #f7fafc;
    color: #2d3748;
    line-height: 1.6;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 16px;
}

/* ── Banner ──────────────────────────────────────────────────────── */
.banner {
    background: linear-gradient(135deg, #0a2a66 0%, #1e40af 60%, #2563eb 100%);
    color: white;
    padding: 16px 26px;
    border-radius: 14px;
    box-shadow: 0 6px 20px rgba(10, 42, 102, 0.35);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 16px 0;
    gap: 14px;
    flex-wrap: wrap;
    border: 1px solid rgba(255,255,255,0.10);
}

.school-info {
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 0;
}

.school-logo {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
    background: white;
    box-shadow: 0 0 0 3px rgba(255,255,255,0.25), 0 4px 12px rgba(0,0,0,0.25);
}

.school-logo-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.school-logo-text {
    font-weight: 800;
    font-size: 12px;
    color: #0a2a66;
    letter-spacing: 0.5px;
}

.school-text { min-width: 0; }

.school-name {
    font-weight: 800;
    font-size: 19px;
    letter-spacing: 0.6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-shadow: 0 1px 3px rgba(0,0,0,0.2);
}

.school-tagline {
    font-size: 11.5px;
    opacity: 0.78;
    font-weight: 400;
    margin-top: 2px;
    letter-spacing: 0.8px;
}

.portal-tag {
    background: rgba(255, 255, 255, 0.2);
    padding: 8px 18px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 15px;
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    gap: 7px;
    white-space: nowrap;
    flex-shrink: 0;
}

/* ── Banner responsive ───────────────────────────────────────────── */

/* Tablet landscape — start scaling down */
@media (max-width: 1024px) {
    .school-name  { font-size: 16px; }
    .clock-time   { font-size: 19px; }
    .banner-clock { min-width: 136px; padding: 8px 16px; }
    .portal-tag   { font-size: 13px; padding: 8px 15px; }
}

/* Tablet portrait — compress but keep single row */
@media (max-width: 768px) {
    .banner {
        padding: 14px 18px;
        gap: 10px;
        justify-content: space-between;
    }
    .school-info  { justify-content: flex-start; }
    .school-logo  { width: 46px; height: 46px; }
    .school-name  { font-size: 15px; }
    .school-tagline { display: none; }
    .banner-clock { min-width: 120px; padding: 8px 14px; }
    .clock-time   { font-size: 17px; letter-spacing: 1.5px; }
    .clock-date   { font-size: 10.5px; }
    .portal-tag   { font-size: 12.5px; padding: 7px 14px; }
}

/* Large phones — wrap into 2 clean rows */
@media (max-width: 600px) {
    .banner {
        flex-wrap: wrap;
        padding: 14px 16px;
        gap: 10px;
        border-radius: 12px;
        justify-content: space-between;
        align-items: center;
    }

    /* Row 1: school info left, portal tag right */
    .school-info { order: 1; flex: 1 1 auto; }
    .portal-tag  { order: 2; flex-shrink: 0; }

    /* Row 2: clock spans full width, contents centered */
    .banner-clock {
        order: 3;
        width: 100%;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: 12px;
        padding: 8px 16px;
        min-width: 0;
        border-radius: 10px;
    }

    .clock-date { margin-top: 0; }
}

/* Small phones */
@media (max-width: 480px) {
    .banner       { gap: 8px; border-radius: 10px; padding: 12px 14px; }
    .school-logo  { width: 40px; height: 40px; }
    .school-name  { font-size: 13.5px; }
    .clock-time   { font-size: 15px; letter-spacing: 1px; }
    .clock-date   { font-size: 10px; }
    .portal-tag   { font-size: 11.5px; padding: 6px 11px; gap: 5px; }
    form.button   { justify-content: center; }
}

/* Very small phones (≤360px) */
@media (max-width: 360px) {
    .school-name        { font-size: 12.5px; }
    .portal-tag span    { display: none; }   /* icon only — saves space */
    .clock-time         { font-size: 14px; }
    .clock-date         { font-size: 9.5px; }
}

/* ── Live Clock ──────────────────────────────────────────────────── */
.banner-clock {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: rgba(255,255,255,0.10);
    border: 1px solid rgba(255,255,255,0.18);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 10px 20px;
    min-width: 120px;
    text-align: center;
}

.clock-time {
    font-size: 22px;
    font-weight: 700;
    letter-spacing: 2px;
    color: #ffffff;
    font-variant-numeric: tabular-nums;
    text-shadow: 0 2px 6px rgba(0,0,0,0.2);
    line-height: 1.2;
}

.clock-date {
    font-size: 11.5px;
    color: rgba(255,255,255,0.80);
    font-weight: 500;
    margin-top: 3px;
    letter-spacing: 0.4px;
    white-space: nowrap;
}

/* ── Student Info Card ───────────────────────────────────────────── */
.bg-white    { background: white; }
.shadow      { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
.rounded-lg  { border-radius: 12px; }
.p-6         { padding: 24px; }
.mb-6        { margin-bottom: 24px; }

.flex        { display: flex; }
.flex-col    { flex-direction: column; }
.items-center { align-items: center; }

.space-y-4 > * + * { margin-top: 16px; }

.border           { border: 1px solid #e2e8f0; }
.border-blue-100  { border-color: #dbeafe; }

.text-center  { text-align: center; }
.text-lg      { font-size: 18px; }
.font-bold    { font-weight: 700; }
.text-gray-800 { color: #1a202c; }
.text-sm      { font-size: 14px; }
.text-gray-600 { color: #4a5568; }

@media (min-width: 768px) {
    .md\:flex-row     { flex-direction: row; }
    .md\:text-left    { text-align: left; }
    .md\:space-y-0 > * + * { margin-top: 0; }
    .md\:space-x-6 > * + * { margin-left: 24px; }
}

.student-image {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #3b82f6;
    flex-shrink: 0;
}

.student-info-container {
    position: static;
    padding-right: 0;
    min-height: auto;
    width: 100%;
}

/* ── Logout Button ───────────────────────────────────────────────── */
form.button {
    position: static;
    display: flex;
    justify-content: flex-end;
    margin-top: 18px;
    width: 100%;
}

.logout-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 16px;
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 3px 8px rgba(220,38,38,0.22);
    white-space: nowrap;
}

.logout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(220,38,38,0.32);
    background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
}

.logout-btn:active { transform: translateY(0); }

/* ── Status & Announcement Badges ───────────────────────────────── */
.status-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 9999px;
    font-size: 0.72rem;
    font-weight: 600;
    margin-left: 8px;
}
.status-active  { background-color: #d1fae5; color: #065f46; }
.status-expired { background-color: #fee2e2; color: #991b1b; }

.announcement-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 9999px;
    font-size: 0.72rem;
    font-weight: 600;
    margin-left: 8px;
}
.badge-urgent  { background-color: #fee2e2; color: #dc2626; }
.badge-payment { background-color: #fef3c7; color: #d97706; }
.badge-general { background-color: #dbeafe; color: #2563eb; }

/* ── Announcements Section ───────────────────────────────────────── */
.announcements {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    padding: 24px;
    margin-bottom: 24px;
    border-left: 4px solid #ed8936;
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: #ed8936;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.announcement-list   { list-style: none; }

.announcement-item {
    padding: 14px 0;
    border-bottom: 1px solid #e2e8f0;
}
.announcement-item:last-child { border-bottom: none; }

.announcement-title {
    font-weight: 600;
    color: #1a202c;
    margin-bottom: 6px;
    font-size: 1rem;
    line-height: 1.4;
}

.announcement-text {
    color: #2d3748;
    margin-bottom: 8px;
    line-height: 1.6;
    font-size: 14px;
}

.announcement-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
    color: #718096;
    font-size: 13px;
    margin-top: 6px;
}

.read-more {
    color: #6366f1;
    cursor: pointer;
    font-size: 0.88rem;
    display: inline-block;
}
.read-more:hover { text-decoration: underline; }

.attachment-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    color: #6366f1;
    text-decoration: none;
    font-size: 0.88rem;
    margin-top: 8px;
}
.attachment-link:hover { text-decoration: underline; }

.hidden { display: none; }

/* ── Dashboard Grid ──────────────────────────────────────────────── */
.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 18px;
    margin-top: 24px;
}

@media (min-width: 640px) {
    .dashboard-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (min-width: 1024px) {
    .dashboard-grid { grid-template-columns: repeat(4, 1fr); }
}

.dashboard-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.07);
    padding: 20px;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    border-top: 3px solid transparent;
}

.dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.11);
    border-top-color: #3b82f6;
}

.card-title {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 9px;
}

.card-content {
    color: #4a5568;
    font-size: 14px;
}

/* ── Utility ──────────────────────────────────────────────────────── */
.text-blue  { color: #3b82f6; }
.text-bold  { font-weight: 700; }
.mb-4       { margin-bottom: 16px; }

/* ── Footer ───────────────────────────────────────────────────────── */
footer {
    text-align: center;
    padding: 20px;
    margin-top: 40px;
    color: #718096;
    font-size: 13px;
    border-top: 1px solid #e2e8f0;
}

/* ── Mobile fine-tuning ───────────────────────────────────────────── */
@media (max-width: 480px) {
    .banner {
        padding: 14px 16px;
        border-radius: 10px;
    }

    .school-name  { font-size: 16px; }
    .school-logo  { width: 44px; height: 44px; }
    .portal-tag   { padding: 6px 14px; font-size: 13px; }

    .student-image { width: 90px; height: 90px; }

    .p-6 { padding: 16px; }

    form.button { justify-content: center; }

    .announcements { padding: 16px; }

    .dashboard-card { padding: 16px; }
}
   </style>
</head>
<body>
    <div class="container">
        <!-- Banner Container -->
        <!-- Banner Container -->  
<!-- Banner Container -->
<div class="banner">
    <div class="school-info">
        <div class="school-logo">
            <img src="{{ asset('kiddos-school-master/images/logo-images/new-school-logo (1).jpg') }}"
                 alt="EDMOL Logo"
                 class="school-logo-img"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <span class="school-logo-text" style="display:none;">EDMOL</span>
        </div>
        <div class="school-text">
            <div class="school-name">EDMOL HIGH SCHOOL</div>
            <div class="school-tagline">Excellence · Discipline · Integrity</div>
        </div>
    </div>

    <!-- Live Clock -->
    <div class="banner-clock">
        <div class="clock-time" id="bannerTime">00:00:00</div>
        <div class="clock-date" id="bannerDate">Loading...</div>
    </div>

    <div class="portal-tag">
        <i class="fas fa-user-graduate"></i>
        <span>Student Portal</span>
    </div>
</div>

        <!-- Your Original Working Code - Student Info Card -->
        <div class="bg-white shadow rounded-lg p-6 mb-6 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6 border border-blue-100">
            <!-- Student Image -->    
            
        @php
            $initials = implode('', array_map(function($word) {
                return strtoupper(substr(trim($word), 0, 1));
            }, array_slice(explode(' ', $user->name), 0, 2)));
            
            $svgFallback = 'data:image/svg+xml;utf8,'.rawurlencode(
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">'
                .'<rect width="100" height="100" fill="#0c61ebff"/>'
                .'<text x="50" y="60" font-size="40" text-anchor="middle" fill="white" font-weight="bold">'
                .($initials ?: '?')
                .'</text></svg>'
            );
        @endphp

        <img src="{{ $user->image ? asset('storage/'.$user->image).'?v='.time() : $svgFallback }}" 
             class="student-image"
             onerror="this.onerror=null;this.src='{{ $svgFallback }}'"
             alt="{{ $user->name }} avatar">

        
         <!-- Student Info Container -->
       <div class="student-info-container text-center md:text-left">
           <div class="text-center md:text-left">
            <h2 class="text-lg font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-sm text-gray-600">ID: {{ $user->registration_id }}</p>
            <p class="text-sm text-gray-600">Grade: 
                @if($user->grade)
                    {{ $user->grade->level }}{{ $user->grade->section }}
                @else
                    Not assigned
                @endif
            </p>
            <p class="text-sm text-gray-600">Email: {{ $user->email }}</p>
            <p class="text-sm text-gray-600">Role: {{ ucfirst($user->role) }}</p>
            <form class="button" method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </button>
    </form>
              
    </div>
        </div>
        </div>
        
        

        <!-- Dashboard Content -->
        <h3 class="mb-4 text-xl font-bold text-gray-800">Recent Activity</h3>
        <p class="mb-6 text-gray-600">This is your student dashboard. More features coming soon!</p>

        <!-- Updated Announcements Section -->
        <div class="announcements">
            <h4 class="section-title">
                <i class="fas fa-bullhorn"></i>
                Announcements
            </h4>
            <ul class="announcement-list">
                @foreach($announcements as $announcement)
                <li class="announcement-item">
                    <div class="announcement-title">
                        {{ $announcement->title }}
                        <span class="announcement-badge {{ 
                            $announcement->type === 'urgent' ? 'badge-urgent' : 
                            ($announcement->type === 'payment' ? 'badge-payment' : 'badge-general') 
                        }}">
                            {{ ucfirst($announcement->type) }}
                        </span>
                        
                        @if($announcement->end_date && now()->gt($announcement->end_date))
                            <span class="status-badge status-expired">Expired</span>
                        @else
                            <span class="status-badge status-active">Active</span>
                        @endif
                    </div>
                    
                    <p class="announcement-text">
                        <div id="short-{{ $announcement->id }}">
                            {!! Str::limit(strip_tags($announcement->content), 150) !!}
                            @if(strlen(strip_tags($announcement->content)) > 150)
                                <span class="read-more" onclick="toggleContent({{ $announcement->id }})">...read more</span>
                            @endif
                        </div>
                        <div id="full-{{ $announcement->id }}" class="hidden">
                            {!! strip_tags($announcement->content) !!}
                            <span class="read-more" onclick="toggleContent({{ $announcement->id }})">...show less</span>
                        </div>
                    </p>
                    
                    @if($announcement->attachment)
                    <a href="{{ asset('storage/'.$announcement->attachment) }}" target="_blank" class="attachment-link">
                        <i class="fas fa-paperclip mr-1"></i> View attachment
                    </a>
                    @endif
                    
                    <div class="announcement-meta">
                        <i class="far fa-clock"></i>
                        <span>Posted on {{ $announcement->start_date->format('M d, Y') }}</span>
                        @if($announcement->end_date)
                        <span>to {{ $announcement->end_date->format('M d, Y') }}</span>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Dashboard Cards Grid -->
<div class="dashboard-grid">
    <div class="dashboard-card">
        <h5 class="card-title">
            <i class="fas fa-book text-blue"></i>
            Learning Materials
        </h5>
        <div class="card-content">
            <p>Access all your learning materials, assignments, and resources in one place.</p>
            <a href="{{ route('student.materials') }}" class="inline-flex items-center mt-4 text-blue-500 hover:text-blue-700 font-medium">
                Go to Materials
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
    <div class="dashboard-card">
        <h5 class="card-title">
            <i class="fas fa-book text-blue"></i>
            Courses
        </h5>
        <div class="card-content">
            <p>View your current courses, assignments, and progress.</p>
            <a href="#" class="inline-flex items-center mt-4 text-blue-500 hover:text-blue-700 font-medium">
                View Courses
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
    <div class="dashboard-card">
        <h5 class="card-title">
            <i class="fas fa-chart-line text-blue"></i>
            Grades
        </h5>
        <div class="card-content">
            <p>Check your latest grades and performance reports.</p>
            <a href="{{ route('student.grades') }}"  class="inline-flex items-center mt-4 text-blue-500 hover:text-blue-700 font-medium">
                View Grades
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
    <div class="dashboard-card">
        <h5 class="card-title">
            <i class="fas fa-calendar-alt text-blue"></i>
            Schedule
        </h5>
        <div class="card-content">
            <p>View your class schedule and upcoming events.</p>
            <a href="#" class="inline-flex items-center mt-4 text-blue-500 hover:text-blue-700 font-medium">
                View Schedule
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>

                    </div>

    
    
    <footer>
         <div class="text-sm text-white">
    <p>&copy; <span id="currentYear"></span> EDMOL SCHOOL. All rights reserved.</p>
    <p>Developed by <a href="#" class="text-cyan-300 hover:text-cyan-200 transition-colors font-medium"> ||Potiphar G Vaye||</a></p>
</div>
    <script>
    // Display current year
    document.getElementById('currentYear').textContent = new Date().getFullYear();
</script>
    
    </footer>



    <script>
        // Simple JavaScript to demonstrate interactivity
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.dashboard-card');
            
            cards.forEach(card => {
                card.addEventListener('click', function() {
                    const title = this.querySelector('.card-title').textContent;
                    alert(`You clicked on ${title}`);
                });
            });
            
            // Update the banner with a greeting based on time of day
            const updateBannerGreeting = () => {
                const hour = new Date().getHours();
                let greeting = "Welcome";
                
                if (hour < 12) greeting = "Good Morning";
                else if (hour < 18) greeting = "Good Afternoon";
                else greeting = "Good Evening";
                
                const portalTag = document.querySelector('.portal-tag');
                portalTag.textContent = `${greeting}, Student!`;
            };
            
            updateBannerGreeting();
        });
        
        // Function to toggle announcement content
        function toggleContent(id) {
            const shortContent = document.getElementById('short-' + id);
            const fullContent = document.getElementById('full-' + id);
            
            if (shortContent.classList.contains('hidden')) {
                shortContent.classList.remove('hidden');
                fullContent.classList.add('hidden');
            } else {
                shortContent.classList.add('hidden');
                fullContent.classList.remove('hidden');
            }
        }



        // Live clock for banner
function updateBannerClock() {
    const now  = new Date();

    // Time — HH:MM:SS
    const time = now.toLocaleTimeString('en-US', {
        hour:   '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    });

    // Date — Mon, May 29 2026
    const date = now.toLocaleDateString('en-US', {
        weekday: 'short',
        month:   'short',
        day:     'numeric',
        year:    'numeric'
    });

    const timeEl = document.getElementById('bannerTime');
    const dateEl = document.getElementById('bannerDate');
    if (timeEl) timeEl.textContent = time;
    if (dateEl) dateEl.textContent = date;
}

updateBannerClock();                    // run immediately
setInterval(updateBannerClock, 1000);   // then every second
    </script>
</body>
</html>
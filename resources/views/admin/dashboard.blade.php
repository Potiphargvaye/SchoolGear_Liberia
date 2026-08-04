@extends('layouts.admin')

@section('content')
<div class="flex justify-center items-start min-h-[80vh]">
    <!-- Keep your original background and orbs -->
    <div class="background"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- Keep the original main-content with glass style -->
    <main class="main-content !ml-0 mt-12 w-full max-w-[1200px] px-4">
        <!-- Top Navbar -->
        <nav class="navbar mb-6">
            <h1 class="page-title colo" style="color: aliceblue">Dashboard Overview</h1>
            <div class="navbar-right flex items-center gap-4">
                <div class="search-box flex items-center gap-2">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" class="search-input" placeholder="Search anything...">
                </div>
                <button class="nav-btn relative">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <span class="notification-dot absolute top-0 right-0"></span>
                </button>
                <button class="nav-btn" id="theme-toggle" title="Toggle Light/Dark Mode">
                    <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="4"/>
                        <path d="M12 2v2"/><path d="M12 20v2"/>
                        <path d="M4.93 4.93l1.41 1.41"/><path d="M17.66 17.66l1.41 1.41"/>
                        <path d="M2 12h2"/><path d="M20 12h2"/>
                        <path d="M6.34 17.66l-1.41 1.41"/><path d="M19.07 4.93l-1.41 1.41"/>
                    </svg>
                    <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                </button>
            </div>
        </nav>



         <!-- Stats Cards -->
            <section class="stats-grid">
                <div class="glass-card glass-card-3d stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>
                Total Fees Due
                {{ !empty($selected_year) && $selected_year != 'all' ? "($selected_year)" : '' }}
            </h3>

            <div class="stat-value">
              ${{ number_format($remaining_fees_due, 2) }} 
              <span class="text-xs text-gray-500 ml-1">LRD</span>
            </div>

            <span style="color: rgb(252, 253, 253)" class="stat-change neutral text-xs">
                From {{ $stats->total_records }} fee records
            </span>
        </div>

        <div class="stat-icon cyan">
            <svg viewBox="0 0 24 24" fill="none" stroke="var(--emerald-light)" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
        </div>
    </div>
</div>


    <div class="glass-card glass-card-3d stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Total Fees Collected {{ !empty($selected_year) && $selected_year != 'all' ? "($selected_year)" : '' }}</h3>
            <div class="stat-value" data-currency="LRD">${{ number_format($totalFeesCollected, 2) }}</div>
            @if($stats->total_fees_due > 0)
                <span style="color: aliceblue" class="text-xs text-gray-500 mt-1">
                    {{ number_format(($stats->total_fees_collected / $stats->total_fees_due) * 100, 1) }}% collected
                </span>
            @endif
        </div>
       <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2">
                <path d="M12 1v22"/><path d="M5 12h14"/>
                <circle cx="12" cy="12" r="10"/>
            </svg>
        </div>
    </div>
</div>

     <div class="glass-card glass-card-3d stat-card"> 
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Pending Fees {{ !empty($selected_year) && $selected_year != 'all' ? "($selected_year)" : '' }}</h3>
            <div class="stat-value">
                {{ $stats->pending_count }}  
            </div>
            <div class="" style="color: aliceblue">Students</div>
        </div>
        <div class="stat-icon yellow">
    <svg viewBox="0 0 24 24" fill="none" stroke="var(--warning)" stroke-width="2">
        <line x1="12" y1="1" x2="12" y2="23"/>
        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
    </svg>
</div>
 </div>
</div>

<div class="glass-card glass-card-3d stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Partial Fees</h3>
            <div class="stat-value">
                {{ $stats->partial_count }} 
            </div>
             <div class="" style="color: aliceblue">Students</div>
        </div>
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="var(--warning)" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
        </div>
    </div>
</div>
            </section>


            <!-- Stats Cards -->
            <section class="stats-grid">
               <div class="glass-card glass-card-3d stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Paid Fees</h3>
            <div class="stat-value">
                {{ $stats->paid_count }} 
            </div>
            <div class="" style="color: aliceblue">Students</div>
        </div>
        <div class="stat-icon success">
            <svg viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
        </div>
    </div>
</div>


     <div class="glass-card glass-card-3d stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Overdue Fees</h3>
            <div class="stat-value">
                {{ $stats->overdue_count }} 
            </div>
            <div class="" style="color: aliceblue">Students</div>
        </div>
        <div class="stat-icon danger">
            <svg viewBox="0 0 24 24" fill="none" stroke="var(--danger)" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
        </div>
    </div>
</div>


<div class="glass-card stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Candidate Students</h3>
            <div class="stat-value">{{ $totalCandidates }} students</div>
        </div>

        <div class="stat-icon cyan">
            <div class="stat-icon blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="glass-card stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Admitted Students</h3>
            <div class="stat-value">{{ $totalAdmitted }} students</div>
        </div>

        <div class="stat-icon">
            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="#16a34a"  <!-- green-600 -->
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
    </div>
</div>


<div class="glass-card stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Registered Students</h3>
            <div class="stat-value">{{ $totalRegistered }} students</div>
        </div>
        <div class="stat-icon cyan">
            <!-- same SVG icon as your other cards -->
            <div class="stat-icon green">
    <svg viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
</div>

        </div>
    </div>
</div>


<div class="glass-card stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Active Students</h3>
            <div class="stat-value">{{ $totalActive }} students</div>
        </div>

        <div class="stat-icon">
            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="#2563eb"  <!-- blue-600 -->
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
    </div>
</div>


<div class="glass-card stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Dropout Students</h3>
            <div class="stat-value">{{ $totalDropout }} students</div>
        </div>

        <div class="stat-icon">
            <!-- User Minus / Dropout Icon -->
            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="#dc2626"  <!-- red-600 -->
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <!-- User -->
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <!-- Minus sign -->
                <line x1="17" y1="11" x2="23" y2="11"/>
            </svg>
        </div>
    </div>
</div>

<div class="glass-card stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Completed Students</h3>
            <div class="stat-value">{{ $totalCompleted }} students</div>
        </div>

        <div class="stat-icon">
            <!-- User Check / Completed Icon -->
            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="#16a34a"  <!-- green-600 -->
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <!-- User -->
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <!-- Check mark -->
                <polyline points="16 11 18 13 22 9"/>
            </svg>
        </div>
    </div>
</div>

 <!-- For the system users only  -->
<div class="glass-card stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Total System Users</h3>
            <div class="stat-value">{{ $totalUsers }}</div>
        </div>

        <div class="stat-icon">
            <!-- Users / Group Icon -->
            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="#6366f1"  <!-- indigo-500 -->
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
    </div>
</div>

<div class="glass-card stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Teachers</h3>
            <div class="stat-value">{{ $totalTeachers }}</div>
        </div>

        <div class="stat-icon">
            <!-- Teacher / Academic Icon -->
            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="#0ea5e9"  <!-- sky-500 -->
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <!-- Head -->
                <circle cx="12" cy="7" r="4"/>
                <!-- Body -->
                <path d="M5.5 21v-2a6.5 6.5 0 0 1 13 0v2"/>
                <!-- Book / Teaching -->
                <path d="M3 10h6v4H3z"/>
                <path d="M15 10h6v4h-6z"/>
            </svg>
        </div>
    </div>
</div>

<div class="glass-card stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Administrators</h3>
            <div class="stat-value">{{ $totalAdmins }}</div>
        </div>

        <div class="stat-icon">
            <!-- Admin / Shield Icon -->
            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="#6366f1"  <!-- indigo-500 -->
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z"/>
                <path d="M9 12l2 2 4-4"/>
            </svg>
        </div>
    </div>
</div>

<div class="glass-card stat-card">
    <div class="stat-card-inner">
        <div class="stat-info">
            <h3>Students</h3>
            <div class="stat-value">{{ $totalStudents }}</div>
        </div>

        <div class="stat-icon">
            <!-- Users / Group Icon -->
            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="#10b981" <!-- emerald-500 -->
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M7 21v-2a4 4 0 0 1 3-3.87"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
    </div>
</div>
 </section>
        
            <!-- Content Grid -->
            <section class="content-grid">
                <!-- Chart Card -->
                <div class="glass-card chart-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-title" style="color: #f0f3f7">Revenue Analytics</h2>
                            <p class="card-subtitle" style="color: #f0f3f7">Monthly revenue overview</p>
                        </div>
                        <div class="card-actions">
                            <button class="card-btn active">Monthly</button>
                            <button class="card-btn">Weekly</button>
                            <button class="card-btn">Daily</button>
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <div class="chart-container">
                            <div class="chart-y-axis">
                                <span class="y-value">$00LRD</span>
                                <span class="y-value">$00LRD</span>
                                <span class="y-value">$00LRD</span>
                                <span class="y-value">$00LRD</span>
                                <span class="y-value">$00LRD</span>
                                <span class="y-value">$00LRD</span>
                            </div>
                            <div class="chart-placeholder">
                                <div class="chart-bar-group"><div class="chart-bar bar-emerald" style="height: 120px;"></div><span class="chart-label">Jan</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-gold" style="height: 160px;"></div><span class="chart-label">Feb</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-coral" style="height: 90px;"></div><span class="chart-label">Mar</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-teal" style="height: 140px;"></div><span class="chart-label">Apr</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-amber" style="height: 180px;"></div><span class="chart-label">May</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-emerald" style="height: 130px;"></div><span class="chart-label">Jun</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-gold" style="height: 170px;"></div><span class="chart-label">Jul</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-coral" style="height: 150px;"></div><span class="chart-label">Aug</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-teal" style="height: 190px;"></div><span class="chart-label">Sep</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-amber" style="height: 140px;"></div><span class="chart-label">Oct</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-emerald" style="height: 175px;"></div><span class="chart-label">Nov</span></div>
                                <div class="chart-bar-group"><div class="chart-bar bar-gold" style="height: 200px;"></div><span class="chart-label">Dec</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Feed -->
                <div class="glass-card activity-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-title" style="color: #f0f3f7">Recent Activity</h2>
                            <p class="card-subtitle">Latest transactions</p>
                        </div>
                    </div>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-avatar" style="background: linear-gradient(135deg, var(--emerald-light), var(--emerald));">JD</div>
                            <div class="activity-content">
                                <p class="activity-text"><strong>John Doe</strong> purchased Premium Plan</p>
                                <span class="activity-time">2 minutes ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-avatar" style="background: linear-gradient(135deg, var(--gold), var(--amber));">AS</div>
                            <div class="activity-content">
                                <p class="activity-text"><strong>Anna Smith</strong> submitted a support ticket</p>
                                <span class="activity-time">15 minutes ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-avatar" style="background: linear-gradient(135deg, var(--coral), var(--gold));">MJ</div>
                            <div class="activity-content">
                                <p class="activity-text"><strong>Mike Johnson</strong> upgraded subscription</p>
                                <span class="activity-time">1 hour ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-avatar" style="background: linear-gradient(135deg, var(--success), var(--emerald));">EW</div>
                            <div class="activity-content">
                                <p class="activity-text"><strong>Emily White</strong> completed onboarding</p>
                                <span class="activity-time">2 hours ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-avatar" style="background: linear-gradient(135deg, var(--warning), var(--gold));">RB</div>
                            <div class="activity-content">
                                <p class="activity-text"><strong>Robert Brown</strong> requested refund</p>
                                <span class="activity-time">3 hours ago</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="glass-card table-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-title" style="color: aliceblue">Recent Transactions</h2>
                            <p class="card-subtitle" style="color: aliceblue">Latest  payments transactions</p>
                        </div>
                        <div class="card-actions">
                           <a href="{{ route('admin.fees.index') }}" class="card-btn"> View All </a>
                            <button class="card-btn">Export</button>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Students</th>
                                    <th>Grade</th>
                                    <th>Trasation Date</th>
                                    <th>Status</th>
                                    <th>Amount Paid</th>
                                </tr>
                            </thead>
                           <tbody>
@foreach($recentTransactions as $fee)
    <tr>
        <td>
            <div class="table-user">
                <div class="table-avatar" style="background: linear-gradient(135deg, var(--emerald-light), var(--emerald));">
                    {{ strtoupper(substr($fee->student->name, 0, 2)) }}
                </div>
                <div class="table-user-info">
                    <span class="table-user-name">{{ $fee->student->name }}</span>
                </div>
            </div>
        </td>
            <!-- Class -->
        <td
            class="px-3 py-2 whitespace-nowrap text-xs font-black"
            style="font-family: Arial rgb(245, 242, 242); color: #f0f3f7;"
        >
            {{ $fee->student->class_applying_for ?? 'N/A' }}
        </td>
        <td>{{ \Carbon\Carbon::parse($fee->payment_date)->format('M d, Y') }}</td>
        <td>
            <span class="status-badge 
                @if($fee->status == 'paid') completed
                @elseif($fee->status == 'partial') processing
                @elseif($fee->status == 'pending') pending
                @elseif($fee->status == 'overdue') overdue
                @endif">
                {{ ucfirst($fee->status) }}
            </span>
        </td>
        <td>
            <span class="table-amount">${{ number_format($fee->paid_amount, 2) }}</span>
        </td>
    </tr>
@endforeach
</tbody>

                        </table>
                    </div>
                </div>
            </section>

            <!-- Bottom Grid -->
            <section class="bottom-grid">
               <!-- Calendar Widget -->
<div class="glass-card">
    <div class="calendar-header">
        <h2  class="card-title" style="color: aquamarine" id="calendarTitle"></h2>
        <div class="calendar-nav">
            <button class="calendar-nav-btn" id="prevMonth">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </button>
            <button class="calendar-nav-btn" id="nextMonth">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </button>
        </div>
    </div>

    <div class="calendar-grid" id="calendarGrid"></div>
</div>


                <!-- Donut Chart -->
                <div class="glass-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-title" style="color: aquamarine">Traffic Sources</h2>
                            <p class="card-subtitle">User acquisition breakdown</p>
                        </div>
                    </div>
                    <div class="donut-container">
                        <div class="donut-chart">
                            <svg width="140" height="140" viewBox="0 0 140 140">
                                <circle class="donut-bg" cx="70" cy="70" r="54"/>
                                <circle class="donut-segment" cx="70" cy="70" r="54" stroke="var(--emerald-light)" stroke-dasharray="169.6 339.3" stroke-dashoffset="0"/>
                                <circle class="donut-segment" cx="70" cy="70" r="54" stroke="var(--gold)" stroke-dasharray="101.8 339.3" stroke-dashoffset="-169.6"/>
                                <circle class="donut-segment" cx="70" cy="70" r="54" stroke="var(--coral)" stroke-dasharray="67.9 339.3" stroke-dashoffset="-271.4"/>
                            </svg>
                            <div class="donut-center">
                                <div class="donut-value" style="color: aqua">24.5K</div>
                                <div class="donut-label">Visitors</div>
                            </div>
                        </div>
                        <div class="donut-legend">
                            <div class="legend-item"><span class="legend-color cyan"></span><span>Organic Search (50%)</span></div>
                            <div class="legend-item"><span class="legend-color magenta"></span><span>Social Media (30%)</span></div>
                            <div class="legend-item"><span class="legend-color purple"></span><span>Direct Traffic (20%)</span></div>
                        </div>
                    </div>
                </div>

                <!-- Progress Card -->
                <div class="glass-card progress-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-title" style="color: aqua">Students Progress by class</h2>
                            <p class="card-subtitle" style="color: aqua">Coming-Soon!</p>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-header"><span class="progress-label">Grade 9th</span><span class="progress-value">85%</span></div>
                        <div class="progress-bar"><div class="progress-fill cyan" style="width: 85%;"></div></div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-header"><span class="progress-label">Grade 10th</span><span class="progress-value">62%</span></div>
                        <div class="progress-bar"><div class="progress-fill magenta" style="width: 62%;"></div></div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-header"><span class="progress-label">Grade 11th</span><span class="progress-value">45%</span></div>
                        <div class="progress-bar"><div class="progress-fill purple" style="width: 45%;"></div></div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-header"><span class="progress-label">Grade 12th </span><span class="progress-value">28%</span></div>
                        <div class="progress-bar"><div class="progress-fill cyan" style="width: 28%;"></div></div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Learning Materials</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Your existing CSS styles remain exactly the same */
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
            padding: 0 20px;
        }
        
        /* ... ALL YOUR EXISTING CSS STYLES ... */
        
    </style>
</head>
<body>
    <div class="container">
        <!-- Banner Container -->
        <div class="banner">
            <div class="school-info">
                <div class="school-logo">EDMOL</div>
                <div class="school-name">EDMOL HIGH SCHOOL</div>
            </div>
            <div class="portal-tag">Student Portal</div>
        </div>

        <!-- Student Info Card -->
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

        
        <!-- Navigation Tabs -->
<div class="nav-tabs">
    <a href="{{ route('student.dashboard') }}" class="nav-tab {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" onclick="switchTab('dashboard', event)">
        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
    </a>
    <a href="{{ route('student.materials') }}" class="nav-tab {{ request()->routeIs('student.materials') ? 'active' : '' }}" onclick="switchTab('materials', event)">
        <i class="fas fa-book mr-2"></i>Learning Materials
    </a>
    <a href="#" class="nav-tab" onclick="switchTab('assignments', event)">
        <i class="fas fa-tasks mr-2"></i>Assignments
    </a>
    <a href="#" class="nav-tab" onclick="switchTab('grades', event)">
        <i class="fas fa-chart-bar mr-2"></i>Grades
    </a>
</div>
        <!-- Page Title -->
        <div class="section-title">
            <i class="fas fa-book-open text-blue-500"></i>
            <span>Learning Materials</span>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
                <div class="flex-1">
                    <input type="text" id="searchInput" placeholder="Search materials..." class="search-input">
                </div>
                <div class="flex space-x-4">
                    <select id="typeFilter" class="filter-select">
                        <option value="">All Types</option>
                        <option value="assignment">Assignments</option>
                        <option value="note">Notes</option>
                        <option value="resource">Resources</option>
                        <option value="video">Videos</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Materials Grid -->
        <div id="materialsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($materials as $material)
            <div class="material-card fade-in slide-up">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <span class="material-badge material-badge-{{ $material->type }}">
                                {{ ucfirst($material->type) }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $material->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $material->description }}</p>

                    <!-- Meta Information -->
                    <div class="space-y-2">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-users-class mr-2"></i>
                            <span>Grade {{ $material->grade->level }}{{ $material->grade->section }}</span>
                        </div>
                        
                        @if($material->due_date)
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>Due: {{ $material->due_date->format('M d, Y') }}</span>
                        </div>
                        @endif

                        @if($material->max_score)
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-star mr-2"></i>
                            <span>Max Score: {{ $material->max_score }}</span>
                        </div>
                        @endif

                        @if($material->file_path)
                        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="flex items-center text-sm text-blue-600 hover:text-blue-800 hover:underline cursor-pointer">
                            <i class="fas fa-paperclip mr-2"></i>
                            <span>View Attachment</span>
                        </a>
                        @endif
                    </div>

                    <!-- Status -->
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <span class="status-badge status-published">
                                Published
                            </span>
                            <span class="text-xs text-gray-400">
                                {{ $material->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-tasks"></i>
                <h3>No materials yet</h3>
                <p>Check back later for new learning materials</p>
            </div>
            @endforelse
        </div>

        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="loading-spinner">
            <i class="fas fa-spinner fa-spin text-3xl text-blue-500"></i>
            <p class="mt-2 text-gray-600">Loading materials...</p>
        </div>

        <!-- Pagination -->
        @if($materials->hasPages())
        <div class="mt-8" id="paginationContainer">
            {{ $materials->links() }}
        </div>
        @endif

        <footer>
            <div class="text-sm text-white">
                <p>&copy; <span id="currentYear"></span> EDMOL SCHOOL. All rights reserved.</p>
                <p>Developed by <a href="#" class="text-blue hover:text-blue-600 transition-colors font-medium"> ||Potiphar G Vaye||</a></p>
            </div>
    </div>

    <script>
    // Display current year
    document.getElementById('currentYear').textContent = new Date().getFullYear();

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

    // Search functionality
    let searchTimeout;
    
    function performSearch() {
        const searchTerm = document.getElementById('searchInput').value.trim();
        const typeFilter = document.getElementById('typeFilter').value;
        
        console.log('Searching for:', searchTerm, 'Type:', typeFilter);
        
        // Show loading spinner
        showLoadingSpinner();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Set new timeout for search with debouncing
        searchTimeout = setTimeout(() => {
            // Build URL with proper parameters
            const url = new URL('/student/materials', window.location.origin);
            url.searchParams.set('search', searchTerm);
            url.searchParams.set('type', typeFilter);
            url.searchParams.set('ajax', 'true');
            
            console.log('Fetching from:', url.toString());
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                // Hide loading spinner
                hideLoadingSpinner();
                
                // Update the materials grid
                updateMaterialsGrid(data.materials || []);
                
                // Update pagination if provided
                if (data.pagination) {
                    updatePagination(data.pagination);
                }
                
                // Show search results info
                showSearchResultsInfo(data.materials?.length || 0, data.total || 0);
            })
            .catch(error => {
                console.error('Error details:', error);
                hideLoadingSpinner();
                showErrorMessage('Search failed. Please check your connection and try again.');
            });
        }, 500);
    }

    // Loading spinner functions
    function showLoadingSpinner() {
        const spinner = document.getElementById('loadingSpinner');
        spinner.style.display = 'block';
    }

    function hideLoadingSpinner() {
        const spinner = document.getElementById('loadingSpinner');
        spinner.style.display = 'none';
    }

    // Update materials grid from JSON data
    function updateMaterialsGrid(materials) {
        const materialsGrid = document.getElementById('materialsGrid');
        const paginationContainer = document.getElementById('paginationContainer');
        
        console.log('Updating grid with materials:', materials);
        
        if (!materials || materials.length === 0) {
            materialsGrid.innerHTML = `
                <div class="empty-state fade-in">
                    <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-600">No materials found</h3>
                    <p class="text-gray-500">Try adjusting your search criteria</p>
                </div>
            `;
            
            // Hide pagination when no results
            if (paginationContainer) {
                paginationContainer.style.display = 'none';
            }
            return;
        }
        
        // Show pagination if it was hidden
        if (paginationContainer) {
            paginationContainer.style.display = 'block';
        }
        
        let newContent = '';
        materials.forEach((material, index) => {
            const animationDelay = index * 0.1;
            newContent += `
                <div class="material-card fade-in slide-up" style="animation-delay: ${animationDelay}s">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <span class="material-badge material-badge-${material.type}">
                                    ${material.type.charAt(0).toUpperCase() + material.type.slice(1)}
                                </span>
                            </div>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-800 mb-2">${material.title}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">${material.description || 'No description available'}</p>

                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-users-class mr-2"></i>
                                <span>Grade ${material.grade.level}${material.grade.section}</span>
                            </div>
                            
                            ${material.due_date ? `
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>Due: ${material.due_date}</span>
                            </div>
                            ` : ''}

                            ${material.max_score ? `
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-star mr-2"></i>
                                <span>Max Score: ${material.max_score}</span>
                            </div>
                            ` : ''}

                            ${material.file_path ? `
                            <a href="${material.file_path}" target="_blank" class="flex items-center text-sm text-blue-600 hover:text-blue-800 hover:underline cursor-pointer">
                                <i class="fas fa-paperclip mr-2"></i>
                                <span>View Attachment</span>
                            </a>
                            ` : ''}
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <span class="status-badge status-published">
                                    Published
                                </span>
                                <span class="text-xs text-gray-400">
                                    ${material.created_at}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        materialsGrid.innerHTML = newContent;
    }

    function updatePagination(paginationHtml) {
        const paginationContainer = document.getElementById('paginationContainer');
        if (paginationContainer && paginationHtml) {
            paginationContainer.innerHTML = paginationHtml;
        }
    }

    function showSearchResultsInfo(currentCount, totalCount) {
        const searchTerm = document.getElementById('searchInput').value.trim();
        const typeFilter = document.getElementById('typeFilter').value;
        
        let resultsInfo = document.getElementById('searchResultsInfo');
        
        if (!resultsInfo) {
            resultsInfo = document.createElement('div');
            resultsInfo.id = 'searchResultsInfo';
            resultsInfo.className = 'mb-4';
            document.querySelector('.section-title').after(resultsInfo);
        }
        
        if (searchTerm || typeFilter) {
            const searchText = searchTerm ? `for "${searchTerm}"` : '';
            const filterText = typeFilter ? `in ${typeFilter}` : '';
            const connector = searchTerm && typeFilter ? ' and ' : '';
            
            resultsInfo.innerHTML = `
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    Showing ${currentCount} of ${totalCount} materials ${searchText}${connector}${filterText}
                    <button onclick="clearSearch()" class="ml-2 text-blue-600 hover:text-blue-800 font-medium">Clear filters</button>
                </div>
            `;
        } else {
            resultsInfo.innerHTML = '';
        }
    }

    // Clear search and filters
    function clearSearch() {
        document.getElementById('searchInput').value = '';
        document.getElementById('typeFilter').value = '';
        performSearch();
    }

    // Show error message
    function showErrorMessage(message) {
        // Use a simple notification instead of alert
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg z-50';
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        document.body.appendChild(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        
        searchInput.addEventListener('input', performSearch);
        typeFilter.addEventListener('change', performSearch);
        
        // Add enter key support for search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
        
        // Initial load - hide loading spinner
        hideLoadingSpinner();
    });
    



    // Enhanced tab switching for SPA
function switchTab(tabName) {
    // Remove active class from all tabs
    document.querySelectorAll('.nav-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Add active class to clicked tab
    document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
    
    // Load content based on tab
    loadTabContent(tabName);
    
    // Update browser URL
    history.pushState({tab: tabName}, null, `/student/${tabName}`);
}

// Handle browser back/forward buttons
window.addEventListener('popstate', function(event) {
    if (event.state && event.state.tab) {
        switchTab(event.state.tab);
    }
});
</script>
</body>
</html>





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
    padding: 0 20px;
}

/* Banner Styles */
.banner {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: white;
    padding: 20px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 20px 0;
}

.school-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.school-logo {
    width: 50px;
    height: 50px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
    color: #1e40af;
}

.school-name {
    font-weight: 700;
    font-size: 20px;
    letter-spacing: 0.5px;
}

.portal-tag {
    background: rgba(255, 255, 255, 0.2);
    padding: 8px 18px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 16px;
    backdrop-filter: blur(10px);
}

/* Student Info Card */
.bg-white {
    background: white;
}

.shadow {
    box-shadow: 0 4px 12px rgba(235, 45, 45, 0.08);
}

.rounded-lg {
    border-radius: 12px;
}

.p-6 {
    padding: 25px;
}

.mb-6 {
    margin-bottom: 25px;
}

.flex {
    display: flex;
}

.flex-col {
    flex-direction: column;
}

.items-center {
    align-items: center;
}

.space-y-4 > * + * {
    margin-top: 16px;
}

.border {
    border: 1px solid #e2e8f0;
}

.border-blue-100 {
    border-color: #e2e8f0;
}

.text-center {
    text-align: center;
}

.md\:text-left {
    text-align: left;
}

.text-lg {
    font-size: 18px;
}

.font-bold {
    font-weight: 700;
}

.text-gray-800 {
    color: #01050fff;
}

.text-sm {
    font-size: 15px;
}

.text-gray-600 {
    color: #060606ff;
}

/* Responsive styles */
@media (min-width: 768px) {
    .md\:flex-row {
        flex-direction: row;
    }
    
    .md\:space-y-0 > * + * {
        margin-top: 0;
    }
    
    .md\:space-x-6 > * + * {
        margin-left: 24px;
    }
}


/* Footer */
footer {
    text-align: center;
    padding: 20px;
    margin-top: 40px;
    color: #718096;
    font-size: 14px;
    border-top: 1px solid #e2e8f0;
    width: 100vw;
    margin-left: calc(-50vw + 50%);
    background-color: #f7fafc;
}

footer .text-sm {
    font-size: 15px;
}

footer .text-white {
    color: #718096;
}

.text-blue {
    color: #3b82f6;
}

.hover\:text-blue-600:hover {
    color: #2563eb;
}

.transition-colors {
    transition: color 0.2s ease;
}

.font-medium {
    font-weight: 500;
}

/* Utility Classes */
.text-bold {
    font-weight: 700;
}

.mb-4 {
    margin-bottom: 16px;
}



.student-image {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #3b82f6;
    flex-shrink: 0;
}

/* Logout Button Styles */
.student-info-container {
    position: static;
    padding-right: 0;
    min-height: auto;
}

form.button {
    position: static;
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
    width: 100%;
}

.logout-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 3px 6px rgba(220, 38, 38, 0.2);
    white-space: nowrap;
}

.logout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 10px rgba(220, 38, 38, 0.3);
    background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
}

.logout-btn:active {
    transform: translateY(0);
}

@media (max-width: 768px) {
    form.button {
        justify-content: center;
    }
}

/* Materials Grid Styles */
.grid {
    display: grid;
    gap: 1.5rem;
}

.grid-cols-1 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
}

@media (min-width: 768px) {
    .md\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (min-width: 1024px) {
    .lg\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

.material-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
}

.material-card:hover {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}

.material-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.material-badge-assignment {
    background-color: #e0f2fe;
    color: #0369a1;
}

.material-badge-note {
    background-color: #f0fdf4;
    color: #15803d;
}

.material-badge-resource {
    background-color: #f3e8ff;
    color: #7c3aed;
}

.material-badge-video {
    background-color: #fef7cd;
    color: #ca8a04;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Status Badges */
.status-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-published {
    background-color: #d1fae5;
    color: #065f46;
}

.status-draft {
    background-color: #fef3c7;
    color: #92400e;
}

/* Search and Filter Styles */
.search-input {
    width: 100%;
    padding: 10px 16px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.2s;
}

.search-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.filter-select {
    padding: 10px 16px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    background-color: white;
    cursor: pointer;
    transition: all 0.2s;
}

.filter-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Animation classes */
.fade-in {
    animation: fadeIn 0.5s ease-in-out;
}

.slide-up {
    animation: slideUp 0.4s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from { 
        opacity: 0;
        transform: translateY(20px);
    }
    to { 
        opacity: 1;
        transform: translateY(0);
    }
}

/* Navigation Tabs */
.nav-tabs {
    display: flex;
    border-bottom: 1px solid #e2e8f0;
    margin-bottom: 24px;
    overflow-x: auto;
}

.nav-tab {
    padding: 12px 24px;
    font-weight: 500;
    color: #64748b;
    border-bottom: 2px solid transparent;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.nav-tab:hover {
    color: #3b82f6;
}

.nav-tab.active {
    color: #3b82f6;
    border-bottom-color: #3b82f6;
}

/* Section Title */
.section-title {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 48px 24px;
    color: #64748b;
    grid-column: 1 / -1;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    color: #cbd5e1;
}

.empty-state h3 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #475569;
}

.empty-state p {
    font-size: 14px;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    margin-top: 32px;
}

.pagination li {
    margin: 0 4px;
}

.pagination a, .pagination span {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}

.pagination a {
    color: #3b82f6;
    border: 1px solid #d1d5db;
}

.pagination a:hover {
    background-color: #f3f4f6;
}

.pagination .active span {
    background-color: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.pagination .disabled span {
    color: #9ca3af;
    cursor: not-allowed;
}

.loading-spinner {
    display: none;
    text-align: center;
    padding: 20px;
}
</style>
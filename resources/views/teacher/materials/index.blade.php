@extends('layouts.teacher')

@section('title', 'Manage Materials - WKG')

@section('content')

<style>
    /* Material Management Styles */
    .btn-primary {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(79, 70, 229, 0.3);
    }

    .search-input {
        width: 100%;
        padding: 10px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        transition: border-color 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .filter-select {
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: white;
        transition: border-color 0.3s ease;
        width: 100%;
    }

    .filter-select:focus {
        outline: none;
        border-color: #4f46e5;
    }

    .material-card {
        transition: all 0.3s ease;
        border: 1px solid #f3f4f6;
    }

    .material-card:hover {
        transform: translateY(-2px);
    }

    .material-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .material-badge-assignment {
        background: #fee2e2;
        color: #dc2626;
    }

    .material-badge-note {
        background: #dbeafe;
        color: #2563eb;
    }

    .material-badge-resource {
        background: #dcfce7;
        color: #16a34a;
    }

    .action-btn {
        padding: 6px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .action-btn-edit {
        color: #6b7280;
    }

    .action-btn-edit:hover {
        background: #f3f4f6;
        color: #374151;
    }

    /* Fixed Dropdown Styles */
    .dropdown-menu-container {
        position: absolute;
        right: 0;
        top: 100%;
        z-index: 50;
        margin-top: 0.5rem;
    }

    .dropdown-menu-content {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        min-width: 160px;
        padding: 0.5rem 0;
    }

    .dropdown-item {
        display: block;
        padding: 10px 16px;
        color: #374151;
        text-decoration: none;
        transition: background 0.3s ease;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background: #f9fafb;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-published {
        background: #dcfce7;
        color: #16a34a;
    }

    .status-draft {
        background: #fef3c7;
        color: #d97706;
    }

    /* Pagination Styles */
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 4px;
    }

    .pagination a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #6b7280;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        background: #f9fafb;
        color: #374151;
    }

    .pagination .active a {
        background: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }

    /* Attachment link */
    .attachment-link {
        transition: all 0.2s ease;
    }

    .attachment-link:hover {
        transform: translateX(2px);
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

    /* Shimmer effect for loading */
    .shimmer {
        position: relative;
        overflow: hidden;
    }

    .shimmer::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.4),
            transparent
        );
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        0% {
            left: -100%;
        }
        100% {
            left: 100%;
        }
    }

    /* Search Results Info */
    #searchResultsInfo .bg-blue-50 {
        background-color: #eff6ff;
        border-color: #dbeafe;
    }

    /* Mobile Responsive Filters */
    @media (min-width: 640px) {
        .filter-select {
            width: auto;
            min-width: 150px;
        }
    }

    @media (max-width: 639px) {
        .flex-col.sm\:flex-row {
            flex-direction: column;
        }
        
        .filter-select {
            margin-bottom: 8px;
        }
        
        .filter-select:last-child {
            margin-bottom: 0;
        }
    }
    
</style>
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Teaching Materials</h1>
                    <p class="text-gray-600">Manage your assignments, notes, and resources</p>
                </div>
                <a href="javascript:void(0)" onclick="openCreateModal()" class="btn-primary mt-4 md:mt-0">
                    <i class="fas fa-plus mr-2"></i> Add New Material
                </a>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
                <div class="flex-1">
                    <input type="text" id="searchInput" placeholder="Search materials by title or description..." class="search-input">
                </div>
                <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0 w-full sm:w-auto">
                    <select id="typeFilter" class="filter-select">
                        <option value="">All Types</option>
                        <option value="assignment">Assignments</option>
                        <option value="note">Notes</option>
                        <option value="resource">Resources</option>
                    </select>
                    <select id="gradeFilter" class="filter-select">
                        <option value="">All Grades</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}">Grade {{ $grade->level }}{{ $grade->section }}</option>
                        @endforeach
                    </select>
                    <select id="statusFilter" class="filter-select">
                        <option value="">All Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Search Results Info -->
        <div id="searchResultsInfo" class="mb-4"></div>

        <!-- Materials Grid -->
        <div id="materialsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($materials as $material)
            <div class="material-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow fade-in slide-up">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <span class="material-badge material-badge-{{ $material->type }}">
                                {{ ucfirst($material->type) }}
                            </span>
                        </div>
                       
                        <!-- Dropdown Menu Container -->
                        <div class="flex space-x-2 relative">
                            <button class="action-btn action-btn-edit" onclick="toggleDropdown('dropdown-{{ $material->id }}')">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <!-- Dropdown Menu -->
                            <div id="dropdown-{{ $material->id }}" class="dropdown-menu-container hidden">
                                <div class="dropdown-menu-content">
                                <a href="javascript:void(0)" onclick="openEditModal({{ $material->id }})" class="dropdown-item">
                                   <i class="fas fa-edit mr-2"></i> Edit
                                       </a>
                                       <a href="javascript:void(0)" onclick="openDeleteModal({{ $material->id }}, '{{ addslashes($material->title) }}')" class="dropdown-item">
                                      <i class="fas fa-trash mr-2"></i> Delete
                                         </a>
    
                            <form action="{{ route('teacher.materials.toggle-publish', $material) }}" method="POST" class="dropdown-item-form">
                                @csrf
                              <button type="button" onclick="togglePublishMaterial(this)" 
                              class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                            <i class="fas fa-{{ $material->is_published ? 'eye-slash' : 'eye' }} mr-2"></i>
                           {{ $material->is_published ? 'Unpublish' : 'Publish' }}
                          </button>
                          </form>
</div>
                            </div>
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
                            <span class="status-badge status-{{ $material->is_published ? 'published' : 'draft' }}">
                                {{ $material->is_published ? 'Published' : 'Draft' }}
                            </span>
                            <span class="text-xs text-gray-400">
                                {{ $material->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <i class="fas fa-tasks text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-600">No materials yet</h3>
                    <p class="text-gray-500 mt-2">Get started by creating your first assignment or note</p>
                    <a href="javascript:void(0)" onclick="openCreateModal()" class="btn-primary mt-4 md:mt-0">
                        <i class="fas fa-plus mr-2"></i> Add New Material
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="loading-spinner">
            <div class="flex flex-col items-center">
                <div class="relative">
                    <i class="fas fa-spinner fa-spin text-4xl text-purple-500 mb-2"></i>
                    <div class="absolute inset-0 bg-purple-500 rounded-full animate-ping opacity-20"></div>
                </div>
                <p class="mt-2 text-gray-600 font-medium">Searching materials...</p>
                <p class="text-sm text-gray-400">Please wait while we find the best matches</p>
            </div>
        </div>

        <!-- Pagination -->
        @if($materials->hasPages())
        <div class="mt-8" id="paginationContainer">
            {{ $materials->links() }}
        </div>
        @endif
    </div>

    <!-- Create Material Modal -->
<div id="createMaterialModal" class="fixed inset-0 bg-blue-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-8 mx-auto p-2 w-full max-w-2xl">
        <div class="bg-white rounded-2xl shadow-2xl border border-blue-100 transform transition-all duration-300 hover:shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)]">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-2xl">
                <div class="text-white">
                    <h3 class="text-2xl font-bold">Create New Material</h3>
                    <p class="text-blue-100 mt-1">Add assignments, notes, or resources for your students</p>
                </div>
                <button onclick="closeCreateModal()" class="text-white hover:bg-red-500 hover:scale-110 transition-all duration-200 p-2 rounded-full bg-red-500">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 max-h-[70vh] overflow-y-auto">
                <form id="createMaterialForm" action="{{ route('teacher.materials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6">
                        <!-- Basic Information -->
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                                Basic Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-blue-700 mb-2">Title *</label>
                                    <input type="text" name="title" required 
                                           class="w-full px-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-blue-400"
                                           placeholder="Enter material title">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-blue-700 mb-2">Type *</label>
                                    <select name="type" required 
                                            class="w-full px-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white"
                                            onchange="toggleAssignmentFields(this.value)">
                                        <option value="" class="text-blue-400">Select Type</option>
                                        <option value="assignment" class="text-blue-800">Assignment</option>
                                        <option value="note" class="text-blue-800">Note</option>
                                        <option value="resource" class="text-blue-800">Resource</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Grade Selection -->
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                            <label class="block text-sm font-medium text-blue-700 mb-2">Grade *</label>
                            <select name="grade_id" required 
                                    class="w-full px-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="" class="text-blue-400">Select Grade</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}" class="text-blue-800">Grade {{ $grade->level }}{{ $grade->section }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                            <label class="block text-sm font-medium text-blue-700 mb-2">Description</label>
                            <textarea name="description" rows="3" 
                                      class="w-full px-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-blue-400 resize-none"
                                      placeholder="Describe the material..."></textarea>
                        </div>

                        <!-- File Upload -->
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                            <label class="block text-sm font-medium text-blue-700 mb-2">Attachment</label>
                            <div class="border-2 border-dashed border-blue-300 rounded-xl p-8 text-center hover:border-blue-500 hover:bg-blue-50 transition-all duration-300 cursor-pointer bg-white">
                                <input type="file" name="file" class="hidden" id="fileInput" onchange="displayFileName(this)">
                                <label for="fileInput" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-blue-400 mb-3"></i>
                                    <p class="text-blue-600 font-medium">Click to upload or drag and drop</p>
                                    <p class="text-blue-400 text-sm mt-1">PDF, DOC, DOCX, TXT, JPG, PNG (Max: 2MB)</p>
                                </label>
                            </div>
                            <div id="fileName" class="hidden mt-3 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 font-medium text-sm"></div>
                        </div>

                        <!-- Assignment Specific Fields -->
                        <div id="assignmentFields" class="hidden bg-yellow-50 p-4 rounded-xl border border-yellow-200">
                            <h3 class="text-lg font-semibold text-yellow-800 mb-4 flex items-center">
                                <i class="fas fa-tasks mr-2 text-yellow-600"></i>
                                Assignment Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-yellow-700 mb-2">Due Date</label>
                                    <input type="datetime-local" name="due_date" 
                                           class="w-full px-4 py-3 border border-yellow-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-yellow-700 mb-2">Maximum Score</label>
                                    <input type="number" name="max_score" min="0" 
                                           class="w-full px-4 py-3 border border-yellow-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200"
                                           placeholder="Enter max score">
                                </div>
                            </div>
                        </div>

                        <!-- Publish Option -->
                        <div class="flex items-center bg-blue-50 p-4 rounded-xl border border-blue-200">
                            <input type="checkbox" name="is_published" id="is_published" 
                                   class="w-5 h-5 text-blue-600 border-blue-300 rounded focus:ring-blue-500 focus:ring-2 transition-all duration-200">
                            <label for="is_published" class="ml-3 text-blue-700 font-medium cursor-pointer hover:text-blue-800 transition-colors duration-200">
                                Publish immediately
                            </label>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 pt-6 border-t border-blue-200 flex flex-col sm:flex-row justify-end gap-3">
                        <button type="button" onclick="closeCreateModal()" 
                                class="px-6 py-3 border border-blue-300 text-blue-700 rounded-xl hover:bg-blue-50 hover:border-blue-400 hover:scale-105 transition-all duration-200 font-medium order-2 sm:order-1">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 hover:scale-105 transform transition-all duration-200 font-semibold shadow-lg hover:shadow-xl order-1 sm:order-2 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Create Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</div>


<!-- Edit Material Modal -->
<div id="editMaterialModal" class="fixed inset-0 bg-blue-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-8 mx-auto p-2 w-full max-w-2xl">
        <div class="bg-white rounded-2xl shadow-2xl border border-blue-100 transform transition-all duration-300 hover:shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)]">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-2xl">
                <div class="text-white">
                    <h3 class="text-2xl font-bold">Edit Material</h3>
                    <p class="text-blue-100 mt-1">Update your teaching material</p>
                </div>
                <button onclick="closeEditModal()" class="text-white hover:bg-red-500 hover:scale-110 transition-all duration-200 p-2 rounded-full bg-red-400">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 max-h-[70vh] overflow-y-auto">
                <form id="editMaterialForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <!-- Basic Information -->
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                                Basic Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-blue-700 mb-2">Title *</label>
                                    <input type="text" name="title" required 
                                           class="w-full px-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-blue-400"
                                           placeholder="Enter material title" id="editTitle">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-blue-700 mb-2">Type *</label>
                                    <select name="type" required 
                                            class="w-full px-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white"
                                            onchange="toggleEditAssignmentFields(this.value)" id="editType">
                                        <option value="" class="text-blue-400">Select Type</option>
                                        <option value="assignment" class="text-blue-800">Assignment</option>
                                        <option value="note" class="text-blue-800">Note</option>
                                        <option value="resource" class="text-blue-800">Resource</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Grade Selection -->
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                            <label class="block text-sm font-medium text-blue-700 mb-2">Grade *</label>
                            <select name="grade_id" required 
                                    class="w-full px-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white"
                                    id="editGradeId">
                                <option value="" class="text-blue-400">Select Grade</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}" class="text-blue-800">Grade {{ $grade->level }}{{ $grade->section }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                            <label class="block text-sm font-medium text-blue-700 mb-2">Description</label>
                            <textarea name="description" rows="3" 
                                      class="w-full px-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-blue-400 resize-none"
                                      placeholder="Describe the material..." id="editDescription"></textarea>
                        </div>

                        <!-- File Upload -->
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                            <label class="block text-sm font-medium text-blue-700 mb-2">Attachment</label>
                            <div id="currentFileContainer" class="mb-3 p-3 bg-gray-50 rounded-lg border border-gray-200 hidden">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-paperclip text-gray-400 mr-2"></i>
                                        <span class="text-sm text-gray-600" id="currentFileName"></span>
                                    </div>
                                    <a href="#" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm" id="currentFileLink">
                                        View File
                                    </a>
                                </div>
                            </div>
                            
                            <div class="border-2 border-dashed border-blue-300 rounded-xl p-8 text-center hover:border-blue-500 hover:bg-blue-50 transition-all duration-300 cursor-pointer bg-white">
                                <input type="file" name="file" class="hidden" id="editFileInput" onchange="displayEditFileName(this)">
                                <label for="editFileInput" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-blue-400 mb-3"></i>
                                    <p class="text-blue-600 font-medium">Click to upload or drag and drop</p>
                                    <p class="text-blue-400 text-sm mt-1">PDF, DOC, DOCX, TXT, JPG, PNG (Max: 2MB)</p>
                                </label>
                            </div>
                            <div id="editFileName" class="hidden mt-3 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 font-medium text-sm"></div>
                        </div>

                        <!-- Assignment Specific Fields -->
                        <div id="editAssignmentFields" class="hidden bg-yellow-50 p-4 rounded-xl border border-yellow-200">
                            <h3 class="text-lg font-semibold text-yellow-800 mb-4 flex items-center">
                                <i class="fas fa-tasks mr-2 text-yellow-600"></i>
                                Assignment Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-yellow-700 mb-2">Due Date</label>
                                    <input type="datetime-local" name="due_date" 
                                           class="w-full px-4 py-3 border border-yellow-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200"
                                           id="editDueDate">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-yellow-700 mb-2">Maximum Score</label>
                                    <input type="number" name="max_score" min="0" 
                                           class="w-full px-4 py-3 border border-yellow-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200"
                                           placeholder="Enter max score" id="editMaxScore">
                                </div>
                            </div>
                        </div>

                        <!-- Publish Option -->
                        <div class="flex items-center bg-blue-50 p-4 rounded-xl border border-blue-200">
                            <input type="checkbox" name="is_published" id="editIsPublished" 
                                   class="w-5 h-5 text-blue-600 border-blue-300 rounded focus:ring-blue-500 focus:ring-2 transition-all duration-200">
                            <label for="editIsPublished" class="ml-3 text-blue-700 font-medium cursor-pointer hover:text-blue-800 transition-colors duration-200">
                                Publish material
                            </label>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 pt-6 border-t border-blue-200 flex flex-col sm:flex-row justify-end gap-3">
                        <button type="button" onclick="closeEditModal()" 
                                class="px-6 py-3 border border-blue-300 text-blue-700 rounded-xl hover:bg-blue-50 hover:border-blue-400 hover:scale-105 transition-all duration-200 font-medium order-2 sm:order-1">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 hover:scale-105 transform transition-all duration-200 font-semibold shadow-lg hover:shadow-xl order-1 sm:order-2 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Update Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Delete Confirmation Modal -->
<div id="deleteMaterialModal" class="fixed inset-0 bg-blue-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-2 w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl border border-red-100">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-red-600 to-red-700 rounded-t-2xl">
                <div class="text-white">
                    <h3 class="text-xl font-bold">Confirm Delete</h3>
                </div>
                <button onclick="closeDeleteModal()" class="text-white hover:bg-red-500 hover:scale-110 transition-all duration-200 p-2 rounded-full">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <p class="text-gray-700 mb-4">Are you sure you want to delete this material?</p>
                <p id="deleteMaterialDetails" class="font-bold text-gray-800 my-3 p-3 bg-gray-50 rounded-lg border border-gray-200"></p>
                <p class="text-red-600 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>This action cannot be undone.
                </p>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 p-4 rounded-b-2xl border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()" 
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                    <i class="fas fa-times mr-2"></i> Cancel
                </button>
                <form id="deleteMaterialForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 font-semibold">
                        <i class="fas fa-trash mr-2"></i> Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    // Search functionality
    let searchTimeout;
    
    function performSearch() {
        const searchTerm = document.getElementById('searchInput').value.trim();
        const typeFilter = document.getElementById('typeFilter').value;
        const gradeFilter = document.getElementById('gradeFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;
        
        // Show loading spinner
        showLoadingSpinner();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Set new timeout for search with debouncing
        searchTimeout = setTimeout(() => {
            const params = new URLSearchParams({
                search: searchTerm,
                type: typeFilter,
                grade: gradeFilter,
                status: statusFilter,
                ajax: true
            });
            
            // Use the current page URL for the AJAX request
            fetch(`?${params}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
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
        const materialsGrid = document.getElementById('materialsGrid');
        
        // Create shimmer effect on existing cards
        if (materialsGrid) {
            materialsGrid.querySelectorAll('.material-card').forEach(card => {
                card.style.opacity = '0.6';
                card.classList.add('shimmer');
            });
        }
        
        // Show spinner below the content
        spinner.style.display = 'block';
    }

    function hideLoadingSpinner() {
        const spinner = document.getElementById('loadingSpinner');
        const materialsGrid = document.getElementById('materialsGrid');
        
        // Remove shimmer effect
        if (materialsGrid) {
            materialsGrid.querySelectorAll('.material-card').forEach(card => {
                card.style.opacity = '1';
                card.classList.remove('shimmer');
            });
        }
        
        spinner.style.display = 'none';
    }

    // Update materials grid from JSON data
    function updateMaterialsGrid(materials) {
        const materialsGrid = document.getElementById('materialsGrid');
        const paginationContainer = document.getElementById('paginationContainer');
        
        if (!materials || materials.length === 0) {
            const searchTerm = document.getElementById('searchInput').value.trim();
            const typeFilter = document.getElementById('typeFilter').value;
            const gradeFilter = document.getElementById('gradeFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            
            let emptyMessage = '';
            if (searchTerm || typeFilter || gradeFilter || statusFilter) {
                emptyMessage = `
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-600">No materials found</h3>
                            <p class="text-gray-500 mt-2">Try adjusting your search criteria</p>
                            <button onclick="clearSearch()" class="btn-primary mt-4">
                                <i class="fas fa-times mr-2"></i> Clear Filters
                            </button>
                        </div>
                    </div>
                `;
            } else {
                emptyMessage = `
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <i class="fas fa-tasks text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-600">No materials yet</h3>
                            <p class="text-gray-500 mt-2">Get started by creating your first assignment or note</p>
                            <a href="javascript:void(0)" onclick="openCreateModal()" class="btn-primary mt-4">
                                <i class="fas fa-plus mr-2"></i> Add New Material
                            </a>
                        </div>
                    </div>
                `;
            }
            
            materialsGrid.innerHTML = emptyMessage;
            
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
                <div class="material-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow fade-in slide-up" style="animation-delay: ${animationDelay}s">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <span class="material-badge material-badge-${material.type}">
                                    ${material.type.charAt(0).toUpperCase() + material.type.slice(1)}
                                </span>
                            </div>
                            <div class="flex space-x-2 relative">
                                <button class="action-btn action-btn-edit" onclick="toggleDropdown('dropdown-${material.id}')">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div id="dropdown-${material.id}" class="dropdown-menu-container hidden">
                                    <div class="dropdown-menu-content">
                                        <a href="javascript:void(0)" onclick="openEditModal(${material.id})" class="dropdown-item">
                                            <i class="fas fa-edit mr-2"></i> Edit
                                        </a>
                                        <form action="/teacher/materials/${material.id}" method="POST" class="dropdown-item">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" onclick="return confirm('Are you sure?')" class="w-full text-left">
                                                <i class="fas fa-trash mr-2"></i> Delete
                                            </button>
                                        </form>
                                        <form action="/teacher/materials/${material.id}/toggle-publish" method="POST" class="dropdown-item">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="w-full text-left">
                                                <i class="fas fa-${material.is_published ? 'eye-slash' : 'eye'} mr-2"></i>
                                                ${material.is_published ? 'Unpublish' : 'Publish'}
                                            </button>
                                        </form>
                                    </div>
                                </div>
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
                                <span class="status-badge status-${material.is_published ? 'published' : 'draft'}">
                                    ${material.is_published ? 'Published' : 'Draft'}
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
        const gradeFilter = document.getElementById('gradeFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;
        
        let resultsInfo = document.getElementById('searchResultsInfo');
        
        if (!resultsInfo) {
            resultsInfo = document.createElement('div');
            resultsInfo.id = 'searchResultsInfo';
            resultsInfo.className = 'mb-4';
            document.querySelector('.max-w-7xl').insertBefore(resultsInfo, document.getElementById('materialsGrid'));
        }
        
        if (searchTerm || typeFilter || gradeFilter || statusFilter) {
            const searchText = searchTerm ? `for "${searchTerm}"` : '';
            const typeText = typeFilter ? `type: ${typeFilter}` : '';
            const gradeText = gradeFilter ? `grade: ${document.getElementById('gradeFilter').options[document.getElementById('gradeFilter').selectedIndex].text}` : '';
            const statusText = statusFilter ? `status: ${statusFilter}` : '';
            
            const filters = [typeText, gradeText, statusText].filter(Boolean).join(', ');
            const connector = searchTerm && filters ? ' and ' : '';
            
            resultsInfo.innerHTML = `
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    Showing ${currentCount} of ${totalCount} materials ${searchText}${connector}${filters ? ` with ${filters}` : ''}
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
        document.getElementById('gradeFilter').value = '';
        document.getElementById('statusFilter').value = '';
        performSearch();
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        const gradeFilter = document.getElementById('gradeFilter');
        const statusFilter = document.getElementById('statusFilter');
        
        searchInput.addEventListener('input', performSearch);
        typeFilter.addEventListener('change', performSearch);
        gradeFilter.addEventListener('change', performSearch);
        statusFilter.addEventListener('change', performSearch);
        
        // Add enter key support for search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
        
        // Initial load - hide loading spinner
        hideLoadingSpinner();
    });

    // Existing dropdown functionality
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        
        // Close all other dropdowns first
        document.querySelectorAll('.dropdown-menu-container').forEach(menu => {
            if (menu.id !== dropdownId) {
                menu.classList.add('hidden');
            }
        });
        
        // Toggle the current dropdown
        dropdown.classList.toggle('hidden');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.action-btn') && !event.target.closest('.dropdown-menu-container')) {
            document.querySelectorAll('.dropdown-menu-container').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });

    // Prevent dropdown from closing when clicking inside it
    document.querySelectorAll('.dropdown-menu-container').forEach(menu => {
        menu.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });

    // ========== CREATE MODAL FUNCTIONALITY ==========
    function openCreateModal() {
        const modal = document.getElementById('createMaterialModal');
        modal.classList.remove('hidden');
        modal.classList.add('modal-enter');
        document.body.style.overflow = 'hidden';
    }

    function closeCreateModal() {
        const modal = document.getElementById('createMaterialModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        resetForm();
    }

    function toggleAssignmentFields(type) {
        const assignmentFields = document.getElementById('assignmentFields');
        if (type === 'assignment') {
            assignmentFields.classList.remove('hidden');
        } else {
            assignmentFields.classList.add('hidden');
        }
    }

    function displayFileName(input) {
        const fileNameDisplay = document.getElementById('fileName');
        if (input.files.length > 0) {
            fileNameDisplay.textContent = `Selected file: ${input.files[0].name}`;
            fileNameDisplay.classList.remove('hidden');
        } else {
            fileNameDisplay.classList.add('hidden');
        }
    }

    function resetForm() {
        document.getElementById('createMaterialForm').reset();
        document.getElementById('assignmentFields').classList.add('hidden');
        document.getElementById('fileName').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('createMaterialModal');
        if (event.target === modal) {
            closeCreateModal();
        }
    });

    // Handle form submission with AJAX
    document.getElementById('createMaterialForm').addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Form submitted via AJAX');
        
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        
        // Show loading state
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Creating...';
        submitButton.disabled = true;

        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            
            if (response.status === 422) {
                return response.json().then(data => {
                    throw new Error('Validation failed: ' + JSON.stringify(data.errors));
                });
            }
            
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.status);
            }
            
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            } else {
                return response.text().then(text => {
                    throw new Error('Server returned non-JSON response: ' + text.substring(0, 100));
                });
            }
        })
        .then(data => {
            console.log('Success data:', data);
            if (data.success) {
                closeCreateModal();
                showSuccessMessage('Material created successfully!');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                throw new Error(data.message || 'Failed to create material');
            }
        })
        .catch(error => {
            console.error('Full error:', error);
            
            if (error.name === 'SyntaxError') {
                showErrorMessage('Server returned invalid JSON. Check your controller response.');
            } else if (error.message.includes('non-JSON response')) {
                showErrorMessage('Server error: ' + error.message);
            } else {
                showErrorMessage('Failed to create material: ' + error.message);
            }
            
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        });
    });

    // ========== EDIT MODAL FUNCTIONALITY ==========
function openEditModal(materialId) {
    console.log('Opening edit modal for material ID:', materialId);
    
    // Show loading state
    showInfoMessage('Loading material data...');
    
    // Get CSRF token from the CREATE form (which already exists on the page)
    const csrfToken = document.querySelector('#createMaterialForm input[name="_token"]').value;
    console.log('CSRF Token:', csrfToken);
    
    fetch(`/teacher/materials/${materialId}/edit?ajax=1`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
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
        
        if (data.success) {
            const material = data.material;
            
            // Populate form fields
            document.getElementById('editTitle').value = material.title;
            document.getElementById('editType').value = material.type;
            document.getElementById('editGradeId').value = material.grade_id;
            document.getElementById('editDescription').value = material.description || '';
            document.getElementById('editDueDate').value = material.due_date || '';
            document.getElementById('editMaxScore').value = material.max_score || '';
            document.getElementById('editIsPublished').checked = material.is_published;
            
            // Set form action
            document.getElementById('editMaterialForm').action = `/teacher/materials/${materialId}`;
            
            // Handle file display
            if (material.file_path) {
                document.getElementById('currentFileContainer').classList.remove('hidden');
                document.getElementById('currentFileName').textContent = `Current file: ${material.file_name}`;
                document.getElementById('currentFileLink').href = `/storage/${material.file_path}`;
            } else {
                document.getElementById('currentFileContainer').classList.add('hidden');
            }
            
            // Toggle assignment fields
            toggleEditAssignmentFields(material.type);
            
            // Show modal
            const modal = document.getElementById('editMaterialModal');
            modal.classList.remove('hidden');
            
            console.log('Modal populated successfully');
        } else {
            throw new Error(data.message || 'Failed to load material data');
        }
    })
    .catch(error => {
        console.error('Full error details:', error);
        showErrorMessage('Failed to load material data: ' + error.message);
    });
}

function closeEditModal() {
    const modal = document.getElementById('editMaterialModal');
    if (modal) {
        modal.classList.add('hidden');
        resetEditForm();
    }
}

function toggleEditAssignmentFields(type) {
    const assignmentFields = document.getElementById('editAssignmentFields');
    if (assignmentFields) {
        if (type === 'assignment') {
            assignmentFields.classList.remove('hidden');
        } else {
            assignmentFields.classList.add('hidden');
        }
    }
}

function displayEditFileName(input) {
    const fileNameDisplay = document.getElementById('editFileName');
    if (fileNameDisplay) {
        if (input.files.length > 0) {
            fileNameDisplay.textContent = `Selected file: ${input.files[0].name}`;
            fileNameDisplay.classList.remove('hidden');
        } else {
            fileNameDisplay.classList.add('hidden');
        }
    }
}

function resetEditForm() {
    document.getElementById('editMaterialForm').reset();
    document.getElementById('editAssignmentFields').classList.add('hidden');
    document.getElementById('editFileName').classList.add('hidden');
    document.getElementById('currentFileContainer').classList.add('hidden');
}

// Close edit modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('editMaterialModal');
    if (event.target === modal) {
        closeEditModal();
    }
});

// Handle edit form submission with AJAX
document.getElementById('editMaterialForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Edit form submitted via AJAX');
    
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Show loading state
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Updating...';
    submitButton.disabled = true;

    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success data:', data);
        if (data.success) {
            closeEditModal();
            showSuccessMessage('Material updated successfully!');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Failed to update material');
        }
    })
    .catch(error => {
        console.error('Full error:', error);
        showErrorMessage('Failed to update material: ' + error.message);
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
});


// ========== DELETE MODAL FUNCTIONALITY ==========
function openDeleteModal(materialId, materialTitle) {
    console.log('Opening delete modal for material ID:', materialId);
    
    // Set delete details
    document.getElementById('deleteMaterialDetails').textContent = `"${materialTitle}"`;
    
    // Set form action
    document.getElementById('deleteMaterialForm').action = `/teacher/materials/${materialId}`;
    
    // Show modal
    const modal = document.getElementById('deleteMaterialModal');
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteMaterialModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Handle delete form submission with AJAX
document.getElementById('deleteMaterialForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Delete form submitted via AJAX');
    
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Show loading state
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Deleting...';
    submitButton.disabled = true;

    fetch(this.action, {
        method: 'DELETE', 
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Delete success data:', data);
        if (data.success) {
            closeDeleteModal();
            showSuccessMessage('Material deleted successfully!');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Failed to delete material');
        }
    })
    .catch(error => {
        console.error('Delete error:', error);
        showErrorMessage('Failed to delete material: ' + error.message);
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
});

// Close delete modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('deleteMaterialModal');
    if (event.target === modal) {
        closeDeleteModal();
    }
});


// ========== PUBLISH/UNPUBLISH FUNCTIONALITY ==========
function togglePublishMaterial(button) {
    const form = button.closest('form');
    const originalText = button.innerHTML;
    const isPublishing = button.textContent.includes('Publish');
    
    console.log('Toggling publish status, isPublishing:', isPublishing);
    
    // Show loading state
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Updating...';
    button.disabled = true;

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Publish success data:', data);
        if (data.success) {
            showSuccessMessage(isPublishing ? 'Material published successfully!' : 'Material unpublished successfully!');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || `Failed to ${isPublishing ? 'publish' : 'unpublish'} material`);
        }
    })
    .catch(error => {
        console.error('Publish error:', error);
        showErrorMessage(`Failed to ${isPublishing ? 'publish' : 'unpublish'} material: ` + error.message);
        button.innerHTML = originalText;
        button.disabled = false;
    });
}
    // ========== NOTIFICATION SYSTEM ==========
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        
        const styles = {
            success: 'bg-gradient-to-r from-green-500 to-green-600 border-l-4 border-green-700',
            error: 'bg-gradient-to-r from-red-500 to-red-600 border-l-4 border-red-700',
            warning: 'bg-gradient-to-r from-yellow-500 to-yellow-600 border-l-4 border-yellow-700',
            info: 'bg-gradient-to-r from-blue-500 to-blue-600 border-l-4 border-blue-700'
        };

        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-triangle',
            warning: 'fa-exclamation-circle',
            info: 'fa-info-circle'
        };

        notification.className = `fixed top-4 right-4 z-50 transform translate-x-full opacity-0 transition-all duration-500 ease-in-out ${styles[type]} text-white p-4 rounded-xl shadow-2xl max-w-sm min-w-80 backdrop-blur-sm border-l-4`;
        
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas ${icons[type]} text-xl flex-shrink-0"></i>
                <span class="flex-1 text-sm font-medium">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" 
                        class="flex-shrink-0 p-1 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors duration-200">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        // Trigger animation
        setTimeout(() => {
            notification.classList.remove('translate-x-full', 'opacity-0');
            notification.classList.add('translate-x-0', 'opacity-100');
        }, 10);

        // Auto remove after 7 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.classList.remove('translate-x-0', 'opacity-100');
                notification.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 500);
            }
        }, 7000);
    }

    // Helper functions for different notification types
    function showSuccessMessage(message) {
        showNotification(message, 'success');
    }

    function showErrorMessage(message) {
        showNotification(message, 'error');
    }

    function showWarningMessage(message) {
        showNotification(message, 'warning');
    }

    function showInfoMessage(message) {
        showNotification(message, 'info');
    }
</script>
@endsection
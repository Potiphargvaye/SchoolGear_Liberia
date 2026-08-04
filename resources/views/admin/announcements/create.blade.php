@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Banner Header -->
    <div class="banner bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-6 mb-6 rounded-xl shadow-sm">
        <h2 class="text-2xl sm:text-3xl font-bold">Create New Announcement</h2>
        <p class="text-indigo-100 mt-2">Share important information with students and staff</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Title Field -->
                <div class="mb-6">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" 
                           class="form-input"
                           placeholder="Enter announcement title"
                           required>
                    @error('title')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rich Text Editor -->
                <div class="mb-6">
                    <label class="form-label">Content</label>
                    <textarea id="richEditor" name="content" rows="6" 
                              class="form-input"
                              placeholder="Write your announcement content here..."
                              required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}"
                               class="form-input"
                               required>
                        @error('start_date')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">End Date (optional)</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}"
                               class="form-input"
                               placeholder="Select end date">
                        @error('end_date')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Type Selection -->
                <div class="mb-6">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-input" required>
                        <option value="">Select announcement type</option>
                        <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General Announcement</option>
                        <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
                        <option value="payment" {{ old('type') == 'payment' ? 'selected' : '' }}>Payment Due</option>
                        <option value="urgent" {{ old('type') == 'urgent' ? 'selected' : '' }}>Urgent Notice</option>
                    </select>
                    @error('type')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority Level -->
                <div class="mb-6">
                    <label class="form-label">Priority Level</label>
                    <select name="priority" class="form-input">
                        <option value="0" {{ old('priority', 0) == 0 ? 'selected' : '' }}>Normal</option>
                        <option value="1" {{ old('priority', 0) == 1 ? 'selected' : '' }}>Important</option>
                        <option value="2" {{ old('priority', 0) == 2 ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>

                <!-- Pinned Announcement -->
                <div class="mb-6 flex items-center p-4 bg-gray-50 rounded-lg">
                    <input type="checkbox" name="is_pinned" id="is_pinned" value="1"
                           class="checkbox-input"
                           {{ old('is_pinned') ? 'checked' : '' }}>
                    <label for="is_pinned" class="checkbox-label">Pin this announcement to top of the list</label>
                </div>

                <!-- File Attachment -->
                <div class="mb-6">
                    <label class="form-label">Attachment (optional)</label>
                    <div class="file-input">
                        <label class="file-input-label">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-cloud-upload-alt"></i>
                                Choose Attachment File
                            </span>
                            <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.png">
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 pl-1">Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max: 2MB)</p>
                    @error('attachment')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.announcements.index') }}" class="btn-cancel">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="btn-create">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .banner {
        box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
    }
    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    .form-input:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
    }
    .form-input::placeholder {
        color: #9ca3af;
    }
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .checkbox-input {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 4px;
        border: 1px solid #d1d5db;
        margin-right: 0.75rem;
        accent-color: #4f46e5;
    }
    .checkbox-label {
        font-weight: 500;
        color: #374151;
        cursor: pointer;
    }
    .file-input {
        position: relative;
        overflow: hidden;
    }
    .file-input input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    .file-input-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1rem;
        background: #f9fafb;
        border: 1px dashed #d1d5db;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .file-input-label:hover {
        border-color: #4f46e5;
        background: #f0f5ff;
    }
    .btn-create {
        background: #4f46e5;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
    }
    .btn-create:hover {
        background: #4338ca;
        transform: translateY(-1px);
    }
    .btn-cancel {
        background: #dc2626;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        text-align: center;
    }
    .btn-cancel:hover {
        background: #b91c1c;
        transform: translateY(-1px);
    }
</style>

@push('scripts') 
<!-- TinyMCE Rich Text Editor -->
<script src="https://cdn.tiny.cloud/1/YOUR-API-KEY/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#richEditor',
        plugins: 'lists link image table code help',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code',
        height: 300,
        menubar: false,
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        placeholder: 'Write your announcement content here...'
    });
</script>
@endpush 

@endsection










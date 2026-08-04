@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Banner Header -->
    <div class="banner bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-6 mb-6 rounded-xl shadow-sm">
        <h2 class="text-2xl sm:text-3xl font-bold">Edit Announcement</h2>
        <p class="text-indigo-100 mt-2">Update announcement details and content</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Title Field -->
                <div class="mb-6">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" value="{{ old('title', $announcement->title) }}" 
                           class="form-input"
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
                              required>{{ old('content', $announcement->content) }}</textarea>
                    @error('content')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $announcement->start_date->format('Y-m-d')) }}"
                               class="form-input"
                               required>
                        @error('start_date')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">End Date (optional)</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $announcement->end_date ? $announcement->end_date->format('Y-m-d') : '') }}"
                               class="form-input">
                        @error('end_date')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Type Selection -->
                <div class="mb-6">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-input" required>
                        <option value="general" {{ old('type', $announcement->type) == 'general' ? 'selected' : '' }}>General Announcement</option>
                        <option value="event" {{ old('type', $announcement->type) == 'event' ? 'selected' : '' }}>Event</option>
                        <option value="payment" {{ old('type', $announcement->type) == 'payment' ? 'selected' : '' }}>Payment Due</option>
                        <option value="urgent" {{ old('type', $announcement->type) == 'urgent' ? 'selected' : '' }}>Urgent Notice</option>
                    </select>
                    @error('type')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority Level -->
                <div class="mb-6">
                    <label class="form-label">Priority Level</label>
                    <select name="priority" class="form-input">
                        <option value="0" {{ old('priority', $announcement->priority) == 0 ? 'selected' : '' }}>Normal</option>
                        <option value="1" {{ old('priority', $announcement->priority) == 1 ? 'selected' : '' }}>Important</option>
                        <option value="2" {{ old('priority', $announcement->priority) == 2 ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>

                <!-- Pinned Announcement -->
                <div class="mb-6 flex items-center p-4 bg-gray-50 rounded-lg">
                    <input type="checkbox" name="is_pinned" id="is_pinned" value="1"
                           class="checkbox-input"
                           {{ old('is_pinned', $announcement->is_pinned) ? 'checked' : '' }}>
                    <label for="is_pinned" class="checkbox-label">Pin this announcement to top</label>
                </div>

                <!-- Attachment Field -->
                <div class="mb-6">
                    <label class="form-label">Attachment (optional)</label>
                    
                    @if($announcement->attachment)
                    <div class="flex items-center mb-4 gap-4 p-4 bg-blue-50 rounded-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                            <a href="{{ asset('storage/'.$announcement->attachment) }}" target="_blank" 
                               class="text-blue-600 hover:underline font-medium">
                                View Current Attachment
                            </a>
                        </div>
                        
                        <button type="button" onclick="document.getElementById('remove_attachment').checked = true; this.classList.add('hidden'); document.getElementById('remove_notice').classList.remove('hidden')" 
                                class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Remove
                        </button>
                        <input type="checkbox" id="remove_attachment" name="remove_attachment" class="hidden">
                        <span id="remove_notice" class="hidden text-sm text-green-600 flex items-center bg-green-50 px-3 py-1 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Will be removed on save
                        </span>
                    </div>
                    @endif
                    
                    <div class="file-input">
                        <label class="file-input-label">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-upload"></i>
                                Choose New Attachment
                            </span>
                            <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.png">
                        </label>
                    </div>
                    
                    <p class="text-xs text-gray-500 mt-2">Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max: 2MB)</p>
                    @error('attachment')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.announcements.index') }}" class="btn-secondary">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Update Announcement
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
    .btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
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
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(79, 70, 229, 0.3);
    }
    .btn-secondary {
        background: white;
        color: #4b5563;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        text-align: center;
    }
    .btn-secondary:hover {
        background: #f9fafb;
        border-color: #d1d5db;
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
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
</script>
@endpush

@endsection
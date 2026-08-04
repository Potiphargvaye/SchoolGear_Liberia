@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header with Create Button -->
    <div class="banner bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-6 mb-6 rounded-xl shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl sm:text-3xl font-bold">Announcements Management</h2>
        <a href="{{ route('admin.announcements.create') }}" class="flex items-center gap-2 bg-white text-indigo-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Create New Announcement
        </a>
    </div>

    <!-- Announcements Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title & Content</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attachment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($announcements as $announcement)
                    <tr class="announcement-row hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900 text-lg">{{ $announcement->title }}</div>
                            <div class="mt-2 text-sm text-gray-600">
                                <div id="short-{{ $announcement->id }}">
                                    {!! Str::limit(strip_tags($announcement->content), 150) !!}
                                    @if(strlen(strip_tags($announcement->content)) > 150)
                                        <span class="text-indigo-500 hover:text-indigo-700 cursor-pointer underline ml-1" 
                                              onclick="toggleContent({{ $announcement->id }})">...read more</span>
                                    @endif
                                </div>
                                <div id="full-{{ $announcement->id }}" class="hidden bg-gray-50 p-3 rounded-lg mt-2">
                                    {!! strip_tags($announcement->content) !!}
                                    <span class="text-indigo-500 hover:text-indigo-700 cursor-pointer underline block mt-2" 
                                          onclick="toggleContent({{ $announcement->id }})">...show less</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($announcement->attachment)
                            <a href="{{ asset('storage/'.$announcement->attachment) }}" target="_blank" 
                               class="inline-flex items-center text-indigo-600 hover:text-indigo-900 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                                View File
                            </a>
                            @else
                            <span class="text-gray-400 italic">None</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ 
                                $announcement->type === 'urgent' ? 'bg-red-100 text-red-800 border border-red-200' : 
                                ($announcement->type === 'payment' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : 
                                'bg-blue-100 text-blue-800 border border-blue-200') 
                            }}">
                                {{ ucfirst($announcement->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <div class="font-medium">{{ $announcement->start_date->format('M d, Y') }}</div>
                            @if($announcement->end_date)
                            <div class="text-gray-400 text-xs mt-1">to {{ $announcement->end_date->format('M d, Y') }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border
                                {{ $announcement->end_date && now()->gt($announcement->end_date) ? 'bg-red-100 text-red-800 border-red-200' : 'bg-green-100 text-green-800 border-green-200' }}">
                                {{ $announcement->end_date && now()->gt($announcement->end_date) ? 'Expired' : 'Active' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.announcements.edit', $announcement->id) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 transition-colors"
                                   title="Edit Announcement">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 transition-colors"
                                            onclick="return confirm('Are you sure you want to delete this announcement?')"
                                            title="Delete Announcement">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        

</div>

<style>
    .announcement-row {
        transition: all 0.2s ease;
    }
    .announcement-row:hover {
        background-color: #f9fafb;
        transform: translateY(-1px);
    }
    .banner {
        box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
    }
    table {
        border-collapse: separate;
        border-spacing: 0;
    }
    th {
        background: linear-gradient(to bottom, #f8fafc, #f1f5f9);
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }
    td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
    }
    tr:last-child td {
        border-bottom: none;
    }
</style>

<script>
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
</script>
@endsection
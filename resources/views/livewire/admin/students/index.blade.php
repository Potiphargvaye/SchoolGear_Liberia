<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-4">
    @include('partials.notifications')
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
        <h1 class="text-2xl font-bold">Students</h1>
        <div class="flex flex-wrap gap-2">
            <button wire:click="openSmsModal"
                class="px-3 py-2 bg-green-600 text-white rounded
               hover:bg-green-700 flex items-center gap-1 text-sm">

                <!-- WhatsApp SVG Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M20.52 3.48A11.82 11.82 0 0012.01 0C5.38 0 .02 5.36.02 12c0 2.11.55 4.17 1.6 5.98L0 24l6.2-1.62A11.93 11.93 0 0012 24c6.63 0 11.99-5.36 11.99-12 0-3.2-1.25-6.21-3.47-8.52zM12 21.8c-1.84 0-3.63-.5-5.2-1.44l-.37-.22-3.68.96.98-3.59-.24-.37A9.77 9.77 0 012.2 12c0-5.4 4.4-9.8 9.8-9.8 2.62 0 5.08 1.02 6.93 2.87A9.73 9.73 0 0121.8 12c0 5.4-4.4 9.8-9.8 9.8zm5.4-7.36c-.3-.15-1.78-.88-2.05-.98-.27-.1-.47-.15-.67.15-.2.3-.77.98-.95 1.18-.17.2-.35.22-.65.07-.3-.15-1.28-.47-2.44-1.5-.9-.8-1.5-1.78-1.68-2.08-.17-.3-.02-.46.13-.61.14-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.48-.5-.67-.51h-.57c-.2 0-.52.07-.8.37s-1.05 1.02-1.05 2.48c0 1.45 1.08 2.85 1.23 3.05.15.2 2.13 3.25 5.16 4.56.72.31 1.28.5 1.72.64.72.23 1.37.2 1.88.12.57-.08 1.78-.73 2.03-1.44.25-.72.25-1.33.17-1.45-.07-.12-.27-.2-.57-.35z" />
                </svg>

                <span>WhatsApp</span>
            </button>
            <button wire:click="exportExcel"
                class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600 flex items-center gap-1">
                <i class="ri-file-excel-line"></i> Export
            </button>

            <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 flex items-center gap-1">
                Email
            </button>
            @if ($canManage)
                <button wire:click="$set('showAddModal', true)"
                    class="px-4 py-2 bg-[#f84525] text-white rounded hover:bg-red-600 flex items-center gap-1">
                    <i class="ri-add-line"></i> Register New
                </button>
            @endif
        </div>
    </div>

    {{-- Status Tabs --}}
    <div class="flex flex-wrap gap-2 border-b pb-3 mt-3 overflow-x-auto">

        @php
            $tabs = [
                'candidate' => 'ri-user-search-line',
                'admitted' => 'ri-user-follow-line',
                'registered' => 'ri-user-add-line',
                'active' => 'ri-user-star-line',
                'dropout' => 'ri-user-unfollow-line',
                'completed' => 'ri-graduation-cap-line',
            ];
        @endphp

        @foreach ($tabs as $tab => $icon)
            @php
                $count = $statusCounts[$tab] ?? 0;
            @endphp

            <button wire:click="$set('status','{{ $tab }}')"
                class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 whitespace-nowrap

            {{ $status === $tab
                ? 'bg-[#f84525] text-white shadow-md scale-105'
                : 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-sm' }}">
                {{-- Icon --}}
                <i class="{{ $icon }} text-base"></i>

                {{-- Text (Hidden on very small screens) --}}
                <span class="hidden sm:inline">
                    {{ ucfirst($tab) }}
                </span>

                {{-- Count Badge --}}
                <span
                    class="text-xs px-2 py-0.5 rounded-full font-bold
                {{ $status === $tab ? 'bg-white text-[#f84525]' : 'bg-gray-300 text-gray-800' }}">
                    {{ $count }}
                </span>

            </button>
        @endforeach

    </div>


    {{-- Filters --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 mt-3 gap-2">

        <input type="text" wire:model.live="search" placeholder="Search name or ID..."
            class="w-full sm:w-1/3 px-3 py-2 border rounded text-sm">

        <select wire:model.live="grade" class="w-full sm:w-1/4 px-3 py-2 border rounded text-sm">
            <option value="">All Grades</option>

            @foreach ($grades as $item)
                <option value="{{ $item }}">{{ $item }}</option>
            @endforeach

        </select>

        <select wire:model.live="intake" class="w-full sm:w-1/4 px-3 py-2 border rounded text-sm">
            <option value="">All Intakes</option>
            @foreach ($intakes as $item)
                <option value="{{ $item }}">{{ $item }}</option>
            @endforeach
        </select>

        <select wire:model.live="shift" class="w-full sm:w-1/4 px-3 py-2 border rounded text-sm">
            <option value="">All Shifts</option>
            @foreach ($shifts as $item)
                <option value="{{ $item }}">{{ $item }}</option>
            @endforeach
        </select>

    </div>

    <div class="text-xs text-red-600 mb-2">
        🔴 Searching for: {{ $search }} |
        Name: {{ $name }} |
        Intake: {{ $intake }} |
        Shift: {{ $shift }}

        <button wire:click="$set('search',''); $set('intake',''); $set('shift',''); $set('grade','');"
            class="bg-[#25D366] text-white px-3 py-2 hover:bg-[#1ebe5d] rounded text-xs">
            Clear Search
        </button>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto mt-4">
        <table class="w-full table-auto border-collapse border border-gray-200 text-base"
            style="font-family: Arial, sans-serif;">
            <thead class="bg-gray-100">
                <tr class="text-center">
                    <th class="px-3 py-2 border">ID</th>
                    <th class="px-3 py-2 border">Name</th>
                    <th class="px-3 py-2 border">Age</th>
                    <th class="px-3 py-2 border">Gender</th>
                    <th class="px-3 py-2 border">Class</th>
                    <th class="px-3 py-2 border">Status</th>
                    <th class="px-3 py-2 border">Actions</th>

                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr wire:key="student-{{ $student->id }}"
                        class="text-center border-b even:bg-[#e9f2ff] hover:bg-[#d0e2ff] transition duration-200">

                        <td class="px-2 py-1 border">{{ $student->student_id }}</td>
                        <td class="px-2 py-1 border">{{ $student->name }}</td>
                        <td class="px-2 py-1 border">{{ $student->age }}</td>
                        <td class="px-2 py-1 border">{{ $student->gender }}</td>
                        <td class="px-2 py-1 border">{{ $student->class_applying_for }}</td>
                        <td class="px-2 py-1 border capitalize">{{ $student->status }}</td>
                        <td class="px-2 py-1 border flex flex-wrap justify-center gap-1">

                            {{-- Dynamic Status Buttons --}}
                            @if ($canManage)
                                @if ($student->status === 'candidate')
                                    <button wire:click="confirmStatusChange({{ $student->id }}, 'admitted')"
                                        @click="$dispatch('open-admit')"
                                        class="px-2 py-1 bg-green-500 text-white rounded text-xs">
                                        Admit
                                    </button>
                                @elseif($student->status === 'admitted')
                                    <button wire:click="confirmStatusChange({{ $student->id }}, 'registered')"
                                        @click="$dispatch('open-register')"
                                        class="px-2 py-1 bg-blue-500 text-white rounded text-xs">
                                        Register
                                    </button>
                                @elseif($student->status === 'registered')
                                    <button wire:click="confirmStatusChange({{ $student->id }}, 'active')"
                                        class="px-2 py-1 bg-indigo-500 text-white rounded text-xs">
                                        Activate
                                    </button>
                                @elseif($student->status === 'active')
                                    <div class="flex gap-1">
                                        <button wire:click="confirmStatusChange({{ $student->id }}, 'completed')"
                                            class="px-2 py-1 bg-gray-700 text-white rounded text-xs hover:bg-gray-800">
                                            Complete
                                        </button>

                                        <button wire:click="confirmStatusChange({{ $student->id }}, 'dropout')"
                                            class="px-2 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600">
                                            Dropout
                                        </button>
                                    </div>
                                @endif
                            @endif

                            {{-- View / Edit / Delete Icons --}}
                            @if ($canView)
                                <button wire:click="viewStudent({{ $student->id }})"
                                    class="text-blue-500 hover:text-blue-700" title="View">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>
                            @endif

                            @if ($canEdit)
                                <button wire:click="editStudent({{ $student->id }})"
                                    class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                            @endif

                            @if ($canDelete)
                                <button wire:click="confirmDelete({{ $student->id }})"
                                    class="text-red-500 hover:text-red-700" title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            @endif
                            <!-- Checkbox moved slightly to the right -->
                            <div class="flex justify-end items-center">
                                <input type="checkbox" wire:model="selectedParents" value="{{ $student->id }}"
                                    class="form-checkbox ml-4 cursor-pointer" title="Message this parent">
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-gray-500 text-center">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $students->links() }}
    </div>



    {{-- Add New Student Modal --}}
    <div x-data="{ open: @entangle('showAddModal') }" x-show="open" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-3 overflow-y-auto">

        <!-- Modal Box -->
        <div x-show="open" x-transition
            class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-5 relative mt-10 sm:mt-0 flex flex-col max-h-[85vh] overflow-y-auto">
            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 bg-blue-900 text-white rounded-t-2xl">
                <div>
                    <h2 class="text-lg font-semibold">Register New Student</h2>
                </div>
                <button @click="open = false" class="p-2 rounded-full hover:bg-red-500 transition">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <!-- Spinner (Livewire loading) -->
            <div wire:loading.flex wire:target="storeStudent"
                class="absolute inset-0 bg-white/70 z-50 items-center justify-center">
                <div class="animate-spin rounded-full h-10 w-10 border-4 border-blue-500 border-t-transparent"></div>
            </div>

            <!-- Body -->
            <div class="p-4 space-y-6">
                <form wire:submit.prevent="storeStudent" class="space-y-4 max-h-[70vh] overflow-y-auto pr-2">

                    <!-- Name -->
                    <div>
                        <label class="text-sm font-medium">Full Name *</label>
                        <input type="text" wire:model.defer="name"
                            class="w-full px-3 py-2 border rounded text-sm">
                        @error('name')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Age & Gender -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm font-medium">Age *</label>
                            <input type="number" wire:model.defer="age"
                                class="w-full px-3 py-2 border rounded text-sm">
                            @error('age')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium">Gender *</label>
                            <select wire:model.defer="gender" class="w-full px-3 py-2 border rounded text-sm">
                                <option value="">Select</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                            @error('gender')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Parent Phone -->
                    <div>
                        <label class="text-sm font-medium">Parent Phone *</label>
                        <input type="text" wire:model.defer="parent_phone"
                            class="w-full px-3 py-2 border rounded text-sm">
                        @error('parent_phone')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Class -->
                    <div>
                        <label class="text-sm font-medium">Class Applying For *</label>

                        <select wire:model.defer="class_applying_for"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors mb-2">
                            <option value="">Select Class</option>
                            <optgroup label="kindergarten">
                                <option value="Nursery">Nursery</option>
                                <option value="K-3">K-3</option>
                                <option value="K-4">K-4</option>
                                <option value="K-5">K-5</option>
                            </optgroup>
                            <optgroup label="Primary">
                                <option value="Grade 1">Grade 1</option>
                                <option value="Grade 2">Grade 2</option>
                                <option value="Grade 3">Grade 3</option>
                                <option value="Grade 4">Grade 4</option>
                                <option value="Grade 5">Grade 5</option>
                                <option value="Grade 6">Grade 6</option>
                            </optgroup>
                            <optgroup label="Secondary">
                                <option value="Grade 7">Grade 7</option>
                                <option value="Grade 8">Grade 8</option>
                                <option value="Grade 9">Grade 9</option>
                                <option value="Grade 10">Grade 10</option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                            </optgroup>
                        </select>

                        <input type="text" placeholder="Or enter custom class"
                            wire:model.defer="class_applying_for_custom"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm mb-1">

                        @error('class_applying_for')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="text-sm font-medium">Date of Admission *</label>
                        <input type="date" wire:model.defer="date_of_admission"
                            class="w-full px-3 py-2 border rounded text-sm">
                        @error('date_of_admission')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Optional Uploads -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="text-sm font-medium">Photo (optional)</label>
                            <input type="file" wire:model="image" class="w-full text-sm">
                            @error('image')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium">Transcript (optional)</label>
                            <input type="file" wire:model="transcript" class="w-full text-sm">
                            @error('transcript')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium">Recommendation (optional)</label>
                            <input type="file" wire:model="recommendation_letter" class="w-full text-sm">
                            @error('recommendation_letter')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-2 pt-4">
                        <button type="button" @click="open = false"
                            class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">
                            Cancel
                        </button>

                        <button type="submit"
                            class="px-4 py-2 text-sm font-semibold bg-[#f84525] text-white rounded
                               hover:bg-red-600 flex items-center gap-2"
                            wire:loading.attr="disabled">
                            <x-loading-spinner wire:loading />
                            <span wire:loading.remove>Add Student</span>
                            <span wire:loading>Adding…</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>



    {{-- Edit Student Modal --}}
    <div x-data="{ open: @entangle('showEditModal') }" x-show="open" x-cloak
        class="fixed inset-0 z-60 flex items-center justify-center bg-black/60 backdrop-blur-sm px-3 overflow-y-auto">

        <!-- Modal Box -->
        <div x-show="open" x-transition
            class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-5 relative mt-10 sm:mt-0 flex flex-col max-h-[85vh] overflow-y-auto">
            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 bg-blue-900 text-white rounded-t-2xl">
                <div>
                    <h2 class="text-lg font-semibold">Edit Student</h2>
                </div>
                <button @click="open = false" class="p-2 rounded-full hover:bg-red-500 transition">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <!-- Spinner (Livewire loading) -->
            <div wire:loading.flex wire:target="updateStudent"
                class="absolute inset-0 bg-white/70 z-50 items-center justify-center">
                <div class="animate-spin rounded-full h-10 w-10 border-4 border-blue-500 border-t-transparent"></div>
            </div>

            <!-- Body -->
            <div class="p-4 space-y-6">
                <form wire:submit.prevent="updateStudent" class="space-y-4 max-h-[70vh] overflow-y-auto pr-2">
                    <!-- Personal Info -->
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <h3 class="font-semibold text-blue-800 mb-3">Personal Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="text-sm font-medium">Full Name *</label>
                                <input type="text" wire:model.defer="edit_name"
                                    class="w-full px-3 py-2 border rounded text-sm">
                                @error('edit_name')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium">Age *</label>
                                <input type="number" wire:model.defer="edit_age"
                                    class="w-full px-3 py-2 border rounded text-sm">
                                @error('edit_age')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium">Gender *</label>
                                <select wire:model.defer="edit_gender"
                                    class="w-full px-3 py-2 border rounded text-sm">
                                    <option value="">Select Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                                @error('edit_gender')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium">Parent Phone *</label>
                                <input type="text" wire:model.defer="edit_parent_phone"
                                    class="w-full px-3 py-2 border rounded text-sm">
                                @error('edit_parent_phone')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Academic Info -->
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <h3 class="font-semibold text-green-800 mb-3">Academic Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="text-sm font-medium">Class Applying For *</label>
                                <select wire:model.defer="edit_class_applying_for"
                                    class="w-full px-3 py-2 border rounded text-sm">
                                    <option value="">Select Class</option>
                                    <optgroup label="kindergarten">
                                        <option value="K-3">K-3</option>
                                        <option value="K-4">K-4</option>
                                        <option value="K-5">K-5</option>
                                    </optgroup>
                                    <optgroup label="Primary">
                                        <option>Grade 1</option>
                                        <option>Grade 2</option>
                                        <option>Grade 3</option>
                                        <option>Grade 4</option>
                                        <option>Grade 5</option>
                                        <option>Grade 6</option>
                                    </optgroup>
                                    <optgroup label="Secondary">
                                        <option>Grade 7</option>
                                        <option>Grade 8</option>
                                        <option>Grade 9</option>
                                        <option>Grade 10</option>
                                        <option>Grade 11</option>
                                        <option>Grade 12</option>
                                    </optgroup>
                                </select>
                                @error('edit_class_applying_for')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium">Date of Admission *</label>
                                <input type="date" wire:model.defer="edit_date_of_admission"
                                    class="w-full px-3 py-2 border rounded text-sm">
                                @error('edit_date_of_admission')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div>
                        <label class="text-sm font-medium">
                            Academic Year *
                        </label>

                        <select wire:model.defer="edit_intake" class="w-full px-3 py-2 border rounded text-sm">
                            <option value="">Select Academic Year</option>

                            @foreach (\App\Models\AcademicYear::active()->ordered()->get() as $year)
                                <option value="{{ $year->name }}">
                                    {{ $year->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('edit_intake')
                            <p class="text-red-500 text-xs">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Documents -->
                    <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                        <h3 class="font-semibold text-purple-800 mb-3">Documents</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="text-sm font-medium">Student Image</label>
                                <input type="file" wire:model="edit_image" class="w-full text-sm">
                                @error('edit_image')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium">Transcript</label>
                                <input type="file" wire:model="edit_transcript" class="w-full text-sm">
                                @error('edit_transcript')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium">Recommendation Letter</label>
                                <input type="file" wire:model="edit_recommendation_letter" class="w-full text-sm">
                                @error('edit_recommendation_letter')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-2 pt-4">
                        <button type="button" @click="open = false"
                            class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">Cancel</button>

                        <button type="submit"
                            class="px-4 py-2 text-sm font-semibold bg-[#f84525] text-white rounded hover:bg-red-600 flex items-center gap-2"
                            wire:loading.attr="disabled">
                            <x-loading-spinner wire:loading />
                            <span wire:loading.remove>Update Student</span>
                            <span wire:loading>Updating…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- ===============================
     View Student Modal
================================ -->
    <div x-data="{ open: @entangle('showViewModal') }" x-show="open" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-3">

        <!-- Modal Box -->
        <div
            class="bg-white w-full max-w-3xl rounded-xl shadow-2xl overflow-hidden
               flex flex-col max-h-[85vh]">

            <!-- Header -->
            <!-- Header (Updated to Navy Blue) -->
            <div class="flex items-center justify-between px-4 py-3 bg-[#001F54] text-white">


                <div>
                    <h2 class="text-lg font-semibold">Student Details</h2>
                    <p class="text-xs text-blue-100">Profile overview</p>

                    {{-- STATUS BADGE (ADDED) --}}
                    @if (!empty($view_status))
                        <span
                            class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-semibold
                        @if ($view_status === 'candidate') bg-yellow-100 text-yellow-800
                        @elseif($view_status === 'active') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-700 @endif">
                            {{ ucfirst($view_status) }}
                        </span>
                    @endif
                </div>

                <button wire:click="$set('showViewModal', false)"
                    class="p-2 rounded-full hover:bg-red-500 transition">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <!-- Spinner (Livewire loading) -->
            <div wire:loading.flex wire:target="viewStudent"
                class="absolute inset-0 bg-white/70 z-50 items-center justify-center">
                <div class="animate-spin rounded-full h-10 w-10 border-4 border-blue-500 border-t-transparent"></div>
            </div>

            <!-- Body (SCROLLABLE) -->
            <div class="p-4 overflow-y-auto space-y-6">

                <!-- Student Basic Info -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <!-- Image (UPDATED: Circular with bold border) -->
                    <div class="flex justify-center">
                        <div
                            class="w-32 h-32 rounded-full border-4 border-blue-700 bg-gray-100 flex items-center justify-center overflow-hidden">
                            @if (!empty($view_image))
                                <img src="{{ asset('storage/' . $view_image) }}" class="w-full h-full object-cover"
                                    alt="Student Photo">
                            @else
                                <span class="text-gray-400 text-sm">Photo</span>
                            @endif
                        </div>
                    </div>


                    <!-- Quick Info -->
                    <div class="space-y-2 text-sm">
                        <p><span class="font-semibold">Name:</span> {{ $view_name ?? '—' }}</p>
                        <p><span class="font-semibold">Age:</span> {{ $view_age ?? '—' }}</p>
                        <p><span class="font-semibold">Gender:</span> {{ $view_gender ?? '—' }}</p>
                        <p><span class="font-semibold">Class:</span> {{ $view_class ?? '—' }}</p>
                        <p><span class="font-semibold">Admission Date:</span> {{ $view_date ?? '—' }}</p>
                        <p><span class="font-semibold">Previous-School Attended:</span>
                            {{ $view_last_school_attended ?? '—' }}</p>
                        <p><span class="font-semibold">Student-Type:</span> {{ $view_student_type ?? '—' }}</p>
                    </div>
                </div>

                <hr class="border-gray-200">

                <!-- Detailed Info -->
                <div class="space-y-3 text-sm">
                    <h3 class="font-semibold text-gray-700">Parent & Contact</h3>
                    <p><span class="font-semibold">Parent Phone:</span> {{ $view_parent_phone ?? '—' }}</p>
                </div>

                <!-- Documents (UPDATED) -->
                <div class="space-y-3">
                    <h3 class="font-semibold text-gray-700">Documents</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">

                        {{-- Transcript --}}
                        <div class="p-3 border rounded-lg bg-gray-50">
                            <span class="font-semibold">Transcript:</span>
                            @if (!empty($view_transcript))
                                <a href="{{ asset('storage/' . $view_transcript) }}" target="_blank"
                                    class="block mt-1 text-blue-600 hover:underline">
                                    View document
                                </a>
                            @else
                                <span class="text-gray-400 block mt-1">Not uploaded</span>
                            @endif
                        </div>

                        {{-- Recommendation --}}
                        <div class="p-3 border rounded-lg bg-gray-50">
                            <span class="font-semibold">Recommendation:</span>
                            @if (!empty($view_recommendation_letter))
                                <a href="{{ asset('storage/' . $view_recommendation_letter) }}" target="_blank"
                                    class="block mt-1 text-blue-600 hover:underline">
                                    View document
                                </a>
                            @else
                                <span class="text-gray-400 block mt-1">Not uploaded</span>
                            @endif
                        </div>

                    </div>
                </div>

                <!-- ===============================
     Fees & Payments
================================ -->
                <div class="border rounded-lg bg-blue-50 overflow-hidden">

                    <!-- Header -->
                    <div class="px-4 py-3 border-b bg-[#001F54] text-white">
                        <h3 class="font-semibold">Fees & Payment Summary</h3>
                        <p class="text-xs text-blue-100">
                            Financial overview and payment history for this student.
                        </p>
                    </div>

                    <div class="p-4 space-y-5">

                        <!-- Summary Cards -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">

                            <div class="bg-white rounded-lg border p-3 shadow-sm">
                                <p class="text-xs text-gray-500 uppercase">Total Assigned</p>
                                <h4 class="text-lg font-bold text-gray-800 mt-1">
                                    ${{ number_format($feeSummary['assigned'], 2) }}
                                </h4>
                            </div>

                            <div class="bg-white rounded-lg border p-3 shadow-sm">
                                <p class="text-xs text-gray-500 uppercase">Total Paid</p>
                                <h4 class="text-lg font-bold text-green-600 mt-1">
                                    ${{ number_format($feeSummary['paid'], 2) }}
                                </h4>
                            </div>

                            <div class="bg-white rounded-lg border p-3 shadow-sm">
                                <p class="text-xs text-gray-500 uppercase">Outstanding Balance</p>
                                <h4 class="text-lg font-bold text-red-600 mt-1">
                                    ${{ number_format($feeSummary['balance'], 2) }}
                                </h4>
                            </div>

                            <div class="bg-white rounded-lg border p-3 shadow-sm">
                                <p class="text-xs text-gray-500 uppercase">Last Payment</p>

                                <h4 class="text-sm font-semibold text-gray-800 mt-1">
                                    {{ $feeSummary['last_payment']
                                        ? \Carbon\Carbon::parse($feeSummary['last_payment'])->format('d M, Y')
                                        : 'No Payment' }}
                                </h4>
                            </div>

                        </div>

                        <!-- Payment History -->
                        <div class="bg-white rounded-lg border overflow-hidden">

                            <div class="px-4 py-3 border-b bg-gray-50 flex items-center justify-between">
                                <h4 class="font-semibold text-gray-700">
                                    Payment History
                                </h4>

                                <span class="text-xs text-gray-500">
                                    {{ count($viewPaymentHistory) }}
                                    {{ count($viewPaymentHistory) == 1 ? 'Payment' : 'Payments' }}
                                </span>
                            </div>

                            @if (count($viewPaymentHistory))

                                <div class="overflow-x-auto">

                                    <table class="min-w-full text-sm">

                                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">

                                            <tr>
                                                <th class="px-4 py-3 text-left">Fee</th>
                                                <th class="px-4 py-3 text-left">Date</th>
                                                <th class="px-4 py-3 text-left">Receipt #</th>
                                                <th class="px-4 py-3 text-right">Amount</th>
                                                <th class="px-4 py-3 text-left">Method</th>
                                                <th class="px-4 py-3 text-left">Recorded By</th>
                                                <th class="px-4 py-3 text-center">Actions</th>
                                            </tr>

                                        </thead>

                                        <tbody class="divide-y divide-gray-100">

                                            @foreach ($viewPaymentHistory as $payment)
                                                <tr class="hover:bg-gray-50">

                                                    <!-- NEW Fee Column -->

                                                    <td class="px-4 py-3">

                                                        <div class="space-y-1">

                                                            <div class="font-semibold text-gray-800">
                                                                {{ $payment->assignment->feeCategory->name }}
                                                            </div>

                                                            <div
                                                                class="flex items-center gap-2 text-xs text-gray-500 whitespace-nowrap overflow-x-auto">

                                                                <span>
                                                                    {{ $payment->assignment->academic_year }}
                                                                </span>

                                                                @if ($payment->assignment->installment_number)
                                                                    <span
                                                                        class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 whitespace-nowrap flex-shrink-0">

                                                                        {{ $payment->assignment->installment_number }}

                                                                    </span>
                                                                @endif

                                                            </div>

                                                        </div>

                                                    </td>

                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        {{ $payment->payment_date->format('d M Y') }}
                                                    </td>

                                                    <td class="px-4 py-3 font-mono text-xs">
                                                        {{ $payment->receipt_number }}
                                                    </td>

                                                    <td class="px-4 py-3 text-right font-semibold text-green-700">
                                                        ${{ number_format($payment->amount_paid, 2) }}
                                                    </td>

                                                    <td class="px-4 py-3">
                                                        {{ $payment->payment_method }}
                                                    </td>

                                                    <td class="px-4 py-3">
                                                        {{ $payment->recordedBy?->name ?? 'System' }}
                                                    </td>

                                                    <td class="px-4 py-3">

                                                        <div class="flex justify-center gap-2">

                                                            <a href="{{ route('admin.fees.receipts.show', $payment) }}"
                                                                target="_blank"
                                                                class="h-8 w-8 rounded-md bg-blue-100 text-[#001F54] hover:bg-[#001F54] hover:text-white flex items-center justify-center"
                                                                title="Print Receipt">

                                                                <i class="fas fa-print text-xs"></i>

                                                            </a>

                                                            <a href="{{ route('admin.fees.receipts.download', $payment) }}"
                                                                class="h-8 w-8 rounded-md bg-red-100 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center"
                                                                title="Download Receipt">

                                                                <i class="fas fa-file-pdf text-xs"></i>

                                                            </a>

                                                        </div>

                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>
                            @else
                                <div class="p-8 text-center">

                                    <div class="text-4xl text-gray-300 mb-2">
                                        <i class="fas fa-receipt"></i>
                                    </div>

                                    <h4 class="font-semibold text-gray-600">
                                        No Payments Recorded
                                    </h4>

                                    <p class="text-sm text-gray-500 mt-1">
                                        This student has no payment history available yet.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>



            </div>

            <!-- Footer -->
            <div class="px-4 py-3 bg-gray-50 flex justify-end gap-2">
                <button wire:click="$set('showViewModal', false)"
                    class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-100">
                    Close
                </button>

                <button @click="$wire.editStudent({{ $view_student_id }}); $wire.set('showViewModal', false)"
                    class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                    Edit
                </button>


            </div>

        </div>
    </div>


    {{-- Delete Student Modal --}}
    <div x-data="{ open: @entangle('showDeleteModal') }" x-show="open" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center
           bg-black/60 backdrop-blur-sm px-2">
        <!-- Modal Box -->
        <div x-show="open" x-transition class="bg-white w-full max-w-xs rounded-lg shadow-xl overflow-hidden">

            <!-- Header -->
            <div class="flex items-center justify-between px-3 py-2 bg-red-600 text-white">
                <h3 class="text-xs font-semibold">Confirm Delete</h3>

                <button wire:click="$set('showDeleteModal', false)"
                    class="p-1 rounded-full hover:bg-red-500 transition">
                    <i class="ri-close-line text-sm"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="p-3 space-y-2 text-xs">
                <p class="text-gray-700">
                    Are you sure you want to delete this student?
                </p>

                <!-- Student Name -->
                <div class="p-2 rounded-md bg-gray-50 border text-gray-800 font-medium text-xs">
                    {{ $deleteStudentName ?? 'Selected student' }}
                </div>

                <p class="text-red-600 flex items-center gap-1 text-[11px]">
                    <i class="ri-alert-line"></i>
                    This action cannot be undone.
                </p>
            </div>

            <!-- Footer -->
            <div class="px-3 py-2 bg-gray-50 border-t flex justify-end gap-1">
                <button wire:click="$set('showDeleteModal', false)"
                    class="px-2 py-1 text-xs rounded border hover:bg-gray-100">
                    Cancel
                </button>

                <button type="button" wire:click="deleteStudent" wire:loading.attr="disabled"
                    class="px-2 py-1 text-xs font-semibold bg-red-600 text-white rounded
                       hover:bg-red-700 flex items-center gap-1">
                    <!-- Spinner -->
                    <x-loading-spinner wire:loading />

                    <!-- Normal text -->
                    <span wire:loading.remove>Delete</span>

                    <!-- Loading text -->
                    <span wire:loading>Deleting…</span>
                </button>
            </div>

        </div>
    </div>


    <!-- Admit Confirmation Modal -->
    <div x-data x-show="$wire.confirmingStatusId !== null" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center
           bg-black/60 backdrop-blur-sm px-2">
        <div class="bg-white w-full max-w-xs rounded-lg shadow-xl p-3">
            <!-- Header -->
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-sm font-semibold text-gray-700">
                    Confirm Admit
                </h2>

                <button wire:click="$set('confirmingStatusId', null)"
                    class="text-gray-400 text-xs hover:text-gray-700">
                    ✕
                </button>
            </div>

            <!-- Body -->
            <p class="text-gray-700 mb-3 text-xs leading-snug">
                Are you sure you want to admit this student?
                <br>
                <span class="text-red-600 text-[11px]">
                    This action may affect records and cannot always be undone.
                </span>
            </p>

            <!-- Footer -->
            <div class="flex justify-end gap-1">
                <button wire:click="$set('confirmingStatusId', null)" class="px-2 py-1 border rounded text-xs">
                    Cancel
                </button>

                <button wire:click="applyConfirmedStatus" wire:loading.attr="disabled"
                    class="px-2 py-1 bg-green-600 text-white rounded
                       text-xs flex items-center gap-1">
                    <span wire:loading
                        class="animate-spin h-3 w-3 border-2
                           border-white border-t-transparent rounded-full"></span>

                    <span wire:loading.remove>Confirm</span>
                    <span wire:loading>Processing…</span>
                </button>
            </div>
        </div>
    </div>




    <!-- Register Confirmation Modal -->
    <div x-data="{ open: false }" x-on:open-register.window="open = true" x-on:close-register.window="open = false"
        x-show="open" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-2">
        <div class="bg-white w-full max-w-xs rounded-lg shadow-xl p-3">
            <!-- Header -->
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-sm font-semibold text-gray-700">
                    Confirm Registration
                </h2>
                <button @click="open = false; $wire.confirmingStatusId = null" class="text-gray-400 text-xs">
                    ✕
                </button>
            </div>

            <!-- Body -->
            <p class="text-xs text-gray-600 mb-2 leading-snug">
                Select <strong>Shift</strong> and <strong>Intake</strong>.
            </p>

            <!-- Shift -->
            <div class="mb-2">
                <select wire:model="selectedShift" class="w-full border rounded px-2 py-1 text-xs focus:outline-none">
                    <option value="">Shift</option>
                    <option value="Morning">Morning</option>
                    <option value="Evening">Evening</option>
                </select>
            </div>

            <!-- Intake -->
            <!-- Academic Year -->
            <div class="mb-3">
                <select wire:model="selectedIntake"
                    class="w-full border rounded px-2 py-1 text-xs focus:outline-none">
                    <option value="">Academic Year</option>

                    @foreach (\App\Models\AcademicYear::active()->ordered()->get() as $year)
                        <option value="{{ $year->name }}">
                            {{ $year->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-1">
                <button @click="open = false; $wire.confirmingStatusId = null"
                    class="px-2 py-1 border rounded text-xs">
                    Cancel
                </button>

                <button wire:click="applyConfirmedStatus" wire:loading.attr="disabled"
                    class="px-2 py-1 bg-blue-600 text-white rounded text-xs flex items-center gap-1">
                    <span wire:loading
                        class="animate-spin h-3 w-3 border-2 border-white border-t-transparent rounded-full"></span>
                    <span wire:loading.remove>Confirm</span>
                    <span wire:loading>Processing…</span>
                </button>
            </div>
        </div>
    </div>


    {{-- Activate Confirmation Modal --}}
    <div x-data x-show="$wire.confirmingStatusId !== null && $wire.pendingStatus === 'active'" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center
           bg-black/60 backdrop-blur-sm px-1">
        <div class="bg-white w-full max-w-[20rem] rounded-lg shadow-lg p-3">
            <!-- Header -->
            <div class="flex items-center justify-between mb-1">
                <h2 class="text-[12px] font-semibold text-gray-700">
                    Confirm Activation
                </h2>

                <button wire:click="$set('confirmingStatusId', null)"
                    class="text-gray-400 hover:text-gray-700 text-xs">
                    ✕
                </button>
            </div>

            <!-- Body -->
            <p class="text-gray-700 text-[11px] mb-2">
                Are you sure you want to activate this student?
                <br>
                <span class="text-red-600 text-[10px]">
                    This action may affect records and cannot always be undone.
                </span>
            </p>

            <!-- Footer -->
            <div class="flex justify-end gap-1">
                <button wire:click="$set('confirmingStatusId', null)"
                    class="px-2 py-1 text-[10px] border rounded hover:bg-gray-100">
                    Cancel
                </button>

                <button wire:click="applyConfirmedStatus" wire:loading.attr="disabled"
                    class="px-2 py-1 text-[10px] bg-indigo-600 text-white rounded
                       flex items-center gap-1">
                    <span wire:loading
                        class="animate-spin h-3 w-3 border-2 border-white border-t-transparent rounded-full"></span>

                    <span wire:loading.remove>Confirm</span>
                    <span wire:loading>Processing…</span>
                </button>
            </div>
        </div>
    </div>


    {{-- Dropout Confirmation Modal --}}
    <div x-data x-show="$wire.confirmingStatusId !== null && $wire.pendingStatus === 'dropout'" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center
           bg-black/60 backdrop-blur-sm px-1">
        <div class="bg-white w-full max-w-[20rem] rounded-lg shadow-lg p-3">
            <!-- Header -->
            <div class="flex items-center justify-between mb-1">
                <h2 class="text-[12px] font-semibold text-gray-700">
                    Confirm Dropout
                </h2>

                <button wire:click="$set('confirmingStatusId', null)"
                    class="text-gray-400 hover:text-gray-700 text-xs">
                    ✕
                </button>
            </div>

            <!-- Body -->
            <p class="text-gray-700 text-[11px] mb-2">
                Are you sure you want to mark this student as Dropout?
                <br>
                <span class="text-red-600 text-[10px]">
                    This action may affect records and cannot always be undone.
                </span>
            </p>

            <!-- Footer -->
            <div class="flex justify-end gap-1">
                <button wire:click="$set('confirmingStatusId', null)"
                    class="px-2 py-1 text-[10px] border rounded hover:bg-gray-100">
                    Cancel
                </button>

                <button wire:click="applyConfirmedStatus" wire:loading.attr="disabled"
                    class="px-2 py-1 text-[10px] bg-red-600 text-white rounded
                       flex items-center gap-1">
                    <span wire:loading
                        class="animate-spin h-3 w-3 border-2 border-white border-t-transparent rounded-full"></span>

                    <span wire:loading.remove>Confirm</span>
                    <span wire:loading>Processing…</span>
                </button>
            </div>
        </div>
    </div>


    {{-- Complete Confirmation Modal --}}
    <div x-data x-show="$wire.confirmingStatusId !== null && $wire.pendingStatus === 'completed'" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center
           bg-black/60 backdrop-blur-sm px-1">
        <div class="bg-white w-full max-w-[20rem] rounded-lg shadow-lg p-3">
            <!-- Header -->
            <div class="flex items-center justify-between mb-1">
                <h2 class="text-[12px] font-semibold text-gray-700">
                    Confirm Completion
                </h2>

                <button wire:click="$set('confirmingStatusId', null)"
                    class="text-gray-400 hover:text-gray-700 text-xs">
                    ✕
                </button>
            </div>

            <!-- Body -->
            <p class="text-gray-700 text-[11px] mb-2">
                Are you sure you want to mark this student as Complete?
                <br>
                <span class="text-red-600 text-[10px]">
                    This action may affect records and cannot always be undone.
                </span>
            </p>

            <!-- Footer -->
            <div class="flex justify-end gap-1">
                <button wire:click="$set('confirmingStatusId', null)"
                    class="px-2 py-1 text-[10px] border rounded hover:bg-gray-100">
                    Cancel
                </button>

                <button wire:click="applyConfirmedStatus" wire:loading.attr="disabled"
                    class="px-2 py-1 text-[10px] bg-gray-700 text-white rounded
                       flex items-center gap-1">
                    <span wire:loading
                        class="animate-spin h-3 w-3 border-2 border-white border-t-transparent rounded-full"></span>

                    <span wire:loading.remove>Confirm</span>
                    <span wire:loading>Processing…</span>
                </button>
            </div>
        </div>
    </div>

    <!-- WhatApp Sending model body -->
    @if ($showSmsModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center px-2">
            <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-sm">

                <h2 class="text-sm font-semibold mb-2 text-center">
                    Send WhatsApp Message
                </h2>

                <textarea wire:model="message" class="w-full border p-2 rounded text-sm" rows="3"
                    placeholder="Type your message..."></textarea>

                <div class="flex justify-end gap-2 mt-3">

                    <!-- Cancel -->
                    <button wire:click="$set('showSmsModal', false)"
                        class="px-3 py-1 bg-gray-400 text-white rounded text-xs">
                        Cancel
                    </button>

                    <!-- Send with Spinner -->
                    <button wire:click="sendWhatsapp" wire:loading.attr="disabled"
                        class="px-3 py-1 bg-green-600 text-white rounded
                       text-xs flex items-center gap-1">
                        <span wire:loading
                            class="animate-spin h-3 w-3 border-2
                           border-white border-t-transparent rounded-full"></span>

                        <span wire:loading.remove>Send</span>
                        <span wire:loading>Sending…</span>
                    </button>

                </div>

            </div>
        </div>
    @endif
    <script>
        window.addEventListener('open-whatsapp', event => {
            const numbers = event.detail.numbers;
            const message = event.detail.message;

            numbers.forEach(phone => {
                const clean = phone.replace(/\D/g, '');
                const url = `https://wa.me/${clean}?text=${message}`;
                window.open(url, '_blank');
            });
        });

        window.addEventListener('alert', event => {
            alert(event.detail.message);
        });
    </script>
</div>

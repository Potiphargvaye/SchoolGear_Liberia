
@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Banner Header -->
    <h1 class="text-xl sm:text-2xl font-bold text-center text-[#0a1f44] mb-4">
    Grade Assignments Management
</h1>

        <div class="admin-container">
    <!-- Assign Teacher Card -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 max-w-4xl mx-auto p-4 mb-6">
        
        <h2 class="text-sm font-semibold text-[#0a1f44] mb-3 flex items-center gap-2">
            <i class="fas fa-chalkboard-teacher text-[#0a1f44]"></i>
            Assign Teacher to Grade
        </h2>

        <form action="{{ route('admin.assign-teacher') }}" method="POST" id="assignTeacherForm">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-4">

                <!-- Teacher -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Teacher</label>
                    <select name="teacher_id"
                        class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded-md
                               focus:ring-2 focus:ring-[#0a1f44] focus:border-[#0a1f44]"
                        required>
                        <option value="">Select Teacher</option>
                        @foreach($allTeachers as $teacher)
                            <option value="{{ $teacher->id }}">
                                {{ $teacher->name }} ({{ $teacher->registration_id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Grade -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Grade</label>
                    <select name="grade_id"
                        class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded-md
                               focus:ring-2 focus:ring-[#0a1f44] focus:border-[#0a1f44]"
                        required>
                        <option value="">Select Grade</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}">
                                {{ $grade->level }} {{ $grade->section }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Subject -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Subject</label>
                    <select name="subjects[]"
                        class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded-md
                               focus:ring-2 focus:ring-[#0a1f44] focus:border-[#0a1f44]"
                        required>
                        <option value="">Select Subject</option>
                        @foreach($allSubjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <!-- Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-[#0a1f44] text-white px-4 py-1.5 text-xs rounded-md
                           hover:opacity-90 transition flex items-center gap-1.5">
                    <i class="fas fa-user-plus text-xs"></i>
                    Assign
                </button>
            </div>

        </form>
    </div>
</div>

        <!-- Assign Student Card -->
<div class="bg-white rounded-md shadow-sm border border-gray-200 max-w-4xl mx-auto p-4 mb-6">

    <h2 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
        <i class="fas fa-user-graduate text-green-600"></i>
        Assign Student to Grade
    </h2>

    <form action="{{ route('admin.assign-student') }}" method="POST" id="assignStudentForm">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-4">

            <!-- Student -->
            <div>
    <label class="block text-xs font-medium text-gray-600 mb-1">Student</label>
    <select name="student_id"
        class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded-md
               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        required>
        <option value="">Select Student</option>
        @foreach($unassignedStudents as $student)
            <option value="{{ $student->id }}">
                {{ $student->name }} ({{ $student->student_id }})
            </option>
        @endforeach
    </select>
</div>


            <!-- Grade -->
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Grade</label>
                <select name="grade_id"
                    class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded-md
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                    <option value="">Select Grade</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}">
                            {{ $grade->level }} {{ $grade->section }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Subjects -->
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Subjects</label>
                 <select name="subjects[]"
                        class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded-md
                               focus:ring-2 focus:ring-[#0a1f44] focus:border-[#0a1f44]"
                        required>
                        <option value="">Select Subject</option>
                        @foreach($allSubjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                <p class="text-[10px] text-gray-500 mt-1">
                    Hold Ctrl / Cmd to select multiple subjects
                </p>
            </div>

        </div>

        <!-- Button (UNCHANGED COLOR) -->
        <div class="flex justify-end">
            <button type="submit"
                class="bg-green-600 text-white px-4 py-1.5 text-xs rounded-md
                       hover:bg-green-700 transition flex items-center gap-1.5 shadow-sm">
                <i class="fas fa-user-plus text-xs"></i>
                Assign Student
            </button>
        </div>

    </form>
</div>


       <!-- Current Assignments Table -->
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-3 border-b border-gray-200">
        <h2 class="text-base font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-list-alt text-blue-600"></i>
            Current Grade Assignments
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Grade</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Teachers</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Students</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($grades as $grade)
                <tr class="hover:bg-gray-50">
                    <!-- Grade -->
                    <td class="px-3 py-3 align-top">
                        <div class="font-semibold text-gray-900">
                         {{ $grade->level }}{{ $grade->section }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $grade->students->count() }} students • {{ $grade->teachers->count() }} teachers
                        </div>
                    </td>

                    <!-- Teachers -->
                    <td class="px-3 py-3 align-top">
                        @if($grade->teachers->count())
                        <div class="space-y-2">
                            @foreach($grade->teachers as $teacher)
                           <div class="flex items-center justify-between bg-blue-50 border border-blue-200 rounded-md px-2 py-1.5">
    <div class="flex items-center gap-1">
        <i class="fas fa-chalkboard-teacher text-blue-600 text-sm flex-shrink-0"></i>
        <div class="leading-tight">
            <div class="text-sm font-medium text-gray-900">{{ $teacher->name }}</div>
            <div class="text-[11px] text-gray-500">{{ $teacher->registration_id }}</div>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.unassign-teacher', ['assignment' => $teacher->pivot->id]) }}">
        @csrf
        @method('DELETE')
        <button type="button"
            onclick="confirmUnassignTeacher(this)"
            class="p-1 bg-red-50 text-red-600 hover:bg-red-100 rounded">
            <i class="fas fa-user-minus text-[10px]"></i>
        </button>
    </form>
</div>

                            @endforeach
                        </div>
                        @else
                        <p class="text-xs text-gray-400 text-center">No teachers</p>
                        @endif
                    </td>

                    <!-- Students -->
                    <td class="px-3 py-3 align-top">
                        @if($grade->students->count())
                        <div class="space-y-1">
                            @foreach($grade->students as $student)
                            <div class="flex items-center justify-between bg-green-50 border border-green-200 rounded-md px-2 py-1.5">
    <div class="flex items-center gap-1">
        <i class="fas fa-user-graduate text-green-600 text-sm flex-shrink-0"></i>
        <div class="leading-tight">
            <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
            <div class="text-[11px] text-gray-500">{{ $student->registration_id }}</div>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.unassign-student', $student) }}">
        @csrf
        <button type="button"
            onclick="confirmUnassignStudent(this)"
            class="p-1 bg-red-50 text-red-600 hover:bg-red-100 rounded">
            <i class="fas fa-user-minus text-[10px]"></i>
        </button>
    </form>
</div>

                            @endforeach
                        </div>
                        @else
                        <p class="text-xs text-gray-400 text-center">No students</p>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td class="px-3 py-3 align-top">
                        <button type="button"
                            onclick="openManageSubjectsModal()"
                            class="bg-green-600 text-white px-3 py-1.5 rounded-md hover:bg-green-700 flex items-center gap-1 text-xs">
                            <i class="fas fa-plus"></i>
                            Manage
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                        <i class="fas fa-inbox text-3xl mb-2"></i>
                        <p class="font-medium">No grade assignments yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

<!-- Manage Subjects Modal -->
<div id="manageSubjectsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="fixed inset-0 flex items-center justify-center p-1">
        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full max-h-[80vh] overflow-hidden">
            
            <!-- Header -->
            <div class="bg-indigo-600 text-white px-3 py-2 rounded-t-lg flex justify-between items-center">
                <h3 class="text-base font-semibold">Manage Subjects</h3>
                <button onclick="closeManageSubjectsModal()" class="text-white hover:bg-red-500 hover:scale-110 transition-all duration-200 p-1 rounded-full bg-red-400">&times;</button>
            </div>
            
            <!-- Add New Subject Form -->
            <div class="px-3 py-3 border-b border-gray-200 text-sm">
                <form id="addSubjectForm" class="space-y-2">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <input type="text" name="name" id="newSubjectName" placeholder="Subject Name *"
                               class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" required>
                        <input type="text" name="code" id="newSubjectCode" placeholder="Subject Code"
                               class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <textarea name="description" id="newSubjectDescription" placeholder="Description"
                              class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" rows="2"></textarea>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 transition-all duration-200 text-sm flex items-center gap-1">
                        <i class="fas fa-plus text-xs"></i> Add
                    </button>
                </form>
            </div>

            <!-- Subjects List -->
            <div class="px-3 py-2 max-h-72 overflow-y-auto text-sm space-y-1">
                <div id="subjectsList">
                    <!-- Subjects will be dynamically loaded here -->
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-3 py-2 rounded-b-lg flex justify-end">
                <button type="button" onclick="closeManageSubjectsModal()" 
                        class="bg-gray-600 text-white px-3 py-1 rounded-md hover:bg-gray-700 text-sm">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>



<<!-- Edit Subject Modal -->
<div id="editSubjectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="fixed inset-0 flex items-center justify-center p-1">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            
            <!-- Header -->
            <div class="bg-indigo-600 text-white px-3 py-2 rounded-t-lg flex justify-between items-center">
                <h3 class="text-base font-semibold">Edit Subject</h3>
                <button onclick="closeModal('editSubjectModal')" 
                        class="text-white hover:bg-red-500 hover:scale-110 transition-all duration-200 p-1 rounded-full bg-red-400">&times;</button>
            </div>
            
            <!-- Form -->
            <form id="editSubjectForm" class="px-3 py-3 space-y-2 text-sm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editSubjectId" name="id">

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Subject Name *</label>
                    <input type="text" name="name" id="editSubjectName" 
                           class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" 
                           required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Subject Code</label>
                    <input type="text" name="code" id="editSubjectCode" 
                           class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="editSubjectDescription" 
                              class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" 
                              rows="2"></textarea>
                </div>

                <button type="submit" 
                        class="w-full bg-indigo-600 text-white px-3 py-1 rounded-md hover:bg-indigo-700 transition-all duration-200 flex items-center justify-center gap-1 text-sm">
                    <i class="fas fa-save text-xs"></i> Update
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Unassign Confirmation Modal -->
<div id="unassignConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden transition-opacity duration-300">
    <div class="fixed inset-0 flex items-center justify-center p-2">
        <div class="bg-white rounded-lg shadow-xl max-w-sm w-full transform transition-all duration-300 scale-95 opacity-0" id="unassignConfirmModalContent">
            
            <!-- Header -->
            <div class="bg-[#0a1f44] text-white p-3 rounded-t-lg flex justify-between items-center">
                <h3 class="text-lg font-semibold">Confirm Unassignment</h3>
                <button onclick="closeUnassignModal()" class="text-white hover:bg-red-500 hover:scale-110 transition-all duration-200 p-2 rounded-full">&times;</button>
            </div>

            <!-- Body -->
            <div class="p-4 text-sm">
                <p class="text-gray-700 mb-2" id="unassignMessage">
                    Are you sure you want to remove this teacher from this grade?
                </p>
                <p class="text-red-600 flex items-center gap-2 text-xs">
                    <i class="fas fa-exclamation-triangle"></i>
                    This action cannot be undone.
                </p>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 p-3 rounded-b-lg flex justify-end">
                <form id="unassignForm" method="POST">
                    <button type="submit" class="bg-red-600 text-white px-4 py-1.5 rounded-md hover:bg-red-700 transition-all duration-200 text-sm flex items-center gap-1">
                        <i class="fas fa-user-minus text-xs"></i>
                        Confirm Unassign
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>


<script>
// ========== NOTIFICATION SYSTEM ==========
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');

    const styles = {
        success: 'bg-gradient-to-r from-green-500 to-green-600 border-l-2 border-green-700',
        error: 'bg-gradient-to-r from-red-500 to-red-600 border-l-2 border-red-700',
        warning: 'bg-gradient-to-r from-yellow-500 to-yellow-600 border-l-2 border-yellow-700',
        info: 'bg-gradient-to-r from-blue-500 to-blue-600 border-l-2 border-blue-700'
    };

    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-triangle',
        warning: 'fa-exclamation-circle',
        info: 'fa-info-circle'
    };

    // Compact notification
    notification.className = `
        fixed top-4 right-4 z-50 transform translate-x-full opacity-0 transition-all duration-500 ease-in-out 
        ${styles[type]} text-white px-3 py-2 rounded-lg shadow-lg max-w-xs min-w-[200px] backdrop-blur-sm flex items-center gap-2
    `;

    notification.innerHTML = `
        <i class="fas ${icons[type]} text-sm flex-shrink-0"></i>
        <span class="flex-1 text-xs font-medium truncate">${message}</span>
        <button onclick="this.parentElement.remove()" 
                class="flex-shrink-0 p-1 rounded hover:bg-white hover:bg-opacity-20 transition-colors duration-200">
            <i class="fas fa-times text-xs"></i>
        </button>
    `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full', 'opacity-0');
        notification.classList.add('translate-x-0', 'opacity-100');
    }, 10);

    // Auto remove after 5s
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

// ========== MODAL FUNCTIONS ==========
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    const modalContent = document.getElementById(modalId + 'Content');
    
    // Add null checks to prevent errors
    if (!modal) {
        console.error('Modal not found:', modalId);
        return;
    }
    
    modal.classList.remove('hidden');
    
    if (modalContent) {
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    const modalContent = document.getElementById(modalId + 'Content');
    
    // Add null checks to prevent errors
    if (!modal) {
        console.error('Modal not found:', modalId);
        return;
    }
    
    if (modalContent) {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
    }
    
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
}

// ========== UNASSIGN CONFIRMATION MODAL ==========
function confirmUnassignTeacher(button) {
    try {
        const form = button.closest('form');
        if (!form) return;

        let teacherName = 'this teacher';
        const teacherCard = button.closest('.bg-blue-50');
        if (teacherCard) {
            const nameElement = teacherCard.querySelector('.font-medium');
            if (nameElement && nameElement.textContent) {
                teacherName = nameElement.textContent.trim();
            }
        }

        document.getElementById('unassignMessage').textContent = `Are you sure you want to remove ${teacherName} from this grade?`;
        document.getElementById('unassignForm').action = form.action;

        const formContent = `
            <input type="hidden" name="_token" value="${form.querySelector('input[name="_token"]').value}">
            ${form.querySelector('input[name="_method"]') ? '<input type="hidden" name="_method" value="DELETE">' : ''}
            <button type="submit" class="bg-red-600 text-white px-4 py-1.5 rounded-md hover:bg-red-700 transition-all duration-200 text-sm flex items-center gap-1">
                <i class="fas fa-user-minus text-xs"></i>
                Confirm Unassign
            </button>
        `;

        document.getElementById('unassignForm').innerHTML = formContent;
        openModal('unassignConfirmModal');

    } catch (error) {
        showErrorMessage('Failed to open confirmation dialog');
    }
}

function confirmUnassignStudent(button) {
    try {
        const form = button.closest('form');
        if (!form) return;

        let studentName = 'this student';
        const studentCard = button.closest('.bg-green-50');
        if (studentCard) {
            const nameElement = studentCard.querySelector('.font-medium');
            if (nameElement && nameElement.textContent) {
                studentName = nameElement.textContent.trim();
            }
        }

        document.getElementById('unassignMessage').textContent = `Are you sure you want to unassign ${studentName} from this grade?`;
        document.getElementById('unassignForm').action = form.action;

        const formContent = `
            <input type="hidden" name="_token" value="${form.querySelector('input[name="_token"]').value}">
            ${form.querySelector('input[name="_method"]') ? '<input type="hidden" name="_method" value="DELETE">' : ''}
            <button type="submit" class="bg-red-600 text-white px-4 py-1.5 rounded-md hover:bg-red-700 transition-all duration-200 text-sm flex items-center gap-1">
                <i class="fas fa-user-minus text-xs"></i>
                Confirm Unassign
            </button>
        `;

        document.getElementById('unassignForm').innerHTML = formContent;
        openModal('unassignConfirmModal');

    } catch (error) {
        showErrorMessage('Failed to open confirmation dialog');
    }
}

function closeUnassignModal() {
    closeModal('unassignConfirmModal');
}


// ========== FORM SUBMISSIONS ==========
document.addEventListener('DOMContentLoaded', function() {
    
    // Assign Teacher Form
    const assignTeacherForm = document.getElementById('assignTeacherForm');
    if (assignTeacherForm) {
        assignTeacherForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Assigning...';
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
                if (response.redirected) {
                    return { success: true };
                }
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        return { success: true };
                    }
                });
            })
            .then(data => {
                if (data.success) {
                    showSuccessMessage('Teacher assigned successfully!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Failed to assign teacher');
                }
            })
            .catch(error => {
                showErrorMessage('Failed to assign teacher: ' + error.message);
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        });
    }

    // Assign Student Form
    const assignStudentForm = document.getElementById('assignStudentForm');
    if (assignStudentForm) {
        assignStudentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Assigning...';
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
                if (response.redirected) {
                    return { success: true };
                }
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        return { success: true };
                    }
                });
            })
            .then(data => {
                if (data.success) {
                    showSuccessMessage('Student assigned successfully!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Failed to assign student');
                }
            })
            .catch(error => {
                showErrorMessage('Failed to assign student: ' + error.message);
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        });
    }
    
    // Unassign Form Event Listener
    const unassignForm = document.getElementById('unassignForm');
    
    if (unassignForm) {
        unassignForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = this.querySelector('button[type="submit"]');
            
            if (!submitButton) {
                return;
            }
            
            const originalText = submitButton.innerHTML;
            
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
            submitButton.disabled = true;

            const formData = new FormData(this);
            
            const method = formData.get('_method') || 'POST';
            const actualMethod = method === 'DELETE' ? 'DELETE' : 'POST';
            
            const finalFormData = new FormData();
            finalFormData.append('_token', formData.get('_token'));

            fetch(this.action, {
                method: actualMethod,
                body: finalFormData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => {
                if (response.redirected) {
                    return { success: true };
                }
                
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        return { success: true };
                    }
                });
            })
            .then(data => {
                if (data.success) {
                    closeModal('unassignConfirmModal');
                    showSuccessMessage('Unassigned successfully!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Failed to unassign');
                }
            })
            .catch(error => {
                showErrorMessage('Failed to unassign: ' + error.message);
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        });
    }
});


// Modal functions
function openManageSubjectsModal() {
    openModal('manageSubjectsModal');
    loadSubjects();
}

function closeManageSubjectsModal() {
    closeModal('manageSubjectsModal');
}

// Load subjects from database
function loadSubjects() {
    fetch('/subjects')
        .then(response => response.json())
        .then(subjects => {
            const subjectsList = document.getElementById('subjectsList');
            subjectsList.innerHTML = subjects.map(subject => `
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded border border-gray-200 text-sm">
                    <div class="flex flex-col gap-0.5">
                        <span class="font-semibold text-gray-800">${subject.name}</span>
                        ${subject.code ? `<span class="text-xs text-gray-600">Code: ${subject.code}</span>` : ''}
                        ${subject.description ? `<span class="text-xs text-gray-500">${subject.description}</span>` : ''}
                    </div>
                    <button onclick="editSubject(${subject.id})" 
                            class="bg-yellow-500 text-white px-2 py-0.5 rounded hover:bg-yellow-600 transition-all duration-200 text-xs">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
            `).join('');
        })
        .catch(error => {
            console.error('Error loading subjects:', error);
            showErrorMessage('Failed to load subjects');
        });
}

// Add new subject
document.getElementById('addSubjectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Adding...';
    submitButton.disabled = true;

    fetch('/subjects', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessMessage(data.message);
            this.reset();
            loadSubjects(); // Refresh the list
            updateSubjectDropdown(); // Update the assignment dropdown
        } else {
            throw new Error(data.message || 'Failed to add subject');
        }
    })
    .catch(error => {
        showErrorMessage('Failed to add subject: ' + error.message);
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
});

// Update subject dropdown in assignment form
function updateSubjectDropdown() {
    fetch('/subjects')
        .then(response => response.json())
        .then(subjects => {
            const subjectSelect = document.getElementById('subject_id');
            if (subjectSelect) {
                // Store current selection
                const currentValue = subjectSelect.value;
                
                // Clear and repopulate options
                subjectSelect.innerHTML = '<option value="">Select a subject</option>';
                subjects.forEach(subject => {
                    const option = document.createElement('option');
                    option.value = subject.id;
                    option.textContent = subject.name;
                    subjectSelect.appendChild(option);
                });
                
                // Restore selection if still valid
                if (currentValue && subjects.find(s => s.id == currentValue)) {
                    subjectSelect.value = currentValue;
                }
            }
        });
}





// Edit subject function - complete implementation
function editSubject(subjectId) {
    // First, fetch the subject data
    fetch(`/subjects/${subjectId}`)
        .then(response => response.json())
        .then(subject => {
            // Populate the edit form with current data
            document.getElementById('editSubjectId').value = subject.id;
            document.getElementById('editSubjectName').value = subject.name;
            document.getElementById('editSubjectCode').value = subject.code || '';
            document.getElementById('editSubjectDescription').value = subject.description || '';
            
            // Show the edit modal
            openModal('editSubjectModal');
        })
        .catch(error => {
            console.error('Error fetching subject:', error);
            showErrorMessage('Failed to load subject data');
        });
}

// Update subject
document.getElementById('editSubjectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const subjectId = document.getElementById('editSubjectId').value;
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Updating...';
    submitButton.disabled = true;

    fetch(`/subjects/${subjectId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest',
            'X-HTTP-Method-Override': 'PUT' // For PUT method
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessMessage(data.message);
            closeModal('editSubjectModal');
            loadSubjects(); // Refresh the list
            updateSubjectDropdown(); // Update assignment dropdown
        } else {
            throw new Error(data.message || 'Failed to update subject');
        }
    })
    .catch(error => {
        showErrorMessage('Failed to update subject: ' + error.message);
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
});


</script>
@endsection
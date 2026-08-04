<?php

namespace App\Livewire\Admin\Students;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Student;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;

class Index extends Component
{

    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'tailwind';




    /* -------------------------
        UI State
    --------------------------*/
    public $status = 'candidate';
    public $search = '';
    public $intake = '';
    public $shift = '';
    public $grade = '';
    public $showAddModal = false;
    public $loadingStudentId = null; // for my loading when switching among the status

    /* -------------------------
        Student Form Fields
    --------------------------*/
    public $name;
    public $age;
    public $gender;
    public $parent_phone;
    public $class_applying_for;
    public $date_of_admission;

    // Optional uploads
    public $image;
    public $transcript;
    public $recommendation_letter;

    /* -------------------------
        Reactive helpers
    --------------------------*/
    public function updatedStatus()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedIntake()
    {
        $this->resetPage();
    }
    public function updatedShift()
    {
        $this->resetPage();
    }

    /* -------------------------
        Store Student
    --------------------------*/
    public function storeStudent()
    {
        if (!auth()->user()->can('manage students')) {
            abort(403);
        }
        $this->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:5|max:25',
            'gender' => 'required|in:Male,Female,Other',
            'parent_phone' => 'required|string|max:15',
            'class_applying_for' => 'required|string|max:100',
            'date_of_admission' => 'required|date',

            'image' => 'nullable|image|max:2048',
            'transcript' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'recommendation_letter' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = [
            'name' => $this->name,
            'age' => $this->age,
            'gender' => $this->gender,
            'parent_phone' => $this->parent_phone,
            'class_applying_for' => $this->class_applying_for,
            'date_of_admission' => $this->date_of_admission,
            'status' => 'candidate',
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('students/images', 'public');
        }

        if ($this->transcript) {
            $data['transcript'] = $this->transcript->store('students/transcripts', 'public');
        }

        if ($this->recommendation_letter) {
            $data['recommendation_letter'] =
                $this->recommendation_letter->store('students/recommendations', 'public');
        }

        Student::create($data);

        $this->reset([
            'name',
            'age',
            'gender',
            'parent_phone',
            'class_applying_for',
            'date_of_admission',
            'image',
            'transcript',
            'recommendation_letter',
            'showAddModal',
        ]);

        // ✅ ADDED
        $this->dispatch('student-added', message: 'Student added successfully!');
    }

    /* -------------------------
        Status   Confirmation State & Delete Buttons
    --------------------------*/

    public $confirmingStatusId = null; // student ID being confirmed
    public $pendingStatus = null;      // status to apply
    // NEW
    public $selectedShift = '';
    public $selectedIntake = '';


    public function mount()
    {
        $this->confirmingStatusId = null;
        $this->pendingStatus = null;
        $this->statusCounts = Student::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
    }

    /* -------------------------
    Open Confirmation Modal
--------------------------*/
    public function confirmStatusChange($studentId, $newStatus)
    {
        if (!auth()->user()->can('manage students')) {
            abort(403);
        }

        $this->confirmingStatusId = $studentId;
        $this->pendingStatus = $newStatus;

        // Reset only for registration
        if ($newStatus === 'registered') {
            $this->selectedShift = '';
            $this->selectedIntake = '';
        }
    }


    /* -------------------------
    Apply Status Change
--------------------------*/
    public function applyConfirmedStatus()
    {
        if (!$this->confirmingStatusId || !$this->pendingStatus) {
            return;
        }

        $student = Student::findOrFail($this->confirmingStatusId);

        // 👇 Registration requires shift + intake
        if ($this->pendingStatus === 'registered') {
            if (!$this->selectedShift || !$this->selectedIntake) {
                $this->dispatch(
                    'notify',
                    message: 'Please select Shift and Intake before confirming.',
                    type: 'error'
                );
                return;
            }

            $student->update([
                'status' => 'registered',
                'shift'  => $this->selectedShift,
                'intake' => $this->selectedIntake,
            ]);
        } else {
            // All other statuses
            $student->update([
                'status' => $this->pendingStatus,
            ]);
        }

        // Reset state
        $this->confirmingStatusId = null;
        $this->pendingStatus = null;
        $this->selectedShift = '';
        $this->selectedIntake = '';

        $this->dispatch('close-register');
        $this->dispatch(
            'notify',
            message: 'Student updated successfully!',
            type: 'success'
        );
    }


    /* -------------------------
    Existing Logic (UNCHANGED)
--------------------------*/
    public function changeStatus(Student $student, $newStatus)
    {
        $this->loadingStudentId = $student->id;

        // Small delay allows spinner to render
        usleep(800000); // 0.8 seconds

        $student->update(['status' => $newStatus]);

        $this->loadingStudentId = null;

        $this->dispatch(
            'notify',
            message: 'Student status updated successfully!',
            type: 'success'
        );
    }



    public function deleteStudent()
    {
        Student::findOrFail($this->deleteStudentId)->delete();

        $this->showDeleteModal = false;

        $this->dispatch(
            'notify',
            message: 'Student deleted successfully!',
            type: 'success'
        );
    }


    public $showDeleteModal = false;
    public $deleteStudentId;
    public $deleteStudentName;

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete students')) {
            abort(403);
        }

        $student = Student::findOrFail($id);

        $this->deleteStudentId = $student->id;
        $this->deleteStudentName = $student->name;
        $this->showDeleteModal = true;
    }

    /* -------------------------
        Render
    --------------------------*/

    protected $queryString = [];

    public function updating($property)
    {
        $this->resetPage();
    }


    public function render()
    {
        $students = Student::query()
            ->where('status', $this->status)

            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('student_id', 'like', "%{$this->search}%");
                });
            })

            ->when($this->intake, fn($q) => $q->where('intake', $this->intake))

            ->when($this->shift, fn($q) => $q->where('shift', $this->shift))

            ->when($this->grade, fn($q) => $q->where('class_applying_for', $this->grade))

            ->latest()
            ->paginate(10);

        $grades  = Student::whereNotNull('class_applying_for')->distinct()->pluck('class_applying_for');
        $intakes = Student::whereNotNull('intake')->distinct()->pluck('intake');
        $shifts  = Student::whereNotNull('shift')->distinct()->pluck('shift');

        return view('livewire.admin.students.index', [
            'students'   => $students,
            'grades'     => $grades,
            'intakes'    => $intakes,
            'shifts'     => $shifts,

            'canManage'  => auth()->user()->can('manage students'),
            'canView'    => auth()->user()->can('view student details'),
            'canEdit'    => auth()->user()->can('edit students'),
            'canDelete'  => auth()->user()->can('delete students'),
        ]);
    }



    // =========================
    // Edit Modal Functionality
    // =========================

    public $showEditModal = false;
    public $edit_student_id;
    public $edit_name;
    public $edit_age;
    public $edit_gender;
    public $edit_parent_phone;
    public $edit_class_applying_for;
    public $edit_date_of_admission;
    public $edit_image;
    public $edit_transcript;
    public $edit_recommendation_letter;
    public $edit_intake;

    public function editStudent($id)
    {
        if (!auth()->user()->can('edit students')) {
            abort(403);
        }
        $student = Student::findOrFail($id);

        $this->edit_student_id = $student->id;
        $this->edit_name = $student->name;
        $this->edit_age = $student->age;
        $this->edit_gender = $student->gender;
        $this->edit_parent_phone = $student->parent_phone;
        $this->edit_class_applying_for = $student->class_applying_for;
        $this->edit_date_of_admission = $student->date_of_admission->format('Y-m-d');
        $this->edit_intake = $student->intake;

        $this->edit_image = null;
        $this->edit_transcript = null;
        $this->edit_recommendation_letter = null;

        $this->showEditModal = true;
    }


    public function updateStudent()
    {
        $this->validate([
            'edit_name' => 'required|string|max:255',
            'edit_age' => 'required|integer|min:1',
            'edit_gender' => 'required',
            'edit_parent_phone' => 'required|string|max:30',
            'edit_class_applying_for' => 'required',
            'edit_date_of_admission' => 'required|date',
            'edit_intake' => 'required|exists:academic_years,name',

            'edit_image' => 'nullable|image|max:2048',
            'edit_transcript' => 'nullable|file|max:4096',
            'edit_recommendation_letter' => 'nullable|file|max:4096',
        ]);

        $student = Student::findOrFail($this->edit_student_id);

        $student->name = $this->edit_name;
        $student->age = $this->edit_age;
        $student->gender = $this->edit_gender;
        $student->parent_phone = $this->edit_parent_phone;
        $student->class_applying_for = $this->edit_class_applying_for;
        $student->date_of_admission = $this->edit_date_of_admission;

        // NEW
        $student->intake = $this->edit_intake;

        if ($this->edit_image) {
            $student->image = $this->edit_image->store('students', 'public');
        }

        if ($this->edit_transcript) {
            $student->transcript = $this->edit_transcript->store('students', 'public');
        }

        if ($this->edit_recommendation_letter) {
            $student->recommendation_letter = $this->edit_recommendation_letter->store('students', 'public');
        }

        $student->save();

        $this->showEditModal = false;

        $this->dispatch('student-updated', message: 'Student updated successfully!');
    }

    // View modal state
    public $showViewModal = false;

    // View-only fields
    public $view_student_id;
    public $view_name;
    public $view_age;
    public $view_gender;
    public $view_parent_phone;
    public $view_class;
    public $view_date;
    public $view_image;
    public $view_transcript;
    public $view_recommendation_letter;
    public $view_status;
    public $view_last_school_attended;
    public $view_student_type;

    public function viewStudent($id)
    {
        if (!auth()->user()->can('view student details')) {
            abort(403);
        }

        $student = Student::findOrFail($id);

        $this->view_student_id   = $student->id;
        $this->view_name         = $student->name;
        $this->view_age          = $student->age;
        $this->view_gender       = $student->gender;
        $this->view_parent_phone = $student->parent_phone;
        $this->view_class        = $student->class_applying_for;
        $this->view_last_school_attended        = $student->last_school_attended;
        $this->view_student_type       = $student->student_type;
        $this->view_date         = optional($student->date_of_admission)->format('Y-m-d');

        $this->view_image = $student->image;
        $this->view_transcript = $student->transcript;
        $this->view_recommendation_letter = $student->recommendation_letter;
        $this->view_status = $student->status;

        $this->showViewModal = true;
        // Load student's financial summary and payment history
        $this->loadStudentFeeHistory($student->student_id);
    }


    // Student Fees Summary
    public $feeSummary = [
        'assigned' => 0,
        'paid' => 0,
        'balance' => 0,
        'last_payment' => null,
    ];

    // Student Payment History
    public $viewPaymentHistory = [];

    protected function loadStudentFeeHistory(string $studentId): void
    {
        $assignments = \App\Models\FeeAssignment::where('student_id', $studentId)
            ->with([
                'feeCategory',
                'payments.recordedBy',
                'payments.assignment.feeCategory',
            ])
            ->get();

        $payments = $assignments
            ->flatMap(fn($assignment) => $assignment->payments)
            ->sortByDesc('payment_date')
            ->values();

        $this->viewPaymentHistory = $payments;

        $this->feeSummary = [
            'assigned'    => $assignments->sum('amount'),
            'paid'        => $payments->sum('amount_paid'),
            'balance'     => $assignments->sum(fn($assignment) => $assignment->balance()),
            'last_payment' => optional($payments->first())->payment_date,
        ];
    }

    /* -------------------------
    Status Count Badge  and Download student and export to excel doc
--------------------------*/
    public $statusCounts = [];

    public function exportExcel()
    {
        return Excel::download(new StudentsExport(
            $this->status,
            $this->search,
            $this->intake,
            $this->shift
        ), 'students.xlsx');
    }



    public $showSmsModal = false;
    public $message = '';
    public $selectedParents = [];

    // Open modal
    public function openSmsModal()
    {
        if (empty($this->selectedParents)) {
            $this->dispatch('alert', message: 'Please select at least one parent to message!');
            return;
        }

        $this->showSmsModal = true;
    }

    // Send WhatsApp (Livewire 4)
    public function sendWhatsapp()
    {
        $numbers = Student::whereIn('id', $this->selectedParents)
            ->pluck('parent_phone')
            ->filter()
            ->toArray();

        if (empty($numbers)) {
            $this->dispatch('alert', message: 'No parent phone numbers found');
            return;
        }

        // Professional Header & Footer
        $header = "📢 ED MOL MEMORIAL MATADI BAPTIST HIGH SCHOOL\n"
            . "New Matadi Estate Drive, Opposite Don Bosco Youth Center\n"
            . "P.O. Box: 4330 Monrovia, Liberia\n\n";

        $footer = "\n\nRegards,\nSchool Administration\n"
            . "ED MOL Memorial Matadi Baptist High School";

        $fullMessage = urlencode($header . $this->message . $footer);

        $this->dispatch(
            'open-whatsapp',
            numbers: $numbers,
            message: $fullMessage
        );

        // Reset
        $this->message = '';
        $this->showSmsModal = false;
    }
}

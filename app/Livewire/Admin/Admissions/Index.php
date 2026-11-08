<?php

namespace App\Livewire\Admin\Admissions;

use App\Models\Admission;
use App\Models\Grade;
use App\Models\AcademicYear;
use App\Mail\StudentAdmissionAccepted;
use App\Support\AfricanPhoneCountries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'tailwind';

    public string $status = 'pending';
    public string $search = '';
    public string $academicYearId = '';
    public $gradeFilter = '';

    public function updatedAcademicYearId()   // NEW
    {
        $this->resetPage();
    }

    public function updatedGradeFilter()   // ← ADD THIS WHOLE METHOD
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }

    protected function currentSchoolId(): ?int
    {
        return auth()->user()->school_id;
    }

    protected function ensureSchoolContext(): bool
    {
        if (! $this->currentSchoolId()) {
            $this->dispatch('notify', message: 'Admissions are managed per school. Log in as a school account to continue.', type: 'error');
            return false;
        }
        return true;
    }

    /* -------------------------
        Create Admission
    --------------------------*/
    public bool $showAddModal = false;
    public $applicant_name, $age, $gender, $parent_phone, $grade_id, $student_type = 'New', $last_school_attended;
    public string $parentPhoneCountry = AfricanPhoneCountries::DEFAULT_COUNTRY;
    public string $parentPhoneNational = '';
    public $image, $transcript, $recommendation_letter;

    public function openCreateModal()
    {
        if (! auth()->user()->can('manage admissions')) abort(403);
        if (! $this->ensureSchoolContext()) return;

        $this->reset(['applicant_name', 'age', 'gender', 'parent_phone', 'parentPhoneCountry', 'parentPhoneNational', 'grade_id', 'last_school_attended', 'image', 'transcript', 'recommendation_letter']);
        $this->student_type = 'New';
        $this->showAddModal = true;
    }

    public function closeCreateModal()
    {
        $this->showAddModal = false;
        $this->resetErrorBag();
    }

    public function storeAdmission()
    {
        if (! auth()->user()->can('manage admissions')) abort(403);
        if (! $this->ensureSchoolContext()) return;

        $africanPhoneCountries = $this->africanPhoneCountries();
        $rules = [
            'applicant_name' => 'required|string|max:255',
            'age' => 'required|integer|min:3|max:25',
            'gender' => 'required|in:Male,Female,Other',
            'grade_id' => 'required|exists:grades,id',
            'student_type' => 'required|in:New,Old,Transfer',
            'last_school_attended' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'transcript' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'recommendation_letter' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ];

        if ($africanPhoneCountries) {
            $rules['parentPhoneCountry'] = ['required', Rule::in(array_column($africanPhoneCountries, 'code'))];
            $rules['parentPhoneNational'] = ['required', 'string', 'max:15', 'regex:/^\d+$/'];
            $this->validate($rules);

            $selectedCountry = collect($africanPhoneCountries)->firstWhere('code', $this->parentPhoneCountry);
            $this->parent_phone = $selectedCountry['dial_code'] . ltrim($this->parentPhoneNational, '0');
            $this->validate([
                'parent_phone' => ['required', 'string', 'max:15', 'regex:/^\+[1-9]\d{6,13}$/'],
            ]);
        } else {
            $rules['parent_phone'] = 'required|string|max:15';
            $this->validate($rules);
        }

        $service = new \App\Services\RegistrationIdService();

        Admission::create([
            'school_id' => $this->currentSchoolId(),
            'admission_number' => $service->generateForAdmission(),
            'applicant_name' => $this->applicant_name,
            'age' => $this->age,
            'gender' => $this->gender,
            'parent_phone' => $this->parent_phone,
            'grade_id' => $this->grade_id,
            'academic_year_id' => $this->academicYearId ?: (AcademicYear::where('school_id', $this->currentSchoolId())->where('is_active', true)->value('id')), // NEW
            'student_type' => $this->student_type,
            'last_school_attended' => $this->last_school_attended,
            'image' => $this->image?->store('admissions/images', 'public'),
            'transcript' => $this->transcript?->store('admissions/transcripts', 'public'),
            'recommendation_letter' => $this->recommendation_letter?->store('admissions/recommendations', 'public'),
            'status' => 'pending',
        ]);
        $this->showAddModal = false;
        $this->dispatch('notify', message: 'Admission application submitted.', type: 'success');
    }


    /* -------------------------
        Admit — creates the student's login account + profile + enrollment
    --------------------------*/
    public bool $showAdmitModal = false;
    public $admitAdmissionId;
    public $admitAcademicYearId = '';
    public $admitEmail = '';
    public $admitPassword = '';
    public $admitPassword_confirmation = '';
    public string $admitDate = '';

    public function confirmAdmit(int $id)
    {
        if (! auth()->user()->can('manage admissions')) abort(403);

        $admission = Admission::where('school_id', $this->currentSchoolId())->findOrFail($id);

        if ($admission->status !== 'pending') {
            $this->dispatch('notify', message: 'Only pending admissions can be admitted.', type: 'error');
            return;
        }

        $this->admitAdmissionId = $id;
        $this->admitAcademicYearId = AcademicYear::where('school_id', $this->currentSchoolId())->where('is_active', true)->value('id') ?? '';
        $this->admitEmail = '';
        $this->admitPassword = '';
        $this->admitPassword_confirmation = '';
        $this->admitDate = now()->toDateString();
        $this->showAdmitModal = true;
    }

    public function admitApplicant()
    {
        if (! auth()->user()->can('manage admissions')) abort(403);

        $this->validate([
            'admitAcademicYearId' => 'required|exists:academic_years,id',
            'admitEmail' => 'required|email|unique:users,email',
            'admitPassword' => 'required|confirmed',
            'admitDate' => 'required|date|before_or_equal:today',
        ], [], [
            'admitPassword' => 'password',
        ]);

        $admission = Admission::findOrFail($this->admitAdmissionId);
        $temporaryPassword = $this->admitPassword;
        $student = DB::transaction(function () use ($admission, $temporaryPassword) {
            $student = $admission->admit(
                auth()->user(),
                $this->admitAcademicYearId,
                $this->admitEmail,
                $temporaryPassword,
            );

            $admission->date_of_admission = $this->admitDate;
            $admission->save();

            return $student;
        });

        $this->showAdmitModal = false;

        $emailFailed = false;

        try {
            $admission->refresh()->load(['school', 'grade']);
            $student->load(['user', 'enrollment.academicYear', 'enrollment.grade']);

            Mail::to($student->user->email)->send(new StudentAdmissionAccepted(
                $admission,
                $student->user,
                $student->enrollment?->academicYear?->name ?? '',
                $student->enrollment?->grade
                    ? trim($student->enrollment->grade->level . ' ' . $student->enrollment->grade->section)
                    : '',
                $temporaryPassword,
            ));
        } catch (\Throwable $exception) {
            $emailFailed = true;
            $exceptionMessage = str_replace($temporaryPassword, '[redacted]', $exception->getMessage());

            Log::error('Student admission acceptance email failed.', [
                'admission_id' => $admission->id,
                'student_id' => $student->id,
                'exception' => $exceptionMessage,
            ]);
        }

        $message = $emailFailed
            ? "Applicant admitted, but the email could not be sent. Student login: {$student->user->registration_id}."
            : "Applicant admitted. Student login: {$student->user->registration_id}.";

        $this->dispatch('notify', message: $message, type: 'success');
    }

    public function useSystemDefaultPassword(): void
    {
        $password = config('app.default_student_password');
        $this->admitPassword = $password;
        $this->admitPassword_confirmation = $password;
        $this->dispatch('admit-default-password-set', password: $password);
    }

    public function selectParentPhoneCountry(string $code): void
    {
        $country = collect($this->africanPhoneCountries())->firstWhere('code', $code);

        if ($country) {
            $this->parentPhoneCountry = $country['code'];
        }
    }

    public function closeAdmitModal()
    {
        $this->showAdmitModal = false;
    }

    /* -------------------------
        Reject
    --------------------------*/
    public bool $showRejectModal = false;
    public $rejectAdmissionId;
    public $rejectReason = '';

    public function confirmReject(int $id)
    {
        if (! auth()->user()->can('manage admissions')) abort(403);
        $this->rejectAdmissionId = $id;
        $this->rejectReason = '';
        $this->showRejectModal = true;
    }

    public function rejectAdmission()
    {
        if (! auth()->user()->can('manage admissions')) abort(403);

        $this->validate(['rejectReason' => 'required|string|min:3']);

        $admission = Admission::where('school_id', $this->currentSchoolId())->findOrFail($this->rejectAdmissionId);
        $admission->reject(auth()->user(), $this->rejectReason);

        $this->showRejectModal = false;
        $this->dispatch('notify', message: 'Admission rejected.', type: 'success');
    }

    public function closeRejectModal()
    {
        $this->showRejectModal = false;
    }

    /* -------------------------
        Withdraw
    --------------------------*/
    public function withdrawAdmission(int $id)
    {
        if (! auth()->user()->can('manage admissions')) abort(403);

        $admission = Admission::where('school_id', $this->currentSchoolId())->findOrFail($id);

        if ($admission->status !== 'pending') {
            $this->dispatch('notify', message: 'Only pending admissions can be withdrawn.', type: 'error');
            return;
        }

        $admission->withdraw();
        $this->dispatch('notify', message: 'Admission withdrawn.', type: 'success');
    }

    /* -------------------------
        View
    --------------------------*/
    public bool $showViewModal = false;
    public $view_admission;

    public function viewAdmission(int $id)
    {
        if (! auth()->user()->can('view admission details')) abort(403);

        $this->view_admission = Admission::where('school_id', $this->currentSchoolId())
            ->with(['grade', 'reviewer'])
            ->findOrFail($id);

        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
    }



    /* -------------------------
    Audit Trail (reject/withdraw/other reasoned actions)
--------------------------*/
    public bool $showAuditModal = false;
    public $audit_record;

    public function viewAudit(int $id)
    {
        if (! auth()->user()->can('view admission details')) abort(403);

        $this->audit_record = Admission::where('school_id', $this->currentSchoolId())
            ->with(['grade', 'reviewer'])
            ->findOrFail($id);

        $this->showAuditModal = true;
    }

    public function closeAuditModal()
    {
        $this->showAuditModal = false;
        $this->audit_record = null;
    }
    public function render()
    {
        $africanPhoneCountries = $this->africanPhoneCountries();
        $selectedPhoneCountry = collect($africanPhoneCountries)->firstWhere('code', $this->parentPhoneCountry)
            ?? collect($africanPhoneCountries)->firstWhere('code', AfricanPhoneCountries::DEFAULT_COUNTRY);

        $admissions = Admission::where('school_id', $this->currentSchoolId())
            ->where('status', $this->status)
            ->when($this->academicYearId, function ($q) {
                $q->where('academic_year_id', $this->academicYearId);
            })
            ->when($this->gradeFilter, function ($q) {          // ← ADD THIS BLOCK
                $q->where('grade_id', $this->gradeFilter);
            })
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('applicant_name', 'like', "%{$this->search}%")
                        ->orWhere('admission_number', 'like', "%{$this->search}%");
                });
            })
            ->with('grade')
            ->latest()
            ->paginate(10);

        $grades = Grade::orderBy('level')->get();
        $academicYears = AcademicYear::where('school_id', $this->currentSchoolId())->where('is_active', true)->ordered()->get();

        $statusCounts = Admission::where('school_id', $this->currentSchoolId())
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $admitAdmission = $this->showAdmitModal && $this->admitAdmissionId
            ? Admission::where('school_id', $this->currentSchoolId())->find($this->admitAdmissionId)
            : null;

        return view('livewire.admin.admissions.index', [
            'admissions' => $admissions,
            'grades' => $grades,
            'academicYears' => $academicYears,
            'statusCounts' => $statusCounts,
            'africanPhoneCountries' => $africanPhoneCountries,
            'selectedPhoneCountry' => $selectedPhoneCountry,
            'phoneCountryPickerAvailable' => (bool) $africanPhoneCountries && (bool) $selectedPhoneCountry,
            'admitAdmission' => $admitAdmission,
            'canManage' => auth()->user()->can('manage admissions'),
            'canView' => auth()->user()->can('view admission details'),
        ]);
    }

    private function africanPhoneCountries(): array
    {
        return app(AfricanPhoneCountries::class)->all();
    }
}

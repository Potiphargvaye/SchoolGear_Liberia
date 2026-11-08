<?php

namespace App\Livewire\Admin\Students;

use App\Models\Student;
use App\Support\AfricanPhoneCountries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public Student $student;

    public string $activeTab = 'overview';

    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }

    public function mount(Student $student)
    {
        if ($student->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $this->student = $student->load(['user', 'admission', 'enrollment.grade', 'enrollment.academicYear', 'promotions.fromGrade', 'promotions.toGrade']);
    }

    /* -------------------------
        Edit — bio + account fields only
    --------------------------*/
    public bool $showEditModal = false;

    public $name, $age, $gender, $parent_phone;
    public string $parentPhoneCountry = AfricanPhoneCountries::DEFAULT_COUNTRY;
    public string $parentPhoneNational = '';
    public bool $parentPhoneUsesPicker = false;
    public $dateOfAdmission;
    public $image;
    public $email, $status;
    public $new_password, $new_password_confirmation;

    public function openEditModal()
    {
        if (! auth()->user()->can('edit students')) abort(403);

        $this->student->loadMissing('user', 'admission');

        $this->name = $this->student->name;
        $this->age = $this->student->age;
        $this->gender = $this->student->gender;
        $parsedPhone = app(AfricanPhoneCountries::class)->parse($this->student->parent_phone);
        $this->parentPhoneUsesPicker = (bool) $parsedPhone;
        $this->parent_phone = $parsedPhone ? null : $this->student->parent_phone;
        $this->parentPhoneCountry = $parsedPhone['country']['code'] ?? AfricanPhoneCountries::DEFAULT_COUNTRY;
        $this->parentPhoneNational = $parsedPhone['national_number'] ?? '';
        $this->image = null;
        $this->dateOfAdmission = $this->student->admission?->date_of_admission?->format('Y-m-d');

        $this->email = $this->student->user?->email;
        $this->status = $this->student->user?->status;
        $this->new_password = '';
        $this->new_password_confirmation = '';

        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetErrorBag();
    }

    public function useParentPhoneCountryPicker(): void
    {
        $this->parentPhoneUsesPicker = true;
        $this->parentPhoneCountry = AfricanPhoneCountries::DEFAULT_COUNTRY;
        $this->parentPhoneNational = '';
        $this->parent_phone = null;
    }

    public function useParentPhonePlainInput(): void
    {
        $countries = app(AfricanPhoneCountries::class)->all();
        $selectedCountry = collect($countries)->firstWhere('code', $this->parentPhoneCountry);
        $nationalNumber = ltrim($this->parentPhoneNational, '0');
        $this->parent_phone = $selectedCountry && $nationalNumber !== ''
            ? $selectedCountry['dial_code'] . $nationalNumber
            : '';
        $this->parentPhoneUsesPicker = false;
    }

    public function selectParentPhoneCountry(string $code): void
    {
        $country = collect(app(AfricanPhoneCountries::class)->all())->firstWhere('code', $code);

        if ($country) {
            $this->parentPhoneCountry = $country['code'];
        }
    }

    public function useSystemDefaultPassword(): void
    {
        $password = config('app.default_student_password');
        $this->new_password = $password;
        $this->new_password_confirmation = $password;
        $this->dispatch('student-default-password-set', password: $password);
    }

    public function updateStudent()
    {
        if (! auth()->user()->can('edit students')) abort(403);

        $rules = [
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:3|max:25',
            'gender' => 'required|in:Male,Female,Other',
            'image' => 'nullable|image|max:2048',
            'email' => 'required|email|unique:users,email,' . $this->student->user_id,
            'status' => 'required|in:active,inactive,suspended',
            'new_password' => 'nullable|string|min:8|confirmed',
        ];

        $phoneCountries = app(AfricanPhoneCountries::class)->all();

        if ($this->parentPhoneUsesPicker && $phoneCountries) {
            $rules['parentPhoneCountry'] = ['required', Rule::in(array_column($phoneCountries, 'code'))];
            $rules['parentPhoneNational'] = ['required', 'string', 'max:15', 'regex:/^\d+$/'];
            $this->validate($rules);

            $selectedCountry = collect($phoneCountries)->firstWhere('code', $this->parentPhoneCountry);
            $this->parent_phone = $selectedCountry['dial_code'] . ltrim($this->parentPhoneNational, '0');
            $this->validate([
                'parent_phone' => ['required', 'string', 'max:15', 'regex:/^\+[1-9]\d{6,13}$/'],
            ]);
        } else {
            $rules['parent_phone'] = 'required|string|max:15';
        }

        if ($this->student->admission) {
            $rules['dateOfAdmission'] = 'nullable|date|before_or_equal:today';
        }

        $this->validate($rules);

        $newImagePath = $this->image ? $this->image->store('students/images', 'public') : null;

        DB::transaction(function () use ($newImagePath) {
            $this->student->loadMissing('user', 'admission');
            $oldImagePath = $this->student->image;

            $this->student->user?->update([
                'email' => $this->email,
                'status' => $this->status,
                'password' => $this->new_password ? Hash::make($this->new_password) : $this->student->user->password,
                'image' => $newImagePath ?: $this->student->user->image,
            ]);

            $this->student->update([
                'name' => $this->name,
                'age' => $this->age,
                'gender' => $this->gender,
                'parent_phone' => $this->parent_phone,
                'image' => $newImagePath ?: $this->student->image,
            ]);

            if ($this->student->admission) {
                $this->student->admission->update([
                    'date_of_admission' => $this->dateOfAdmission,
                ]);
            }

            if ($newImagePath && $oldImagePath) {
                Storage::disk('public')->delete($oldImagePath);
            }
        });

        $this->student->refresh()->load(['user', 'admission', 'enrollment.grade', 'enrollment.academicYear']);
        $this->showEditModal = false;

        $this->dispatch('notify', message: 'Student profile updated successfully.', type: 'success');
    }

    public function render()
    {
        $africanPhoneCountries = app(AfricanPhoneCountries::class)->all();
        return view('livewire.admin.students.profile', [
            'canEdit' => auth()->user()->can('edit students'),
            'africanPhoneCountries' => $africanPhoneCountries,
            'phoneCountryPickerAvailable' => (bool) $africanPhoneCountries,
        ]);
    }
}

<?php

namespace App\Livewire\Admin\Schools;

use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'tailwind';

    /* -------------------------
        UI State
    --------------------------*/
    public $search = '';
    public $statusFilter = '';
    public $subscriptionFilter = '';
    public $showAddModal = false;
    public $showEditModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $showToggleModal = false;

    /* -------------------------
        Create: School fields
    --------------------------*/
    public $school_name;
    public $short_name = '';
    public $edit_short_name;
    public $school_email;
    public $phone;
    public $address;
    public $country = 'Liberia';
    public $city;
    public $logo;

    /* -------------------------
        Create: Owner account fields
    --------------------------*/
    public $owner_name;
    public $owner_email;
    public $owner_password;
    public $owner_password_confirmation;

    /* -------------------------
        Edit fields (school only — owner account is NOT re-editable here)
    --------------------------*/
    public $edit_school_id;
    public $edit_school_name;
    public $edit_email;
    public $edit_phone;
    public $edit_address;
    public $edit_country;
    public $edit_city;
    public $edit_logo;            // newly uploaded file (nullable)
    public $edit_current_logo;    // path of the existing logo, for modal header preview
    public $edit_status;
    public $edit_subscription_status;

    /* -------------------------
        View fields
    --------------------------*/
    public $view_school;

    /* -------------------------
        Delete
    --------------------------*/
    public $deleteSchoolId;
    public $deleteSchoolName;

    /* -------------------------
        Toggle Status (confirm-first)
    --------------------------*/
    public $toggleSchoolId;
    public $toggleSchoolName;
    public $toggleCurrentStatus;   // 'active' | 'disabled' — status BEFORE the toggle
    public $toggleTargetStatus;    // status that will be applied if confirmed

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSubscriptionFilter()
    {
        $this->resetPage();
    }

    /* -------------------------
        Create School + Owner
    --------------------------*/
    public function storeSchool()
    {
        if (!auth()->user()->can('create schools')) {
            abort(403);
        }

        $this->validate([
            'school_name' => 'required|string|max:255',
            'school_email' => 'required|email|unique:schools,email',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'logo' => 'nullable|image|max:2048',

            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email',
            'owner_password' => 'required|confirmed',

        ]);

        DB::transaction(function () {
            $logoPath = $this->logo ? $this->logo->store('schools/logos', 'public') : null;

            $service = new \App\Services\RegistrationIdService();

            /*
            |--------------------------------------------------------------------------
            | 1. Create School with its own unique registration ID
            |--------------------------------------------------------------------------
            */
            $schoolRegistrationId = $service->generateForSchool();

            $school = School::create([
                'registration_id' => $schoolRegistrationId,
                'school_name' => $this->school_name,
                'short_name' => $this->short_name ?: null,
                'email' => $this->school_email,
                'phone' => $this->phone,
                'logo' => $logoPath,
                'address' => $this->address,
                'country' => $this->country ?: 'Liberia',
                'city' => $this->city,
                'trial_start_date' => now()->toDateString(),
                'trial_end_date' => now()->addMonths(3)->toDateString(),
                'subscription_status' => 'trial',
                'status' => 'active',
            ]);

            /*
            |--------------------------------------------------------------------------
            | 2. Create the Owner/User account — same convention as staff accounts
            |--------------------------------------------------------------------------
            */
            $userRegistrationId = $service->generateForStaff();

            $owner = User::create([
                'school_id' => $school->id,
                'registration_id' => $userRegistrationId,
                'name' => $this->owner_name,
                'email' => $this->owner_email,
                'password' => Hash::make($this->owner_password),
                'status' => 'active',
                'created_by' => auth()->id(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | 3. Assign Owner role via existing Spatie system
            |--------------------------------------------------------------------------
            */
            $owner->assignRole('Owner');

            /*
            |--------------------------------------------------------------------------
            | 4. Link the School to its Owner
            |--------------------------------------------------------------------------
            */
            $school->owner_user_id = $owner->id;
            $school->save();
        });

        $this->reset(['school_name', 'school_email', 'phone', 'address', 'city', 'logo', 'owner_name', 'owner_email', 'owner_password', 'owner_password_confirmation', 'showAddModal']);
        $this->country = 'Liberia';

        $this->dispatch('notify', message: 'School and Owner account created successfully!', type: 'success');
    }

    /* -------------------------
        View
    --------------------------*/
    public function viewSchool($id)
    {
        if (!auth()->user()->can('view schools')) {
            abort(403);
        }

        $this->view_school = School::with('owner')->findOrFail($id);
        $this->showViewModal = true;
    }

    /* -------------------------
        Edit (school info only)
    --------------------------*/
    public function editSchool($id)
    {
        if (!auth()->user()->can('edit schools')) {
            abort(403);
        }

        $school = School::findOrFail($id);

        $this->edit_school_id = $school->id;
        $this->edit_school_name = $school->school_name;
        $this->edit_short_name = $school->short_name;   // ← ADD THIS LINE
        $this->edit_email = $school->email;
        $this->edit_phone = $school->phone;
        $this->edit_address = $school->address;
        $this->edit_country = $school->country;
        $this->edit_city = $school->city;
        $this->edit_status = $school->status;
        $this->edit_subscription_status = $school->subscription_status;
        $this->edit_current_logo = $school->logo;
        $this->edit_logo = null;

        $this->showEditModal = true;
    }

    public function updateSchool()
    {
        if (!auth()->user()->can('edit schools')) {
            abort(403);
        }

        $this->validate([
            'edit_school_name' => 'required|string|max:255',
            'edit_short_name' => 'nullable|string|max:20',   // ← ADD THIS LINE
            'edit_email' => 'required|email|unique:schools,email,' . $this->edit_school_id,
            'edit_phone' => 'nullable|string|max:30',
            'edit_address' => 'nullable|string|max:255',
            'edit_country' => 'nullable|string|max:100',
            'edit_city' => 'nullable|string|max:100',
            'edit_logo' => 'nullable|image|max:2048',
            'edit_status' => 'required|in:active,disabled',
            'edit_subscription_status' => 'required|in:trial,active,past_due,cancelled',
        ]);

        $school = School::findOrFail($this->edit_school_id);

        $data = [
            'school_name' => $this->edit_school_name,
            'short_name' => $this->edit_short_name ?: null,   // ← ADD THIS LINE
            'email' => $this->edit_email,
            'phone' => $this->edit_phone,
            'address' => $this->edit_address,
            'country' => $this->edit_country,
            'city' => $this->edit_city,
            'status' => $this->edit_status,
            'subscription_status' => $this->edit_subscription_status,
        ];

        if ($this->edit_logo) {
            $data['logo'] = $this->edit_logo->store('schools/logos', 'public');
        }

        $school->update($data);

        $this->showEditModal = false;
        $this->dispatch('notify', message: 'School updated successfully!', type: 'success');
    }

    /* -------------------------
        Live logo preview while a new file is chosen in the Edit modal
    --------------------------*/
    public function updatedEditLogo()
    {
        $this->validateOnly('edit_logo', [
            'edit_logo' => 'nullable|image|max:2048',
        ]);
    }

    /* -------------------------
        Toggle Status — now confirm-first, same UX as Delete
    --------------------------*/
    public function confirmToggleStatus($id)
    {
        if (!auth()->user()->can('edit schools')) {
            abort(403);
        }

        $school = School::findOrFail($id);

        $this->toggleSchoolId = $school->id;
        $this->toggleSchoolName = $school->school_name;
        $this->toggleCurrentStatus = $school->status;
        $this->toggleTargetStatus = $school->status === 'active' ? 'disabled' : 'active';

        $this->showToggleModal = true;
    }

    public function toggleStatus()
    {
        if (!auth()->user()->can('edit schools')) {
            abort(403);
        }

        $school = School::findOrFail($this->toggleSchoolId);
        $school->status = $this->toggleTargetStatus;
        $school->save();

        $this->showToggleModal = false;

        $this->dispatch(
            'notify',
            message: 'School ' . ($school->status === 'active' ? 'enabled' : 'disabled') . ' successfully!',
            type: 'success'
        );
    }

    /* -------------------------
        Delete (soft delete)
    --------------------------*/
    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete schools')) {
            abort(403);
        }

        $school = School::findOrFail($id);
        $this->deleteSchoolId = $school->id;
        $this->deleteSchoolName = $school->school_name;
        $this->showDeleteModal = true;
    }

    public function deleteSchool()
    {
        if (!auth()->user()->can('delete schools')) {
            abort(403);
        }

        School::findOrFail($this->deleteSchoolId)->delete();

        $this->showDeleteModal = false;
        $this->dispatch('notify', message: 'School deleted successfully!', type: 'success');
    }

    public function render()
    {
        $schools = School::query()
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('school_name', 'like', "%{$this->search}%")
                        ->orWhere('registration_id', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->subscriptionFilter, fn($q) => $q->where('subscription_status', $this->subscriptionFilter))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.schools.index', [
            'schools' => $schools,
            'totalSchools' => School::count(),
            'activeSchools' => School::where('status', 'active')->count(),
            'trialSchools' => School::where('subscription_status', 'trial')->count(),
            'disabledSchools' => School::where('status', 'disabled')->count(),
            'canCreate' => auth()->user()->can('create schools'),
            'canEdit' => auth()->user()->can('edit schools'),
            'canDelete' => auth()->user()->can('delete schools'),
        ]);
    }
}

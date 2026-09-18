<?php


namespace App\Livewire\Public;

use App\Models\School;
use App\Models\User;
use App\Services\RegistrationIdService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;   // ← ADD THIS LINE



class SchoolRegistration extends Component
{
    use WithFileUploads;
    public int $step = 1;

    // Step 1 — School Information
    public $school_name;
    public $short_name;
    public $school_email;
    public $phone;
    public $address;
    public $country = 'Liberia';
    public $city;
    public $logo;              // ← ADD THIS LINE


    // Step 2 — School Owner Details
    public $owner_name;
    public $owner_email;
    public $owner_password;
    public $owner_password_confirmation;

    public bool $submitting = false;

    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'school_name' => 'required|string|max:255',
                'short_name' => 'nullable|string|max:20',
                'school_email' => 'required|email|unique:schools,email',
                'phone' => 'nullable|string|max:30',
                'address' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:100',
                'city' => 'nullable|string|max:100',
                'logo' => 'nullable|image|max:2048',           // ← ADD THIS LINE
            ],
            2 => [
                'owner_name' => 'required|string|max:255',
                'owner_email' => 'required|email|unique:users,email',
                'owner_password' => 'required|min:8|confirmed',
            ],
            default => [],
        };
    }

    public function nextStep(): void
    {
        $this->validate($this->rulesForStep($this->step));
        $this->step++;
    }

    public function previousStep(): void
    {
        $this->step--;
    }
    public function updatedLogo()   // ← ADD THIS WHOLE METHOD
    {
        $this->validateOnly('logo', [
            'logo' => 'nullable|image|max:2048',
        ]);
    }

    public function register()
    {
        // Re-validate everything on final submit, in case of tampering
        // or the user navigating steps out of order.
        $this->validate(array_merge($this->rulesForStep(1), $this->rulesForStep(2)));

        $this->submitting = true;

        DB::transaction(function () {
            $service = new RegistrationIdService();

            $school = School::create([
                'registration_id' => $service->generateForSchool(),
                'school_name' => $this->school_name,
                'short_name' => $this->short_name ?: null,   // ← ADD THIS LINE
                'email' => $this->school_email,
                'phone' => $this->phone,
                'address' => $this->address,
                'country' => $this->country ?: 'Liberia',
                'city' => $this->city,
                'logo' => $this->logo ? $this->logo->store('schools/logos', 'public') : null,
                'trial_start_date' => now()->toDateString(),
                'trial_end_date' => now()->addMonths(3)->toDateString(),
                'subscription_status' => 'trial',
                'status' => 'active',
            ]);

            $owner = User::create([
                'school_id' => $school->id,
                'registration_id' => $service->generateForStaff(),
                'name' => $this->owner_name,
                'email' => $this->owner_email,
                'password' => Hash::make($this->owner_password),
                'status' => 'active',
                'created_by' => null, // self-registered — no admin account created this
            ]);

            $owner->assignRole('Owner');

            $school->owner_user_id = $owner->id;
            $school->save();
        });

        // Reuses the login page's existing session('status') banner —
        // no changes needed to login.blade.php.
        session()->flash('success', 'Registration successful! Your school account has been created. You can now log in.');

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.public.school-registration');
    }
}

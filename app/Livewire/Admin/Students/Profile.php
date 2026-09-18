<?php

namespace App\Livewire\Admin\Students;

use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
    public $image;
    public $email, $status;
    public $new_password, $new_password_confirmation;

    public function openEditModal()
    {
        if (! auth()->user()->can('edit students')) abort(403);

        $this->student->loadMissing('user');

        $this->name = $this->student->name;
        $this->age = $this->student->age;
        $this->gender = $this->student->gender;
        $this->parent_phone = $this->student->parent_phone;
        $this->image = null;

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

    public function updateStudent()
    {
        if (! auth()->user()->can('edit students')) abort(403);

        $this->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:3|max:25',
            'gender' => 'required|in:Male,Female,Other',
            'parent_phone' => 'required|string|max:15',
            'image' => 'nullable|image|max:2048',
            'email' => 'required|email|unique:users,email,' . $this->student->user_id,
            'status' => 'required|in:active,inactive,suspended',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $newImagePath = $this->image ? $this->image->store('students/images', 'public') : null;

        DB::transaction(function () use ($newImagePath) {
            $this->student->loadMissing('user');
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
        return view('livewire.admin.students.profile', [
            'canEdit' => auth()->user()->can('edit students'),
        ]);
    }
}

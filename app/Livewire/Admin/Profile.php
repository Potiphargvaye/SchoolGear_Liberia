<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';
    public $photo;
    public string $currentPassword = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(): void
    {
        $this->name = Auth::user()->name;
    }

    public function saveProfile()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = Auth::user();
        $oldPhotoPath = $user->image;
        $newPhotoPath = $this->photo?->store('profile-images', 'public');

        if ($this->photo && ! $newPhotoPath) {
            throw new \RuntimeException('Unable to store the profile photo.');
        }

        $updates = ['name' => $validated['name']];

        if ($newPhotoPath) {
            $updates['image'] = $newPhotoPath;
        }

        $user->update($updates);

        if ($newPhotoPath && $oldPhotoPath && Storage::disk('public')->exists($oldPhotoPath)) {
            if (! Storage::disk('public')->delete($oldPhotoPath)) {
                throw new \RuntimeException('Unable to remove the previous profile photo.');
            }
        }

        $this->photo = null;
        session()->flash('success', 'Profile updated successfully.');

        return redirect()->route('admin.profile');
    }

    public function removePhoto()
    {
        $user = Auth::user();
        $oldPhotoPath = $user->image;
        $user->update(['image' => null]);

        if ($oldPhotoPath && Storage::disk('public')->exists($oldPhotoPath)) {
            if (! Storage::disk('public')->delete($oldPhotoPath)) {
                throw new \RuntimeException('Unable to remove the profile photo.');
            }
        }

        $this->photo = null;
        session()->flash('success', 'Profile photo removed.');

        return redirect()->route('admin.profile');
    }

    public function updatePassword(): void
    {
        $validated = $this->validate([
            'currentPassword' => ['required', 'current_password'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        session()->put('password_hash_' . Auth::getDefaultDriver(), $user->getAuthPassword());

        $this->reset(['currentPassword', 'password', 'password_confirmation']);
        $this->dispatch('profile-password-cleared');
        $this->dispatch('notify', message: 'Password updated successfully.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.profile', [
            'user' => Auth::user()->load('school'),
            'roles' => Auth::user()->getRoleNames(),
        ]);
    }
}

<?php

namespace App\Livewire\Admin\Settings;

use App\Models\SchoolDocumentSettings;
use Livewire\Component;
use Livewire\WithFileUploads;

class DocumentSettings extends Component
{
    use WithFileUploads;

    // Shared branding
    public $document_name = '';
    public $address = '';
    public $po_box = '';
    public $phone = '';
    public $website = '';
    public $school_number = '';
    public $email = '';
    public $logo; // new upload, nullable
    public $currentLogoPath = null;

    // Footer
    public $footer_location_label = 'Our Location';
    public $footer_location = '';
    public $footer_call_label = 'Call Us';
    public $footer_call = '';
    public $footer_email_label = 'Email';
    public $footer_email = '';
    public $footer_note = '';

    // Per-document-type titles/captions
    public array $documentTypes = [
        'receipt' => 'Fee Receipt',
        'statement' => 'Fee Statement',
        'report_card' => 'Report Card',
        'admission_letter' => 'Admission Letter',
        'certificate' => 'Certificate',
    ];

    public array $titles = [];
    public array $captions = [];

    protected function currentSchoolId(): ?int
    {
        return auth()->user()->school_id;
    }

    /**
     * Load this school's saved document settings into the form fields.
     *
     * Without this, the form always starts blank — including right after a
     * save + page refresh. save() never wiped anything; a full page load
     * just re-mounts the component from scratch, and nothing was reading
     * the saved SchoolDocumentSettings row back into these properties.
     */
    public function mount()
    {
        $settings = SchoolDocumentSettings::where('school_id', $this->currentSchoolId())->first();

        if (! $settings) {
            return;
        }

        $this->document_name = $settings->document_name ?? '';
        $this->address = $settings->address ?? '';
        $this->po_box = $settings->po_box ?? '';
        $this->phone = $settings->phone ?? '';
        $this->website = $settings->website ?? '';
        $this->school_number = $settings->school_number ?? '';
        $this->email = $settings->email ?? '';
        $this->currentLogoPath = $settings->logo_path;

        $this->footer_location_label = $settings->footer_location_label ?? 'Our Location';
        $this->footer_location = $settings->footer_location ?? '';
        $this->footer_call_label = $settings->footer_call_label ?? 'Call Us';
        $this->footer_call = $settings->footer_call ?? '';
        $this->footer_email_label = $settings->footer_email_label ?? 'Email';
        $this->footer_email = $settings->footer_email ?? '';
        $this->footer_note = $settings->footer_note ?? '';

        $documentSettings = $settings->document_settings ?? [];
        foreach (array_keys($this->documentTypes) as $type) {
            $this->titles[$type] = $documentSettings[$type]['title'] ?? '';
            $this->captions[$type] = $documentSettings[$type]['caption'] ?? '';
        }
    }

    public function save()
    {
        if (! auth()->user()->can('manage document settings')) abort(403);

        if (! $this->currentSchoolId()) {
            $this->dispatch('notify', message: 'Please select a school or login before saving document branding settings.', type: 'error');
            return;
        }

        $this->validate([
            'document_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'po_box' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|string|max:255',
            'school_number' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|max:2048',
            'footer_location_label' => 'nullable|string|max:100',
            'footer_location' => 'nullable|string|max:255',
            'footer_call_label' => 'nullable|string|max:100',
            'footer_call' => 'nullable|string|max:255',
            'footer_email_label' => 'nullable|string|max:100',
            'footer_email' => 'nullable|string|max:255',
            'footer_note' => 'nullable|string|max:500',
        ]);

        $documentSettings = [];
        foreach (array_keys($this->documentTypes) as $type) {
            $documentSettings[$type] = [
                'title' => $this->titles[$type] ?? '',
                'caption' => $this->captions[$type] ?? '',
            ];
        }

        $settings = SchoolDocumentSettings::where('school_id', $this->currentSchoolId())->first();
        $logoPath = $this->logo ? $this->logo->store('branding/logos', 'public') : ($settings->logo_path ?? null);

        SchoolDocumentSettings::updateOrCreate(
            ['school_id' => $this->currentSchoolId()],
            [
                'document_name' => $this->document_name,
                'address' => $this->address,
                'po_box' => $this->po_box,
                'phone' => $this->phone,
                'website' => $this->website,
                'school_number' => $this->school_number,
                'email' => $this->email,
                'logo_path' => $logoPath,
                'footer_location_label' => $this->footer_location_label,
                'footer_location' => $this->footer_location,
                'footer_call_label' => $this->footer_call_label,
                'footer_call' => $this->footer_call,
                'footer_email_label' => $this->footer_email_label,
                'footer_email' => $this->footer_email,
                'footer_note' => $this->footer_note,
                'document_settings' => $documentSettings,
            ]
        );

        // Keep the form and logo preview showing exactly what was just
        // saved, without needing a refresh.
        $this->currentLogoPath = $logoPath;
        $this->logo = null;

        $this->dispatch('notify', message: 'Document branding settings saved.', type: 'success');
    }

    public function render()
    {
        // currentLogoPath is now a public property (set in mount() and kept
        // fresh in save()), so it no longer needs to be re-queried and
        // passed in here — it's already available to the view directly.
        return view('livewire.admin.settings.document-settings');
    }
}
